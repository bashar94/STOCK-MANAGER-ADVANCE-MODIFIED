<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transfers extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        if ($this->Customer || $this->Supplier) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->lang->admin_load('transfers', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->admin_model('transfers_model');
        $this->digital_upload_path = 'files/';
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size = '1024';
        $this->data['logo'] = true;
    }

    function index()
    {
        $this->sma->checkPermissions();

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('transfers')));
        $meta = array('page_title' => lang('transfers'), 'bc' => $bc);
        $this->page_construct('transfers/index', $meta, $this->data);
    }

    function getTransfers()
    {
        $this->sma->checkPermissions('index');

        $detail_link = anchor('admin/transfers/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('transfer_details'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('admin/transfers/email/$1', '<i class="fa fa-envelope"></i> ' . lang('email_transfer'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link = anchor('admin/transfers/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_transfer'));
        $pdf_link = anchor('admin/transfers/pdf/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $print_barcode = anchor('admin/products/print_barcodes/?transfer=$1', '<i class="fa fa-print"></i> ' . lang('print_barcodes'));
        $delete_link = "<a href='#' class='tip po' title='<b>" . lang("delete_transfer") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' id='a__$1' href='" . admin_url('transfers/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_transfer') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
            . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
            . lang('actions') . ' <span class="caret"></span></button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>' . $detail_link . '</li>
            <li>' . $edit_link . '</li>
            <li>' . $pdf_link . '</li>
            <li>' . $email_link . '</li>
            <li>' . $print_barcode . '</li>
            <li>' . $delete_link . '</li>
        </ul>
    </div></div>';

        $this->load->library('datatables');

        $this->datatables
            ->select("id, date, transfer_no, from_warehouse_name as fname, from_warehouse_code as fcode, to_warehouse_name as tname,to_warehouse_code as tcode, total, total_tax, grand_total, status, attachment")
            ->from('transfers')
            ->edit_column("fname", "$1 ($2)", "fname, fcode")
            ->edit_column("tname", "$1 ($2)", "tname, tcode");

        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $this->datatables->where('created_by', $this->session->userdata('user_id'));
        }

        $this->datatables->add_column("Actions", $action, "id")
            ->unset_column('fcode')
            ->unset_column('tcode');
        echo $this->datatables->generate();
    }

    function add()
    {
        $this->sma->checkPermissions();

        $this->form_validation->set_message('is_natural_no_zero', lang("no_zero_required"));
        $this->form_validation->set_rules('to_warehouse', lang("warehouse") . ' (' . lang("to") . ')', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('from_warehouse', lang("warehouse") . ' (' . lang("from") . ')', 'required|is_natural_no_zero');

        if ($this->form_validation->run()) {

            $transfer_no = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('to');
            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $to_warehouse = $this->input->post('to_warehouse');
            $from_warehouse = $this->input->post('from_warehouse');
            $note = $this->sma->clear_tags($this->input->post('note'));
            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $status = $this->input->post('status');
            $from_warehouse_details = $this->site->getWarehouseByID($from_warehouse);
            $from_warehouse_code = $from_warehouse_details->code;
            $from_warehouse_name = $from_warehouse_details->name;
            $to_warehouse_details = $this->site->getWarehouseByID($to_warehouse);
            $to_warehouse_code = $to_warehouse_details->code;
            $to_warehouse_name = $to_warehouse_details->name;

            $total = 0;
            $product_tax = 0;
            $gst_data = [];
            $total_cgst = $total_sgst = $total_igst = 0;
            $i = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_code = $_POST['product_code'][$r];
                $item_net_cost = $this->sma->formatDecimal($_POST['net_cost'][$r]);
                $unit_cost = $this->sma->formatDecimal($_POST['unit_cost'][$r]);
                $real_unit_cost = $this->sma->formatDecimal($_POST['real_unit_cost'][$r]);
                $item_unit_quantity = $_POST['quantity'][$r];
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;
                $item_expiry = isset($_POST['expiry'][$r]) ? $this->sma->fsd($_POST['expiry'][$r]) : NULL;
                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' && $_POST['product_option'][$r] != 'undefined' && $_POST['product_option'][$r] != 'null' ? $_POST['product_option'][$r] : NULL;
                $item_unit = $_POST['product_unit'][$r];
                $item_quantity = $_POST['product_base_quantity'][$r];

                if (isset($item_code) && isset($real_unit_cost) && isset($unit_cost) && isset($item_quantity)) {
                    $product_details = $this->transfers_model->getProductByCode($item_code);
                    // if (!$this->Settings->overselling) {
                        $warehouse_quantity = $this->transfers_model->getWarehouseProduct($from_warehouse_details->id, $product_details->id, $item_option);
                        if ($warehouse_quantity->quantity < $item_quantity) {
                            $this->session->set_flashdata('error', lang("no_match_found") . " (" . lang('product_name') . " <strong>" . $product_details->name . "</strong> " . lang('product_code') . " <strong>" . $product_details->code . "</strong>)");
                            admin_redirect("transfers/add");
                        }
                   // }

                    $pr_item_tax = $item_tax = 0;
                    $tax = "";
                    $item_net_cost = $unit_cost;

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {

                        $tax_details = $this->site->getTaxRateByID($item_tax_rate);
                        $ctax = $this->site->calculateTax($product_details, $tax_details, $unit_cost);
                        $item_tax = $ctax['amount'];
                        $tax = $ctax['tax'];
                        if (!empty($product_details) && $product_details->tax_method != 1) {
                            $item_net_cost = $unit_cost - $item_tax;
                        }
                        $pr_item_tax = $this->sma->formatDecimal(($item_tax * $item_unit_quantity), 4);
                        if ($this->Settings->indian_gst && $gst_data = $this->gst->calculteIndianGST($pr_item_tax, false, $tax_details)) {
                            $total_cgst += $gst_data['cgst'];
                            $total_sgst += $gst_data['sgst'];
                            $total_igst += $gst_data['igst'];
                        }
                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = $this->sma->formatDecimal((($item_net_cost * $item_unit_quantity) + $pr_item_tax), 4);
                    $unit = $this->site->getUnitByID($item_unit);

                    $product = array(
                        'product_id' => $product_details->id,
                        'product_code' => $item_code,
                        'product_name' => $product_details->name,
                        'option_id' => $item_option,
                        'net_unit_cost' => $item_net_cost,
                        'unit_cost' => $this->sma->formatDecimal($item_net_cost + $item_tax, 4),
                        'quantity' => $item_quantity,
                        'product_unit_id' => $item_unit,
                        'product_unit_code' => $unit->code,
                        'unit_quantity' => $item_unit_quantity,
                        'quantity_balance' => $item_quantity,
                        'warehouse_id' => $to_warehouse,
                        'item_tax' => $pr_item_tax,
                        'tax_rate_id' => $item_tax_rate,
                        'tax' => $tax,
                        'subtotal' => $this->sma->formatDecimal($subtotal),
                        'expiry' => $item_expiry,
                        'real_unit_cost' => $real_unit_cost,
                        'date' => date('Y-m-d', strtotime($date))
                    );

                    $products[] = ($product + $gst_data);
                    $total += $this->sma->formatDecimal(($item_net_cost * $item_unit_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($products);
            }

            $grand_total = $this->sma->formatDecimal(($total + $shipping + $product_tax), 4);
            $data = array('transfer_no' => $transfer_no,
                'date' => $date,
                'from_warehouse_id' => $from_warehouse,
                'from_warehouse_code' => $from_warehouse_code,
                'from_warehouse_name' => $from_warehouse_name,
                'to_warehouse_id' => $to_warehouse,
                'to_warehouse_code' => $to_warehouse_code,
                'to_warehouse_name' => $to_warehouse_name,
                'note' => $note,
                'total_tax' => $product_tax,
                'total' => $total,
                'grand_total' => $grand_total,
                'created_by' => $this->session->userdata('user_id'),
                'status' => $status,
                'shipping' => $shipping
            );
            if ($this->Settings->indian_gst) {
                $data['cgst'] = $total_cgst;
                $data['sgst'] = $total_sgst;
                $data['igst'] = $total_igst;
            }

            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }

            // $this->sma->print_arrays($data, $products);
        }

        if ($this->form_validation->run() == true && $this->transfers_model->addTransfer($data, $products)) {
            $this->session->set_userdata('remove_tols', 1);
            $this->session->set_flashdata('message', lang("transfer_added"));
            admin_redirect("transfers");
        } else {


            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['name'] = array('name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['quantity'] = array('name' => 'quantity',
                'id' => 'quantity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('quantity'),
            );

            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
            $this->data['rnumber'] = ''; //$this->site->getReference('to');

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('transfers'), 'page' => lang('transfers')), array('link' => '#', 'page' => lang('add_transfer')));
            $meta = array('page_title' => lang('transfer_quantity'), 'bc' => $bc);
            $this->page_construct('transfers/add', $meta, $this->data);
        }
    }

    function edit($id = NULL)
    {
        $this->sma->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $transfer = $this->transfers_model->getTransferByID($id);
        if (!$this->session->userdata('edit_right')) {
            $this->sma->view_rights($transfer->created_by);
        }
        $this->form_validation->set_message('is_natural_no_zero', lang("no_zero_required"));
        $this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('to_warehouse', lang("warehouse") . ' (' . lang("to") . ')', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('from_warehouse', lang("warehouse") . ' (' . lang("from") . ')', 'required|is_natural_no_zero');

        if ($this->form_validation->run()) {

            $transfer_no = $this->input->post('reference_no');
            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $to_warehouse = $this->input->post('to_warehouse');
            $from_warehouse = $this->input->post('from_warehouse');
            $note = $this->sma->clear_tags($this->input->post('note'));
            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $status = $this->input->post('status');
            $from_warehouse_details = $this->site->getWarehouseByID($from_warehouse);
            $from_warehouse_code = $from_warehouse_details->code;
            $from_warehouse_name = $from_warehouse_details->name;
            $to_warehouse_details = $this->site->getWarehouseByID($to_warehouse);
            $to_warehouse_code = $to_warehouse_details->code;
            $to_warehouse_name = $to_warehouse_details->name;

            $total = 0;
            $product_tax = 0;
            $gst_data = [];
            $total_cgst = $total_sgst = $total_igst = 0;
            $i = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_code = $_POST['product_code'][$r];
                $item_net_cost = $this->sma->formatDecimal($_POST['net_cost'][$r]);
                $unit_cost = $this->sma->formatDecimal($_POST['unit_cost'][$r]);
                $real_unit_cost = $this->sma->formatDecimal($_POST['real_unit_cost'][$r]);
                $item_unit_quantity = $_POST['quantity'][$r];
                $quantity_balance = $_POST['quantity_balance'][$r];
                $ordered_quantity = $_POST['ordered_quantity'][$r];
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;
                $item_expiry = isset($_POST['expiry'][$r]) ? $this->sma->fsd($_POST['expiry'][$r]) : NULL;
                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' && $_POST['product_option'][$r] != 'undefined' && $_POST['product_option'][$r] != 'null' ? $_POST['product_option'][$r] : NULL;
                $item_unit = $_POST['product_unit'][$r];
                $item_quantity = $_POST['product_base_quantity'][$r];

                if (isset($item_code) && isset($real_unit_cost) && isset($unit_cost) && isset($item_quantity)) {
                    $product_details = $this->transfers_model->getProductByCode($item_code);
                    $pr_item_tax = $item_tax = 0;
                    $tax = "";
                    $item_net_cost = $unit_cost;

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {

                        $tax_details = $this->site->getTaxRateByID($item_tax_rate);
                        $ctax = $this->site->calculateTax($product_details, $tax_details, $unit_cost);
                        $item_tax = $ctax['amount'];
                        $tax = $ctax['tax'];
                        if (!empty($product_details) && $product_details->tax_method != 1) {
                            $item_net_cost = $unit_cost - $item_tax;
                        }
                        $pr_item_tax = $this->sma->formatDecimal(($item_tax * $item_unit_quantity), 4);
                        if ($this->Settings->indian_gst && $gst_data = $this->gst->calculteIndianGST($pr_item_tax, false, $tax_details)) {
                            $total_cgst += $gst_data['cgst'];
                            $total_sgst += $gst_data['sgst'];
                            $total_igst += $gst_data['igst'];
                        }
                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = $this->sma->formatDecimal((($item_net_cost * $item_unit_quantity) + $pr_item_tax), 4);
                    $unit = $this->site->getUnitByID($item_unit);
                    $balance_qty =  ($status != 'completed') ? $item_quantity : ($item_quantity - ($ordered_quantity - $quantity_balance));

                    $product = array(
                        'product_id' => $product_details->id,
                        'product_code' => $item_code,
                        'product_name' => $product_details->name,
                        'option_id' => $item_option,
                        'net_unit_cost' => $item_net_cost,
                        'unit_cost' => $this->sma->formatDecimal(($item_net_cost + $item_tax), 4),
                        'quantity' => $item_quantity,
                        'product_unit_id' => $item_unit,
                        'product_unit_code' => $unit->code,
                        'unit_quantity' => $item_unit_quantity,
                        'quantity_balance' => $balance_qty,
                        'warehouse_id' => $to_warehouse,
                        'item_tax' => $pr_item_tax,
                        'tax_rate_id' => $item_tax_rate,
                        'tax' => $tax,
                        'subtotal' => $this->sma->formatDecimal($subtotal),
                        'expiry' => $item_expiry,
                        'real_unit_cost' => $real_unit_cost,
                        'date' => date('Y-m-d', strtotime($date)),
                    );

                    $products[] = ($product + $gst_data);
                    $total += $this->sma->formatDecimal(($item_net_cost * $item_unit_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($products);
            }

            $grand_total = $this->sma->formatDecimal(($total + $shipping + $product_tax), 4);
            $data = array('transfer_no' => $transfer_no,
                'date' => $date,
                'from_warehouse_id' => $from_warehouse,
                'from_warehouse_code' => $from_warehouse_code,
                'from_warehouse_name' => $from_warehouse_name,
                'to_warehouse_id' => $to_warehouse,
                'to_warehouse_code' => $to_warehouse_code,
                'to_warehouse_name' => $to_warehouse_name,
                'note' => $note,
                'total_tax' => $product_tax,
                'total' => $total,
                'grand_total' => $grand_total,
                'created_by' => $this->session->userdata('user_id'),
                'status' => $status,
                'shipping' => $shipping
            );
            if ($this->Settings->indian_gst) {
                $data['cgst'] = $total_cgst;
                $data['sgst'] = $total_sgst;
                $data['igst'] = $total_igst;
            }

            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }

            // $this->sma->print_arrays($data, $products);

        }

        if ($this->form_validation->run() == true && $this->transfers_model->updateTransfer($id, $data, $products)) {
            $this->session->set_userdata('remove_tols', 1);
            $this->session->set_flashdata('message', lang("transfer_updated"));
            admin_redirect("transfers");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['transfer'] = $this->transfers_model->getTransferByID($id);
            $transfer_items = $this->transfers_model->getAllTransferItems($id, $this->data['transfer']->status);
            krsort($transfer_items);
            $c = rand(100000, 9999999);
            foreach ($transfer_items as $item) {
                $row = $this->site->getProductByID($item->product_id);
                if (!$row) {
                    $row = json_decode('{}');
                } else {
                    unset($row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                }
                $row->quantity = 0;
                $row->expiry = (($item->expiry && $item->expiry != '0000-00-00') ? $this->sma->hrsd($item->expiry) : '');
                $row->base_quantity = $item->quantity;
                $row->base_unit = $row->unit ? $row->unit : $item->product_unit_id;
                $row->base_unit_cost = $row->cost ? $row->cost : $item->unit_cost;
                $row->unit = $item->product_unit_id;
                $row->qty = $item->unit_quantity;
                $row->quantity_balance = $item->quantity_balance;
                $row->ordered_quantity = $item->quantity;
                $row->quantity += $item->quantity_balance;
                $row->cost = $item->net_unit_cost;
                $row->unit_cost = $item->net_unit_cost+($item->item_tax/$item->quantity);
                $row->real_unit_cost = $item->real_unit_cost;
                $row->tax_rate = $item->tax_rate_id;
                $row->option = $item->option_id;
                $options = $this->transfers_model->getProductOptions($row->id, $this->data['transfer']->from_warehouse_id, FALSE);
                $pis = $this->site->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                if($pis) {
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                $row->quantity += $item->quantity;
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->site->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        $option_quantity += $item->quantity;
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }

                $units = $this->site->getUnitsByBUID($row->base_unit);
                $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                $ri = $this->Settings->item_addition ? $row->id : $c;

                $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")",
                    'row' => $row, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options);
                $c++;
            }

            $this->data['transfer_items'] = json_encode($pr);
            $this->data['id'] = $id;
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('transfers'), 'page' => lang('transfers')), array('link' => '#', 'page' => lang('edit_transfer')));
            $meta = array('page_title' => lang('edit_transfer_quantity'), 'bc' => $bc);
            $this->page_construct('transfers/edit', $meta, $this->data);
        }
    }

    function transfer_by_csv()
    {
        $this->sma->checkPermissions('csv');
        $this->load->helper('security');
        $this->form_validation->set_message('is_natural_no_zero', lang("no_zero_required"));
        $this->form_validation->set_rules('to_warehouse', lang("warehouse") . ' (' . lang("to") . ')', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('from_warehouse', lang("warehouse") . ' (' . lang("from") . ')', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');

        if ($this->form_validation->run()) {

            $transfer_no = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('to');
            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $to_warehouse = $this->input->post('to_warehouse');
            $from_warehouse = $this->input->post('from_warehouse');
            $note = $this->sma->clear_tags($this->input->post('note'));
            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $status = $this->input->post('status');
            $from_warehouse_details = $this->site->getWarehouseByID($from_warehouse);
            $from_warehouse_code = $from_warehouse_details->code;
            $from_warehouse_name = $from_warehouse_details->name;
            $to_warehouse_details = $this->site->getWarehouseByID($to_warehouse);
            $to_warehouse_code = $to_warehouse_details->code;
            $to_warehouse_name = $to_warehouse_details->name;

            $total = 0;
            $product_tax = 0;
            $gst_data = [];
            $total_cgst = $total_sgst = $total_igst = 0;
            if (isset($_FILES["userfile"])) {

                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = 'csv';
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    admin_redirect("transfers/transfer_bt_csv");
                }

                $csv = $this->upload->file_name;

                $arrResult = array();
                $handle = fopen($this->digital_upload_path . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);

                $keys = array('product', 'unit_cost', 'quantity', 'variant', 'expiry');
                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }

                $rw = 2;
                foreach ($final as $csv_pr) {

                    $item_code = $csv_pr['product'];
                    $unit_cost = $csv_pr['unit_cost'];
                    $item_quantity = $csv_pr['quantity'];
                    $variant = isset($csv_pr['variant']) ? $csv_pr['variant'] : NULL;
                    $item_expiry = isset($csv_pr['expiry']) ? $this->sma->fsd($csv_pr['expiry']) : NULL;

                    if (isset($item_code) && isset($unit_cost) && isset($item_quantity)) {
                        if (!($product_details = $this->transfers_model->getProductByCode($item_code))) {
                            $this->session->set_flashdata('error', lang("pr_not_found") . " ( " . $csv_pr['product'] . " ). " . lang("line_no") . " " . $rw);
                            redirect($_SERVER["HTTP_REFERER"]);
                        }
                        if ($variant) {
                            $item_option = $this->transfers_model->getProductVariantByName($variant, $product_details->id);
                            if (!$item_option) {
                                $this->session->set_flashdata('error', lang("pr_not_found") . " ( " . $csv_pr['product'] . " - " . $csv_pr['variant'] . " ). " . lang("line_no") . " " . $rw);
                                redirect($_SERVER["HTTP_REFERER"]);
                            }
                        } else {
                            $item_option = json_decode('{}');
                            $item_option->id = NULL;
                        }

                        if (!$this->Settings->overselling) {
                            $warehouse_quantity = $this->transfers_model->getWarehouseProduct($from_warehouse_details->id, $product_details->id, $item_option->id);
                            if ($warehouse_quantity->quantity < $item_quantity) {
                                $this->session->set_flashdata('error', lang("no_match_found") . " (" . lang('product_name') . " <strong>" . $product_details->name . "</strong> " . lang('product_code') . " <strong>" . $product_details->code . "</strong>) " . lang("line_no") . " " . $rw);
                                redirect($_SERVER["HTTP_REFERER"]);
                            }
                        }

                        $pr_item_tax = $item_tax = 0;
                        $tax = "";
                        $item_net_cost = $unit_cost;
                        if (isset($product_details->tax_rate) && $product_details->tax_rate != 0) {

                            $tax_details = $this->site->getTaxRateByID($product_details->tax_rate);
                            $ctax = $this->site->calculateTax($product_details, $tax_details, $unit_cost);
                            $item_tax = $ctax['amount'];
                            $tax = $ctax['tax'];
                            if (!empty($product_details) && $product_details->tax_method != 1) {
                                $item_net_cost = $unit_cost - $item_tax;
                            }
                            $pr_item_tax = $this->sma->formatDecimal(($item_tax * $item_quantity), 4);
                            if ($this->Settings->indian_gst && $gst_data = $this->gst->calculteIndianGST($pr_item_tax, false, $tax_details)) {
                                $total_cgst += $gst_data['cgst'];
                                $total_sgst += $gst_data['sgst'];
                                $total_igst += $gst_data['igst'];
                            }
                        }

                        $product_tax += $pr_item_tax;
                        $subtotal = $this->sma->formatDecimal((($item_net_cost * $item_quantity) + $pr_item_tax), 4);
                        $unit = $this->site->getUnitByID($product_details->unit);

                        $product = array(
                            'product_id' => $product_details->id,
                            'product_code' => $item_code,
                            'product_name' => $product_details->name,
                            'option_id' => $item_option->id,
                            'net_unit_cost' => $item_net_cost,
                            'unit_cost' => $this->sma->formatDecimal($unit_cost, 4),
                            'quantity' => $item_quantity,
                            'product_unit_id' => $unit ? $unit->id : NULL,
                            'product_unit_code' => $unit ? $unit->code : NULL,
                            'unit_quantity' => $item_quantity,
                            'quantity_balance' => $item_quantity,
                            'warehouse_id' => $to_warehouse,
                            'item_tax' => $pr_item_tax,
                            'tax_rate_id' => $product_details->tax_rate,
                            'tax' => $tax,
                            'subtotal' => $subtotal,
                            'expiry' => $item_expiry,
                            'real_unit_cost' => $unit_cost,
                            'date' => date('Y-m-d', strtotime($date)),
                        );

                        $products[] = ($product + $gst_data);
                        $total += $this->sma->formatDecimal(($item_net_cost * $item_quantity), 4);
                    }
                    $rw++;
                }
            }

            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_item"), 'required');
            } else {
                krsort($products);
            }
            $grand_total = $total + $shipping + $product_tax;
            $data = array('transfer_no' => $transfer_no,
                'date' => $date,
                'from_warehouse_id' => $from_warehouse,
                'from_warehouse_code' => $from_warehouse_code,
                'from_warehouse_name' => $from_warehouse_name,
                'to_warehouse_id' => $to_warehouse,
                'to_warehouse_code' => $to_warehouse_code,
                'to_warehouse_name' => $to_warehouse_name,
                'note' => $note,
                'total_tax' => $product_tax,
                'total' => $total,
                'grand_total' => $grand_total,
                'created_by' => $this->session->userdata('user_id'),
                'status' => $status,
                'shipping' => $shipping
            );
            if ($this->Settings->indian_gst) {
                $data['cgst'] = $total_cgst;
                $data['sgst'] = $total_sgst;
                $data['igst'] = $total_igst;
            }

            if ($_FILES['document']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('document')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;
            }

            // $this->sma->print_arrays($data, $products);

        }

        if ($this->form_validation->run() == true && $this->transfers_model->addTransfer($data, $products)) {
            $this->session->set_userdata('remove_tols', 1);
            $this->session->set_flashdata('message', lang("transfer_added"));
            admin_redirect("transfers");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['name'] = array('name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['quantity'] = array('name' => 'quantity',
                'id' => 'quantity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('quantity'),
            );

            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
            $this->data['rnumber'] = $this->site->getReference('to');

            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('transfers'), 'page' => lang('transfers')), array('link' => '#', 'page' => lang('transfer_by_csv')));
            $meta = array('page_title' => lang('add_transfer_by_csv'), 'bc' => $bc);
            $this->page_construct('transfers/transfer_by_csv', $meta, $this->data);
        }
    }

    function view($transfer_id = NULL)
    {
        $this->sma->checkPermissions('index', TRUE);

        if ($this->input->get('id')) {
            $transfer_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $transfer = $this->transfers_model->getTransferByID($transfer_id);
        if (!$this->session->userdata('view_right')) {
            $this->sma->view_rights($transfer->created_by, true);
        }
        $this->data['rows'] = $this->transfers_model->getAllTransferItems($transfer_id, $transfer->status);
        $this->data['from_warehouse'] = $this->site->getWarehouseByID($transfer->from_warehouse_id);
        $this->data['to_warehouse'] = $this->site->getWarehouseByID($transfer->to_warehouse_id);
        $this->data['transfer'] = $transfer;
        $this->data['tid'] = $transfer_id;
        $this->data['created_by'] = $this->site->getUser($transfer->created_by);
        $this->load->view($this->theme . 'transfers/view', $this->data);
    }

    function pdf($transfer_id = NULL, $view = NULL, $save_bufffer = NULL)
    {
        if ($this->input->get('id')) {
            $transfer_id = $this->input->get('id');
        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $transfer = $this->transfers_model->getTransferByID($transfer_id);
        if (!$this->session->userdata('view_right')) {
            $this->sma->view_rights($transfer->created_by);
        }
        $this->data['rows'] = $this->transfers_model->getAllTransferItems($transfer_id, $transfer->status);
        $this->data['from_warehouse'] = $this->site->getWarehouseByID($transfer->from_warehouse_id);
        $this->data['to_warehouse'] = $this->site->getWarehouseByID($transfer->to_warehouse_id);
        $this->data['transfer'] = $transfer;
        $this->data['tid'] = $transfer_id;
        $this->data['created_by'] = $this->site->getUser($transfer->created_by);
        $name = lang("transfer") . "_" . str_replace('/', '_', $transfer->transfer_no) . ".pdf";
        $html = $this->load->view($this->theme . 'transfers/pdf', $this->data, TRUE);
        if (! $this->Settings->barcode_img) {
            $html = preg_replace("'\<\?xml(.*)\?\>'", '', $html);
        }
        if ($view) {
            $this->load->view($this->theme . 'transfers/pdf', $this->data);
        } elseif ($save_bufffer) {
            return $this->sma->generate_pdf($html, $name, $save_bufffer);
        } else {
            $this->sma->generate_pdf($html, $name);
        }

    }

    public function combine_pdf($transfers_id)
    {
        $this->sma->checkPermissions('pdf');

        foreach ($transfers_id as $transfer_id) {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $transfer = $this->transfers_model->getTransferByID($transfer_id);
            if (!$this->session->userdata('view_right')) {
                $this->sma->view_rights($transfer->created_by);
            }
            $this->data['rows'] = $this->transfers_model->getAllTransferItems($transfer_id, $transfer->status);
            $this->data['from_warehouse'] = $this->site->getWarehouseByID($transfer->from_warehouse_id);
            $this->data['to_warehouse'] = $this->site->getWarehouseByID($transfer->to_warehouse_id);
            $this->data['transfer'] = $transfer;
            $this->data['tid'] = $transfer_id;
            $this->data['created_by'] = $this->site->getUser($transfer->created_by);

            $html[] = array(
                'content' => $this->load->view($this->theme . 'transfers/pdf', $this->data, TRUE),
                'footer' => '',
            );
        }

        $name = lang("transfers") . ".pdf";
        $this->sma->generate_pdf($html, $name);

    }

    function email($transfer_id = NULL)
    {
        $this->sma->checkPermissions(false, true);

        if ($this->input->get('id')) {
            $transfer_id = $this->input->get('id');
        }
        $transfer = $this->transfers_model->getTransferByID($transfer_id);
        $this->form_validation->set_rules('to', lang("to") . " " . lang("email"), 'trim|required|valid_email');
        $this->form_validation->set_rules('subject', lang("subject"), 'trim|required');
        $this->form_validation->set_rules('cc', lang("cc"), 'trim|valid_emails');
        $this->form_validation->set_rules('bcc', lang("bcc"), 'trim|valid_emails');
        $this->form_validation->set_rules('note', lang("message"), 'trim');

        if ($this->form_validation->run() == true) {
            if (!$this->session->userdata('view_right')) {
                $this->sma->view_rights($transfer->created_by);
            }
            $to = $this->input->post('to');
            $subject = $this->input->post('subject');
            if ($this->input->post('cc')) {
                $cc = $this->input->post('cc');
            } else {
                $cc = NULL;
            }
            if ($this->input->post('bcc')) {
                $bcc = $this->input->post('bcc');
            } else {
                $bcc = NULL;
            }

            $this->load->library('parser');
            $parse_data = array(
                'reference_number' => $transfer->transfer_no,
                'site_link' => base_url(),
                'site_name' => $this->Settings->site_name,
                'logo' => '<img src="' . base_url() . 'assets/uploads/logos/' . $this->Settings->logo . '" alt="' . $this->Settings->site_name . '"/>'
            );
            $msg = $this->input->post('note');
            $message = $this->parser->parse_string($msg, $parse_data);
            $attachment = $this->pdf($transfer_id, NULL, 'S');

            try {
                if ($this->sma->send_email($to, $subject, $message, NULL, NULL, $attachment, $cc, $bcc)) {
                    delete_files($attachment);
                    $this->session->set_flashdata('message', lang("email_sent"));
                    admin_redirect("transfers");
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());
                redirect($_SERVER["HTTP_REFERER"]);
            }

        } elseif ($this->input->post('send_email')) {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->session->set_flashdata('error', $this->data['error']);
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            if (file_exists('./themes/' . $this->Settings->theme . '/admin/views/email_templates/transfer.html')) {
                $transfer_temp = file_get_contents('themes/' . $this->Settings->theme . '/admin/views/email_templates/transfer.html');
            } else {
                $transfer_temp = file_get_contents('./themes/default/admin/views/email_templates/transfer.html');
            }
            $this->data['subject'] = array('name' => 'subject',
                'id' => 'subject',
                'type' => 'text',
                'value' => $this->form_validation->set_value('subject', lang('transfer_order').' (' . $transfer->transfer_no . ') '.lang('from').' ' . $transfer->from_warehouse_name),
            );
            $this->data['note'] = array('name' => 'note',
                'id' => 'note',
                'type' => 'text',
                'value' => $this->form_validation->set_value('note', $transfer_temp),
            );
            $this->data['warehouse'] = $this->site->getWarehouseByID($transfer->to_warehouse_id);

            $this->data['id'] = $transfer_id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'transfers/email', $this->data);

        }
    }

    function delete($id = NULL)
    {
        $this->sma->checkPermissions(NULL, TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->transfers_model->deleteTransfer($id)) {
            if($this->input->is_ajax_request()) {
                $this->sma->send_json(array('error' => 0, 'msg' => lang("transfer_deleted")));
            }
            $this->session->set_flashdata('message', lang('transfer_deleted'));
            admin_redirect('welcome');
        }
    }

    function suggestions()
    {
        $this->sma->checkPermissions('index', TRUE);
        $term = $this->input->get('term', TRUE);
        $warehouse_id = $this->input->get('warehouse_id', TRUE);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . admin_url('welcome') . "'; }, 10);</script>");
        }

        $analyzed = $this->sma->analyze_term($term);
        $sr = $analyzed['term'];
        $option_id = $analyzed['option_id'];

        $rows = $this->transfers_model->getProductNames($sr, $warehouse_id);
        if ($rows) {
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
                $option = FALSE;
                $row->quantity = 0;
                $row->item_tax_method = $row->tax_method;
                $row->base_quantity = 1;
                $row->base_unit = $row->unit;
                $row->base_unit_cost = $row->cost;
                $row->unit = $row->purchase_unit ? $row->purchase_unit : $row->unit;
                $row->qty = 1;
                $row->discount = '0';
                $row->expiry = '';
                $row->quantity_balance = 0;
                $row->ordered_quantity = 0;
                $options = $this->transfers_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $option_id && $r == 0 ? $this->transfers_model->getProductOptionByID($option_id) : $options[0];
                    if (!$option_id || $r > 0) {
                        $option_id = $opt->id;
                    }
                } else {
                    $opt = json_decode('{}');
                    $opt->cost = 0;
                    $option_id = FALSE;
                }
                $row->option = $option_id;
                $pis = $this->site->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if($pis){
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->site->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if($pis){
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($opt->cost != 0) {
                    $row->cost = $opt->cost;
                }
                $row->real_unit_cost = $row->cost;
                $units = $this->site->getUnitsByBUID($row->base_unit);
                $tax_rate = $this->site->getTaxRateByID($row->tax_rate);

                $pr[] = array('id' => ($c + $r), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")",
                    'row' => $row, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options);
                $r++;
            }
            $this->sma->send_json($pr);
        } else {
            $this->sma->send_json(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }

    function transfer_actions()
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {

                    foreach ($_POST['val'] as $id) {
                        $this->transfers_model->deleteTransfer($id);
                    }
                    $this->session->set_flashdata('message', lang("transfers_deleted"));
                    redirect($_SERVER["HTTP_REFERER"]);

                } elseif ($this->input->post('form_action') == 'combine') {

                    $html = $this->combine_pdf($_POST['val']);

                } elseif ($this->input->post('form_action') == 'export_excel') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('transfers'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('from_warehouse'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('to_warehouse'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('grand_total'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('status'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $tansfer = $this->transfers_model->getTransferByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($tansfer->date));
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $tansfer->reference_no);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $tansfer->from_warehouse);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $tansfer->to_warehouse);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $tansfer->grand_total);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $tansfer->status);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'tansfers_' . date('Y_m_d_H_i_s');
                    $this->load->helper('excel');
                    create_excel($this->excel, $filename);
                }
            } else {
                $this->session->set_flashdata('error', lang("no_transfer_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function update_status($id)
    {

        $this->form_validation->set_rules('status', lang("status"), 'required');

        if ($this->form_validation->run() == true) {
            $status = $this->input->post('status');
            $note = $this->sma->clear_tags($this->input->post('note'));
        } elseif ($this->input->post('update')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'transfers');
        }

        if ($this->form_validation->run() == true && $this->transfers_model->updateStatus($id, $status, $note)) {
            $this->session->set_flashdata('message', lang('status_updated'));
            admin_redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'transfers');
        } else {

            $this->data['inv'] = $this->transfers_model->getTransferByID($id);
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme.'transfers/update_status', $this->data);

        }
    }

}
