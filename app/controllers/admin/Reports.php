<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }

        $this->lang->admin_load('reports', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->admin_model('reports_model');
        $this->data['pb'] = array(
            'cash' => lang('cash'),
            'CC' => lang('CC'),
            'Cheque' => lang('Cheque'),
            'paypal_pro' => lang('paypal_pro'),
            'stripe' => lang('stripe'),
            'gift_card' => lang('gift_card'),
            'deposit' => lang('deposit'),
            'authorize' => lang('authorize'),
            );

    }

    function index()
    {
        $this->sma->checkPermissions();
        $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['monthly_sales'] = $this->reports_model->getChartData();
        $this->data['stock'] = $this->reports_model->getStockValue();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('reports')));
        $meta = array('page_title' => lang('reports'), 'bc' => $bc);
        $this->page_construct('reports/index', $meta, $this->data);

    }

    function warehouse_stock($warehouse = NULL)
    {
        $this->sma->checkPermissions('index', TRUE);
        $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        if ($this->input->get('warehouse')) {
            $warehouse = $this->input->get('warehouse');
        }

        $this->data['stock'] = $warehouse ? $this->reports_model->getWarehouseStockValue($warehouse) : $this->reports_model->getStockValue();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['warehouse_id'] = $warehouse;
        $this->data['warehouse'] = $warehouse ? $this->site->getWarehouseByID($warehouse) : NULL;
        $this->data['totals'] = $this->reports_model->getWarehouseTotals($warehouse);
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('reports')));
        $meta = array('page_title' => lang('reports'), 'bc' => $bc);
        $this->page_construct('reports/warehouse_stock', $meta, $this->data);

    }

    function expiry_alerts($warehouse_id = NULL)
    {
        $this->sma->checkPermissions('expiry_alerts');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        if ($this->Owner || $this->Admin || !$this->session->userdata('warehouse_id')) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        } else {
            $user = $this->site->getUser();
            $this->data['warehouses'] = NULL;
            $this->data['warehouse_id'] = $user->warehouse_id;
            $this->data['warehouse'] = $user->warehouse_id ? $this->site->getWarehouseByID($user->warehouse_id) : NULL;
        }

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('product_expiry_alerts')));
        $meta = array('page_title' => lang('product_expiry_alerts'), 'bc' => $bc);
        $this->page_construct('reports/expiry_alerts', $meta, $this->data);
    }

    function getExpiryAlerts($warehouse_id = NULL)
    {
        $this->sma->checkPermissions('expiry_alerts', TRUE);
        $date = date('Y-m-d', strtotime('+3 months'));

        if (!$this->Owner && !$warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }

        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select("image, product_code, product_name, quantity_balance, warehouses.name, expiry")
                ->from('purchase_items')
                ->join('products', 'products.id=purchase_items.product_id', 'left')
                ->join('warehouses', 'warehouses.id=purchase_items.warehouse_id', 'left')
                ->where('warehouse_id', $warehouse_id)
                ->where('expiry !=', NULL)->where('expiry !=', '0000-00-00')
                ->where('expiry <', $date);
        } else {
            $this->datatables
                ->select("image, product_code, product_name, quantity_balance, warehouses.name, expiry")
                ->from('purchase_items')
                ->join('products', 'products.id=purchase_items.product_id', 'left')
                ->join('warehouses', 'warehouses.id=purchase_items.warehouse_id', 'left')
                ->where('expiry !=', NULL)->where('expiry !=', '0000-00-00')
                ->where('expiry <', $date);
        }
        echo $this->datatables->generate();
    }

    function quantity_alerts($warehouse_id = NULL)
    {
        $this->sma->checkPermissions('quantity_alerts');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        if ($this->Owner || $this->Admin || !$this->session->userdata('warehouse_id')) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        } else {
            $user = $this->site->getUser();
            $this->data['warehouses'] = NULL;
            $this->data['warehouse_id'] = $user->warehouse_id;
            $this->data['warehouse'] = $user->warehouse_id ? $this->site->getWarehouseByID($user->warehouse_id) : NULL;
        }

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('product_quantity_alerts')));
        $meta = array('page_title' => lang('product_quantity_alerts'), 'bc' => $bc);
        $this->page_construct('reports/quantity_alerts', $meta, $this->data);
    }

    function getQuantityAlerts($warehouse_id = NULL, $pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('quantity_alerts', TRUE);
        if (!$this->Owner && !$warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }

        if ($pdf || $xls) {

            if ($warehouse_id) {
                $this->db
                    ->select('products.image as image, products.code, products.name, warehouses_products.quantity, alert_quantity')
                    ->from('products')->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
                    ->where('alert_quantity > warehouses_products.quantity', NULL)
                    ->where('warehouse_id', $warehouse_id)
                    ->where('track_quantity', 1)
                    ->order_by('products.code desc');
            } else {
                $this->db
                    ->select('image, code, name, quantity, alert_quantity')
                    ->from('products')
                    ->where('alert_quantity > quantity', NULL)
                    ->where('track_quantity', 1)
                    ->order_by('code desc');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('product_quantity_alerts'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('product_code'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('product_name'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('quantity'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('alert_quantity'));

                $row = 2;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->code);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->quantity);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->alert_quantity);
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $filename = 'product_quantity_alerts';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');
            if ($warehouse_id) {
                $this->datatables
                    ->select('image, code, name, wp.quantity, alert_quantity')
                    ->from('products')
                    ->join("( SELECT * from {$this->db->dbprefix('warehouses_products')} WHERE warehouse_id = {$warehouse_id}) wp", 'products.id=wp.product_id', 'left')
                    ->where('alert_quantity > wp.quantity', NULL)
                    ->or_where('wp.quantity', NULL)
                    ->where('track_quantity', 1)
                    ->group_by('products.id');
            } else {
                $this->datatables
                    ->select('image, code, name, quantity, alert_quantity')
                    ->from('products')
                    ->where('alert_quantity > quantity', NULL)
                    ->where('track_quantity', 1);
            }

            echo $this->datatables->generate();

        }

    }

    function suggestions()
    {
        $term = $this->input->get('term', TRUE);
        if (strlen($term) < 1) {
            die();
        }

        $rows = $this->reports_model->getProductNames($term);
        if ($rows) {
            foreach ($rows as $row) {
                $pr[] = array('id' => $row->id, 'label' => $row->name . " (" . $row->code . ")");

            }
            $this->sma->send_json($pr);
        } else {
            echo FALSE;
        }
    }

    public function best_sellers($warehouse_id = NULL)
    {
        $this->sma->checkPermissions('products');

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $y1 = date('Y', strtotime('-1 month'));
        $m1 = date('m', strtotime('-1 month'));
        $m1sdate = $y1.'-'.$m1.'-01 00:00:00';
        $m1edate = $y1.'-'.$m1.'-'. days_in_month($m1, $y1) . ' 23:59:59';
        $this->data['m1'] = date('M Y', strtotime($y1.'-'.$m1));
        $this->data['m1bs'] = $this->reports_model->getBestSeller($m1sdate, $m1edate, $warehouse_id);
        $y2 = date('Y', strtotime('-2 months'));
        $m2 = date('m', strtotime('-2 months'));
        $m2sdate = $y2.'-'.$m2.'-01 00:00:00';
        $m2edate = $y2.'-'.$m2.'-'. days_in_month($m2, $y2) . ' 23:59:59';
        $this->data['m2'] = date('M Y', strtotime($y2.'-'.$m2));
        $this->data['m2bs'] = $this->reports_model->getBestSeller($m2sdate, $m2edate, $warehouse_id);
        $y3 = date('Y', strtotime('-3 months'));
        $m3 = date('m', strtotime('-3 months'));
        $m3sdate = $y3.'-'.$m3.'-01 23:59:59';
        $this->data['m3'] = date('M Y', strtotime($y3.'-'.$m3)).' - '.$this->data['m1'];
        $this->data['m3bs'] = $this->reports_model->getBestSeller($m3sdate, $m1edate, $warehouse_id);
        $y4 = date('Y', strtotime('-12 months'));
        $m4 = date('m', strtotime('-12 months'));
        $m4sdate = $y4.'-'.$m4.'-01 23:59:59';
        $this->data['m4'] = date('M Y', strtotime($y4.'-'.$m4)).' - '.$this->data['m1'];
        $this->data['m4bs'] = $this->reports_model->getBestSeller($m4sdate, $m1edate, $warehouse_id);
        // $this->sma->print_arrays($this->data['m1bs'], $this->data['m2bs'], $this->data['m3bs'], $this->data['m4bs']);
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('best_sellers')));
        $meta = array('page_title' => lang('best_sellers'), 'bc' => $bc);
        $this->page_construct('reports/best_sellers', $meta, $this->data);

    }

    function products()
    {
        $this->sma->checkPermissions();
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['categories'] = $this->site->getAllCategories();
        $this->data['brands'] = $this->site->getAllBrands();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        if ($this->input->post('start_date')) {
            $dt = "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
        } else {
            $dt = "Till " . $this->input->post('end_date');
        }
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('products_report')));
        $meta = array('page_title' => lang('products_report'), 'bc' => $bc);
        $this->page_construct('reports/products', $meta, $this->data);
    }

    function getProductsReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('products', TRUE);

        $product = $this->input->get('product') ? $this->input->get('product') : NULL;
        $category = $this->input->get('category') ? $this->input->get('category') : NULL;
        $brand = $this->input->get('brand') ? $this->input->get('brand') : NULL;
        $subcategory = $this->input->get('subcategory') ? $this->input->get('subcategory') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $cf1 = $this->input->get('cf1') ? $this->input->get('cf1') : NULL;
        $cf2 = $this->input->get('cf2') ? $this->input->get('cf2') : NULL;
        $cf3 = $this->input->get('cf3') ? $this->input->get('cf3') : NULL;
        $cf4 = $this->input->get('cf4') ? $this->input->get('cf4') : NULL;
        $cf5 = $this->input->get('cf5') ? $this->input->get('cf5') : NULL;
        $cf6 = $this->input->get('cf6') ? $this->input->get('cf6') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        $pp = "( SELECT product_id, SUM(CASE WHEN pi.purchase_id IS NOT NULL THEN quantity ELSE 0 END) as purchasedQty, SUM(quantity_balance) as balacneQty, SUM( unit_cost * quantity_balance ) balacneValue, SUM( (CASE WHEN pi.purchase_id IS NOT NULL THEN (pi.subtotal) ELSE 0 END) ) totalPurchase from {$this->db->dbprefix('purchase_items')} pi LEFT JOIN {$this->db->dbprefix('purchases')} p on p.id = pi.purchase_id ";
        $sp = "( SELECT si.product_id, SUM( si.quantity ) soldQty, SUM( si.subtotal ) totalSale from " . $this->db->dbprefix('sales') . " s JOIN " . $this->db->dbprefix('sale_items') . " si on s.id = si.sale_id ";
        if ($start_date || $warehouse) {
            $pp .= " WHERE ";
            $sp .= " WHERE ";
            if ($start_date) {
                $start_date = $this->sma->fld($start_date);
                $end_date = $end_date ? $this->sma->fld($end_date) : date('Y-m-d');
                $pp .= " p.date >= '{$start_date}' AND p.date < '{$end_date}' ";
                $sp .= " s.date >= '{$start_date}' AND s.date < '{$end_date}' ";
                if ($warehouse) {
                    $pp .= " AND ";
                    $sp .= " AND ";
                }
            }
            if ($warehouse) {
                $pp .= " pi.warehouse_id = '{$warehouse}' ";
                $sp .= " si.warehouse_id = '{$warehouse}' ";
            }
        }
        $pp .= " GROUP BY pi.product_id ) PCosts";
        $sp .= " GROUP BY si.product_id ) PSales";
        if ($pdf || $xls) {

            $this->db
                ->select($this->db->dbprefix('products') . ".code, " . $this->db->dbprefix('products') . ".name,
                COALESCE( PCosts.purchasedQty, 0 ) as PurchasedQty,
                COALESCE( PSales.soldQty, 0 ) as SoldQty,
                COALESCE( PCosts.balacneQty, 0 ) as BalacneQty,
                COALESCE( PCosts.totalPurchase, 0 ) as TotalPurchase,
                COALESCE( PCosts.balacneValue, 0 ) as TotalBalance,
                COALESCE( PSales.totalSale, 0 ) as TotalSales,
                (COALESCE( PSales.totalSale, 0 ) - COALESCE( PCosts.totalPurchase, 0 )) as Profit", FALSE)
                ->from('products')
                ->join($sp, 'products.id = PSales.product_id', 'left')
                ->join($pp, 'products.id = PCosts.product_id', 'left')
                ->order_by('products.name');

            if ($product) {
                $this->db->where($this->db->dbprefix('products') . ".id", $product);
            }
            if ($cf1) {
                $this->db->where($this->db->dbprefix('products') . ".cf1", $cf1);
            }
            if ($cf2) {
                $this->db->where($this->db->dbprefix('products') . ".cf2", $cf2);
            }
            if ($cf3) {
                $this->db->where($this->db->dbprefix('products') . ".cf3", $cf3);
            }
            if ($cf4) {
                $this->db->where($this->db->dbprefix('products') . ".cf4", $cf4);
            }
            if ($cf5) {
                $this->db->where($this->db->dbprefix('products') . ".cf5", $cf5);
            }
            if ($cf6) {
                $this->db->where($this->db->dbprefix('products') . ".cf6", $cf6);
            }
            if ($category) {
                $this->db->where($this->db->dbprefix('products') . ".category_id", $category);
            }
            if ($subcategory) {
                $this->db->where($this->db->dbprefix('products') . ".subcategory_id", $subcategory);
            }
            if ($brand) {
                $this->db->where($this->db->dbprefix('products') . ".brand", $brand);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('products_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('product_code'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('product_name'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('purchased'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('sold'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('balance'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('purchased_amount'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('sold_amount'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('profit_loss'));
                $this->excel->getActiveSheet()->SetCellValue('I1', lang('stock_in_hand'));

                $row = 2;
                $sQty = 0;
                $pQty = 0;
                $sAmt = 0;
                $pAmt = 0;
                $bQty = 0;
                $bAmt = 0;
                $pl = 0;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->code);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->PurchasedQty);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->SoldQty);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->BalacneQty);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->TotalPurchase);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->TotalSales);
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, $data_row->Profit);
                    $this->excel->getActiveSheet()->SetCellValue('I' . $row, $data_row->TotalBalance);
                    $pQty += $data_row->PurchasedQty;
                    $sQty += $data_row->SoldQty;
                    $bQty += $data_row->BalacneQty;
                    $pAmt += $data_row->TotalPurchase;
                    $sAmt += $data_row->TotalSales;
                    $bAmt += $data_row->TotalBalance;
                    $pl += $data_row->Profit;
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("C" . $row . ":I" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('C' . $row, $pQty);
                $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sQty);
                $this->excel->getActiveSheet()->SetCellValue('E' . $row, $bQty);
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $pAmt);
                $this->excel->getActiveSheet()->SetCellValue('G' . $row, $sAmt);
                $this->excel->getActiveSheet()->SetCellValue('H' . $row, $pl);
                $this->excel->getActiveSheet()->SetCellValue('I' . $row, $bAmt);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C2:G' . $row)->getAlignment()->setWrapText(true);
                $filename = 'products_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');
            $this->datatables
                ->select($this->db->dbprefix('products') . ".code, " . $this->db->dbprefix('products') . ".name,
                CONCAT(COALESCE( PCosts.purchasedQty, 0 ), '__', COALESCE( PCosts.totalPurchase, 0 )) as purchased,
                CONCAT(COALESCE( PSales.soldQty, 0 ), '__', COALESCE( PSales.totalSale, 0 )) as sold,
                (COALESCE( PSales.totalSale, 0 ) - COALESCE( PCosts.totalPurchase, 0 )) as Profit,
                CONCAT(COALESCE( PCosts.balacneQty, 0 ), '__', COALESCE( PCosts.balacneValue, 0 )) as balance, {$this->db->dbprefix('products')}.id as id", FALSE)
                ->from('products')
                ->join($sp, 'products.id = PSales.product_id', 'left')
                ->join($pp, 'products.id = PCosts.product_id', 'left')
                ->group_by('products.code, PSales.soldQty, PSales.totalSale, PCosts.purchasedQty, PCosts.totalPurchase, PCosts.balacneQty, PCosts.balacneValue');

            if ($product) {
                $this->datatables->where($this->db->dbprefix('products') . ".id", $product);
            }
            if ($cf1) {
                $this->datatables->where($this->db->dbprefix('products') . ".cf1", $cf1);
            }
            if ($cf2) {
                $this->datatables->where($this->db->dbprefix('products') . ".cf2", $cf2);
            }
            if ($cf3) {
                $this->datatables->where($this->db->dbprefix('products') . ".cf3", $cf3);
            }
            if ($cf4) {
                $this->datatables->where($this->db->dbprefix('products') . ".cf4", $cf4);
            }
            if ($cf5) {
                $this->datatables->where($this->db->dbprefix('products') . ".cf5", $cf5);
            }
            if ($cf6) {
                $this->datatables->where($this->db->dbprefix('products') . ".cf6", $cf6);
            }
            if ($category) {
                $this->datatables->where($this->db->dbprefix('products') . ".category_id", $category);
            }
            if ($subcategory) {
                $this->datatables->where($this->db->dbprefix('products') . ".subcategory_id", $subcategory);
            }
            if ($brand) {
                $this->datatables->where($this->db->dbprefix('products') . ".brand", $brand);
            }

            echo $this->datatables->generate();

        }

    }

    function categories()
    {
        $this->sma->checkPermissions('products');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['categories'] = $this->site->getAllCategories();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        if ($this->input->post('start_date')) {
            $dt = "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
        } else {
            $dt = "Till " . $this->input->post('end_date');
        }
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('categories_report')));
        $meta = array('page_title' => lang('categories_report'), 'bc' => $bc);
        $this->page_construct('reports/categories', $meta, $this->data);
    }

    function getCategoriesReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('products', TRUE);
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $category = $this->input->get('category') ? $this->input->get('category') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        $pp = "( SELECT pp.category_id as category, SUM( pi.quantity ) purchasedQty, SUM( pi.subtotal ) totalPurchase from {$this->db->dbprefix('products')} pp
                left JOIN " . $this->db->dbprefix('purchase_items') . " pi ON pp.id = pi.product_id
                left join " . $this->db->dbprefix('purchases') . " p ON p.id = pi.purchase_id ";
        $sp = "( SELECT sp.category_id as category, SUM( si.quantity ) soldQty, SUM( si.subtotal ) totalSale from {$this->db->dbprefix('products')} sp
                left JOIN " . $this->db->dbprefix('sale_items') . " si ON sp.id = si.product_id
                left join " . $this->db->dbprefix('sales') . " s ON s.id = si.sale_id ";
        if ($start_date || $warehouse) {
            $pp .= " WHERE ";
            $sp .= " WHERE ";
            if ($start_date) {
                $start_date = $this->sma->fld($start_date);
                $end_date = $end_date ? $this->sma->fld($end_date) : date('Y-m-d');
                $pp .= " p.date >= '{$start_date}' AND p.date < '{$end_date}' ";
                $sp .= " s.date >= '{$start_date}' AND s.date < '{$end_date}' ";
                if ($warehouse) {
                    $pp .= " AND ";
                    $sp .= " AND ";
                }
            }
            if ($warehouse) {
                $pp .= " pi.warehouse_id = '{$warehouse}' ";
                $sp .= " si.warehouse_id = '{$warehouse}' ";
            }
        }
        $pp .= " GROUP BY pp.category_id ) PCosts";
        $sp .= " GROUP BY sp.category_id ) PSales";

        if ($pdf || $xls) {

            $this->db
                ->select($this->db->dbprefix('categories') . ".code, " . $this->db->dbprefix('categories') . ".name,
                    SUM( COALESCE( PCosts.purchasedQty, 0 ) ) as PurchasedQty,
                    SUM( COALESCE( PSales.soldQty, 0 ) ) as SoldQty,
                    SUM( COALESCE( PCosts.totalPurchase, 0 ) ) as TotalPurchase,
                    SUM( COALESCE( PSales.totalSale, 0 ) ) as TotalSales,
                    (SUM( COALESCE( PSales.totalSale, 0 ) )- SUM( COALESCE( PCosts.totalPurchase, 0 ) ) ) as Profit", FALSE)
                ->from('categories')
                ->join($sp, 'categories.id = PSales.category', 'left')
                ->join($pp, 'categories.id = PCosts.category', 'left')
                ->group_by('categories.id, categories.code, categories.name')
                ->order_by('categories.code', 'asc');

            if ($category) {
                $this->db->where($this->db->dbprefix('categories') . ".id", $category);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('categories_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('category_code'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('category_name'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('purchased'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('sold'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('purchased_amount'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('sold_amount'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('profit_loss'));

                $row = 2;
                $sQty = 0;
                $pQty = 0;
                $sAmt = 0;
                $pAmt = 0;
                $pl = 0;
                foreach ($data as $data_row) {
                    $profit = $data_row->TotalSales - $data_row->TotalPurchase;
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->code);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->PurchasedQty);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->SoldQty);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->TotalPurchase);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->TotalSales);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $profit);
                    $pQty += $data_row->PurchasedQty;
                    $sQty += $data_row->SoldQty;
                    $pAmt += $data_row->TotalPurchase;
                    $sAmt += $data_row->TotalSales;
                    $pl += $profit;
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("C" . $row . ":G" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('C' . $row, $pQty);
                $this->excel->getActiveSheet()->SetCellValue('D' . $row, $sQty);
                $this->excel->getActiveSheet()->SetCellValue('E' . $row, $pAmt);
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $sAmt);
                $this->excel->getActiveSheet()->SetCellValue('G' . $row, $pl);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C2:G' . $row)->getAlignment()->setWrapText(true);
                $filename = 'categories_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {


            $this->load->library('datatables');
            $this->datatables
                ->select($this->db->dbprefix('categories') . ".id as cid, " .$this->db->dbprefix('categories') . ".code, " . $this->db->dbprefix('categories') . ".name,
                    SUM( COALESCE( PCosts.purchasedQty, 0 ) ) as PurchasedQty,
                    SUM( COALESCE( PSales.soldQty, 0 ) ) as SoldQty,
                    SUM( COALESCE( PCosts.totalPurchase, 0 ) ) as TotalPurchase,
                    SUM( COALESCE( PSales.totalSale, 0 ) ) as TotalSales,
                    (SUM( COALESCE( PSales.totalSale, 0 ) )- SUM( COALESCE( PCosts.totalPurchase, 0 ) ) ) as Profit", FALSE)
                ->from('categories')
                ->join($sp, 'categories.id = PSales.category', 'left')
                ->join($pp, 'categories.id = PCosts.category', 'left');

            if ($category) {
                $this->datatables->where('categories.id', $category);
            }
            $this->datatables->group_by('categories.id, categories.code, categories.name, PSales.SoldQty, PSales.totalSale, PCosts.purchasedQty, PCosts.totalPurchase');
            $this->datatables->unset_column('cid');
            echo $this->datatables->generate();

        }

    }

    function brands()
    {
        $this->sma->checkPermissions('products');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['brands'] = $this->site->getAllBrands();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        if ($this->input->post('start_date')) {
            $dt = "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
        } else {
            $dt = "Till " . $this->input->post('end_date');
        }
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('brands_report')));
        $meta = array('page_title' => lang('brands_report'), 'bc' => $bc);
        $this->page_construct('reports/brands', $meta, $this->data);
    }

    function getBrandsReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('products', TRUE);
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $brand = $this->input->get('brand') ? $this->input->get('brand') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        $pp = "( SELECT pp.brand as brand, SUM( pi.quantity ) purchasedQty, SUM( pi.subtotal ) totalPurchase from {$this->db->dbprefix('products')} pp
                left JOIN " . $this->db->dbprefix('purchase_items') . " pi ON pp.id = pi.product_id
                left join " . $this->db->dbprefix('purchases') . " p ON p.id = pi.purchase_id ";
        $sp = "( SELECT sp.brand as brand, SUM( si.quantity ) soldQty, SUM( si.subtotal ) totalSale from {$this->db->dbprefix('products')} sp
                left JOIN " . $this->db->dbprefix('sale_items') . " si ON sp.id = si.product_id
                left join " . $this->db->dbprefix('sales') . " s ON s.id = si.sale_id ";
        if ($start_date || $warehouse) {
            $pp .= " WHERE ";
            $sp .= " WHERE ";
            if ($start_date) {
                $start_date = $this->sma->fld($start_date);
                $end_date = $end_date ? $this->sma->fld($end_date) : date('Y-m-d');
                $pp .= " p.date >= '{$start_date}' AND p.date < '{$end_date}' ";
                $sp .= " s.date >= '{$start_date}' AND s.date < '{$end_date}' ";
                if ($warehouse) {
                    $pp .= " AND ";
                    $sp .= " AND ";
                }
            }
            if ($warehouse) {
                $pp .= " pi.warehouse_id = '{$warehouse}' ";
                $sp .= " si.warehouse_id = '{$warehouse}' ";
            }
        }
        $pp .= " GROUP BY pp.brand ) PCosts";
        $sp .= " GROUP BY sp.brand ) PSales";

        if ($pdf || $xls) {

            $this->db
                ->select($this->db->dbprefix('brands') . ".name,
                    SUM( COALESCE( PCosts.purchasedQty, 0 ) ) as PurchasedQty,
                    SUM( COALESCE( PSales.soldQty, 0 ) ) as SoldQty,
                    SUM( COALESCE( PCosts.totalPurchase, 0 ) ) as TotalPurchase,
                    SUM( COALESCE( PSales.totalSale, 0 ) ) as TotalSales,
                    (SUM( COALESCE( PSales.totalSale, 0 ) )- SUM( COALESCE( PCosts.totalPurchase, 0 ) ) ) as Profit", FALSE)
                ->from('brands')
                ->join($sp, 'brands.id = PSales.brand', 'left')
                ->join($pp, 'brands.id = PCosts.brand', 'left')
                ->group_by('brands.id, brands.name')
                ->order_by('brands.code', 'asc');

            if ($brand) {
                $this->db->where($this->db->dbprefix('brands') . ".id", $brand);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('brands_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('brands'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('purchased'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('sold'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('purchased_amount'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('sold_amount'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('profit_loss'));

                $row = 2; $sQty = 0; $pQty = 0; $sAmt = 0; $pAmt = 0; $pl = 0;
                foreach ($data as $data_row) {
                    $profit = $data_row->TotalSales - $data_row->TotalPurchase;
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->PurchasedQty);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->SoldQty);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->TotalPurchase);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->TotalSales);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $profit);
                    $pQty += $data_row->PurchasedQty;
                    $sQty += $data_row->SoldQty;
                    $pAmt += $data_row->TotalPurchase;
                    $sAmt += $data_row->TotalSales;
                    $pl += $profit;
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("B" . $row . ":F" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('B' . $row, $pQty);
                $this->excel->getActiveSheet()->SetCellValue('C' . $row, $sQty);
                $this->excel->getActiveSheet()->SetCellValue('D' . $row, $pAmt);
                $this->excel->getActiveSheet()->SetCellValue('E' . $row, $sAmt);
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $pl);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C2:G' . $row)->getAlignment()->setWrapText(true);
                $filename = 'brands_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {


            $this->load->library('datatables');
            $this->datatables
                ->select($this->db->dbprefix('brands') . ".id as id, " . $this->db->dbprefix('brands') . ".name,
                    SUM( COALESCE( PCosts.purchasedQty, 0 ) ) as PurchasedQty,
                    SUM( COALESCE( PSales.soldQty, 0 ) ) as SoldQty,
                    SUM( COALESCE( PCosts.totalPurchase, 0 ) ) as TotalPurchase,
                    SUM( COALESCE( PSales.totalSale, 0 ) ) as TotalSales,
                    (SUM( COALESCE( PSales.totalSale, 0 ) )- SUM( COALESCE( PCosts.totalPurchase, 0 ) ) ) as Profit", FALSE)
                ->from('brands')
                ->join($sp, 'brands.id = PSales.brand', 'left')
                ->join($pp, 'brands.id = PCosts.brand', 'left');

            if ($brand) {
                $this->datatables->where('brands.id', $brand);
            }
            $this->datatables->group_by('brands.id, brands.name, PSales.SoldQty, PSales.totalSale, PCosts.purchasedQty, PCosts.totalPurchase');
            $this->datatables->unset_column('id');
            echo $this->datatables->generate();

        }

    }

    function profit($date = NULL, $warehouse_id = NULL, $re = NULL)
    {
        if ( ! $this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            $this->sma->md();
        }
        if ( ! $date) { $date = date('Y-m-d'); }
        $this->data['costing'] = $this->reports_model->getCosting($date, $warehouse_id);
        $this->data['discount'] = $this->reports_model->getOrderDiscount($date, $warehouse_id);
        $this->data['expenses'] = $this->reports_model->getExpenses($date, $warehouse_id);
        $this->data['returns'] = $this->reports_model->getReturns($date, $warehouse_id);
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['swh'] = $warehouse_id;
        $this->data['date'] = $date;
        if ($re) {
            echo $this->load->view($this->theme . 'reports/profit', $this->data, TRUE);
            exit();
        }
        $this->load->view($this->theme . 'reports/profit', $this->data);
    }
    function monthly_profit($year, $month, $warehouse_id = NULL, $re = NULL)
    {
        if ( ! $this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            $this->sma->md();
        }

        $this->data['costing'] = $this->reports_model->getCosting(NULL, $warehouse_id, $year, $month);
        $this->data['discount'] = $this->reports_model->getOrderDiscount(NULL, $warehouse_id, $year, $month);
        $this->data['expenses'] = $this->reports_model->getExpenses(NULL, $warehouse_id, $year, $month);
        $this->data['returns'] = $this->reports_model->getReturns(NULL, $warehouse_id, $year, $month);
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['swh'] = $warehouse_id;
        $this->data['year'] = $year;
        $this->data['month'] = $month;
        $this->data['date'] = date('F Y', strtotime($year.'-'.$month.'-'.'01'));
        if ($re) {
            echo $this->load->view($this->theme . 'reports/monthly_profit', $this->data, TRUE);
            exit();
        }
        $this->load->view($this->theme . 'reports/monthly_profit', $this->data);
    }

    function daily_sales($warehouse_id = NULL, $year = NULL, $month = NULL, $pdf = NULL, $user_id = NULL)
    {
        $this->sma->checkPermissions();
        if (!$this->Owner && !$this->Admin && $this->session->userdata('warehouse_id')) {
            $warehouse_id = $this->session->userdata('warehouse_id');
        }
        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }
        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $config = array(
            'show_next_prev' => TRUE,
            'next_prev_url' => admin_url('reports/daily_sales/'.($warehouse_id ? $warehouse_id : 0)),
            'month_type' => 'long',
            'day_type' => 'long'
        );

        $config['template'] = '{table_open}<div class="table-responsive"><table border="0" cellpadding="0" cellspacing="0" class="table table-bordered dfTable">{/table_open}
        {heading_row_start}<tr>{/heading_row_start}
        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}" id="month_year">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
        {heading_row_end}</tr>{/heading_row_end}
        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td class="cl_wday">{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}
        {cal_row_start}<tr class="days">{/cal_row_start}
        {cal_cell_start}<td class="day">{/cal_cell_start}
        {cal_cell_content}
        <div class="day_num">{day}</div>
        <div class="content">{content}</div>
        {/cal_cell_content}
        {cal_cell_content_today}
        <div class="day_num highlight">{day}</div>
        <div class="content">{content}</div>
        {/cal_cell_content_today}
        {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
        {cal_cell_blank}&nbsp;{/cal_cell_blank}
        {cal_cell_end}</td>{/cal_cell_end}
        {cal_row_end}</tr>{/cal_row_end}
        {table_close}</table></div>{/table_close}';

        $this->load->library('calendar', $config);
        $sales = $user_id ? $this->reports_model->getStaffDailySales($user_id, $year, $month, $warehouse_id) : $this->reports_model->getDailySales($year, $month, $warehouse_id);

        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $daily_sale[$sale->date] = "<table class='table table-bordered table-hover table-striped table-condensed data' style='margin:0;'><tr><td>" . lang("discount") . "</td><td>" . $this->sma->formatMoney($sale->discount) . "</td></tr><tr><td>" . lang("shipping") . "</td><td>" . $this->sma->formatMoney($sale->shipping) . "</td></tr><tr><td>" . lang("product_tax") . "</td><td>" . $this->sma->formatMoney($sale->tax1) . "</td></tr><tr><td>" . lang("order_tax") . "</td><td>" . $this->sma->formatMoney($sale->tax2) . "</td></tr><tr><td>" . lang("total") . "</td><td>" . $this->sma->formatMoney($sale->total) . "</td></tr></table>";
            }
        } else {
            $daily_sale = array();
        }

        $this->data['calender'] = $this->calendar->generate($year, $month, $daily_sale);
        $this->data['year'] = $year;
        $this->data['month'] = $month;
        if ($pdf) {
            $html = $this->load->view($this->theme . 'reports/daily', $this->data, true);
            $name = lang("daily_sales") . "_" . $year . "_" . $month . ".pdf";
            $html = str_replace('<p class="introtext">' . lang("reports_calendar_text") . '</p>', '', $html);
            $this->sma->generate_pdf($html, $name, null, null, null, null, null, 'L');
        }
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['warehouse_id'] = $warehouse_id;
        $this->data['sel_warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('daily_sales_report')));
        $meta = array('page_title' => lang('daily_sales_report'), 'bc' => $bc);
        $this->page_construct('reports/daily', $meta, $this->data);

    }


    function monthly_sales($warehouse_id = NULL, $year = NULL, $pdf = NULL, $user_id = NULL)
    {
        $this->sma->checkPermissions();
        if (!$this->Owner && !$this->Admin && $this->session->userdata('warehouse_id')) {
            $warehouse_id = $this->session->userdata('warehouse_id');
        }
        if (!$year) {
            $year = date('Y');
        }
        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->load->language('calendar');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['year'] = $year;
        $this->data['sales'] = $user_id ? $this->reports_model->getStaffMonthlySales($user_id, $year, $warehouse_id) : $this->reports_model->getMonthlySales($year, $warehouse_id);
        if ($pdf) {
            $html = $this->load->view($this->theme . 'reports/monthly', $this->data, true);
            $name = lang("monthly_sales") . "_" . $year . ".pdf";
            $html = str_replace('<p class="introtext">' . lang("reports_calendar_text") . '</p>', '', $html);
            $this->sma->generate_pdf($html, $name, null, null, null, null, null, 'L');
        }
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['warehouse_id'] = $warehouse_id;
        $this->data['sel_warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('monthly_sales_report')));
        $meta = array('page_title' => lang('monthly_sales_report'), 'bc' => $bc);
        $this->page_construct('reports/monthly', $meta, $this->data);

    }

    function sales()
    {
        $this->sma->checkPermissions('sales');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('sales_report')));
        $meta = array('page_title' => lang('sales_report'), 'bc' => $bc);
        $this->page_construct('reports/sales', $meta, $this->data);
    }

    function getSalesReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('sales', TRUE);
        $product = $this->input->get('product') ? $this->input->get('product') : NULL;
        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $customer = $this->input->get('customer') ? $this->input->get('customer') : NULL;
        $biller = $this->input->get('biller') ? $this->input->get('biller') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $reference_no = $this->input->get('reference_no') ? $this->input->get('reference_no') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        $serial = $this->input->get('serial') ? $this->input->get('serial') : NULL;

        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }
        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $user = $this->session->userdata('user_id');
        }

        if ($pdf || $xls) {

            $this->db
                ->select("date, reference_no, biller, customer, GROUP_CONCAT(CONCAT(" . $this->db->dbprefix('sale_items') . ".product_name, ' (', " . $this->db->dbprefix('sale_items') . ".quantity, ')') SEPARATOR '\n') as iname, grand_total, paid, payment_status", FALSE)
                ->from('sales')
                ->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
                ->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left')
                ->group_by('sales.id')
                ->order_by('sales.date desc');

            if ($user) {
                $this->db->where('sales.created_by', $user);
            }
            if ($product) {
                $this->db->where('sale_items.product_id', $product);
            }
            if ($serial) {
                $this->db->like('sale_items.serial_no', $serial);
            }
            if ($biller) {
                $this->db->where('sales.biller_id', $biller);
            }
            if ($customer) {
                $this->db->where('sales.customer_id', $customer);
            }
            if ($warehouse) {
                $this->db->where('sales.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->db->like('sales.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->db->where($this->db->dbprefix('sales').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('sales_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('biller'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('product_qty'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));
                $this->excel->getActiveSheet()->SetCellValue('I1', lang('payment_status'));

                $row = 2;
                $total = 0;
                $paid = 0;
                $balance = 0;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference_no);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->biller);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->customer);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->iname);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->grand_total);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->paid);
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, ($data_row->grand_total - $data_row->paid));
                    $this->excel->getActiveSheet()->SetCellValue('I' . $row, lang($data_row->payment_status));
                    $total += $data_row->grand_total;
                    $paid += $data_row->paid;
                    $balance += ($data_row->grand_total - $data_row->paid);
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("F" . $row . ":H" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $total);
                $this->excel->getActiveSheet()->SetCellValue('G' . $row, $paid);
                $this->excel->getActiveSheet()->SetCellValue('H' . $row, $balance);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E2:E' . $row)->getAlignment()->setWrapText(true);
                $filename = 'sales_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $si = "( SELECT sale_id, product_id, serial_no, GROUP_CONCAT(CONCAT({$this->db->dbprefix('sale_items')}.product_name, '__', {$this->db->dbprefix('sale_items')}.quantity) SEPARATOR '___') as item_nane from {$this->db->dbprefix('sale_items')} ";
            if ($product || $serial) { $si .= " WHERE "; }
            if ($product) {
                $si .= " {$this->db->dbprefix('sale_items')}.product_id = {$product} ";
            }
            if ($product && $serial) { $si .= " AND "; }
            if ($serial) {
                $si .= " {$this->db->dbprefix('sale_items')}.serial_no LIKe '%{$serial}%' ";
            }
            $si .= " GROUP BY {$this->db->dbprefix('sale_items')}.sale_id ) FSI";
            $this->load->library('datatables');
            $this->datatables
                ->select("DATE_FORMAT(date, '%Y-%m-%d %T') as date, reference_no, biller, customer, FSI.item_nane as iname, grand_total, paid, (grand_total-paid) as balance, payment_status, {$this->db->dbprefix('sales')}.id as id", FALSE)
                ->from('sales')
                ->join($si, 'FSI.sale_id=sales.id', 'left')
                ->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left');
                // ->group_by('sales.id');

            if ($user) {
                $this->datatables->where('sales.created_by', $user);
            }
            if ($product) {
                $this->datatables->where('FSI.product_id', $product);
            }
            if ($serial) {
                $this->datatables->like('FSI.serial_no', $serial);
            }
            if ($biller) {
                $this->datatables->where('sales.biller_id', $biller);
            }
            if ($customer) {
                $this->datatables->where('sales.customer_id', $customer);
            }
            if ($warehouse) {
                $this->datatables->where('sales.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->datatables->like('sales.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->datatables->where($this->db->dbprefix('sales').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();

        }

    }

    function getQuotesReport($pdf = NULL, $xls = NULL)
    {

        if ($this->input->get('product')) {
            $product = $this->input->get('product');
        } else {
            $product = NULL;
        }
        if ($this->input->get('user')) {
            $user = $this->input->get('user');
        } else {
            $user = NULL;
        }
        if ($this->input->get('customer')) {
            $customer = $this->input->get('customer');
        } else {
            $customer = NULL;
        }
        if ($this->input->get('biller')) {
            $biller = $this->input->get('biller');
        } else {
            $biller = NULL;
        }
        if ($this->input->get('warehouse')) {
            $warehouse = $this->input->get('warehouse');
        } else {
            $warehouse = NULL;
        }
        if ($this->input->get('reference_no')) {
            $reference_no = $this->input->get('reference_no');
        } else {
            $reference_no = NULL;
        }
        if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }
        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }
        if ($pdf || $xls) {

            $this->db
                ->select("date, reference_no, biller, customer, GROUP_CONCAT(CONCAT(" . $this->db->dbprefix('quote_items') . ".product_name, ' (', " . $this->db->dbprefix('quote_items') . ".quantity, ')') SEPARATOR '<br>') as iname, grand_total, status", FALSE)
                ->from('quotes')
                ->join('quote_items', 'quote_items.quote_id=quotes.id', 'left')
                ->join('warehouses', 'warehouses.id=quotes.warehouse_id', 'left')
                ->group_by('quotes.id');

            if ($user) {
                $this->db->where('quotes.created_by', $user);
            }
            if ($product) {
                $this->db->where('quote_items.product_id', $product);
            }
            if ($biller) {
                $this->db->where('quotes.biller_id', $biller);
            }
            if ($customer) {
                $this->db->where('quotes.customer_id', $customer);
            }
            if ($warehouse) {
                $this->db->where('quotes.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->db->like('quotes.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->db->where($this->db->dbprefix('quotes').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('quotes_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('biller'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('product_qty'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('status'));

                $row = 2;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference_no);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->biller);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->customer);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->iname);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->grand_total);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->status);
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E2:E' . $row)->getAlignment()->setWrapText(true);
                $filename = 'quotes_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $qi = "( SELECT quote_id, product_id, GROUP_CONCAT(CONCAT({$this->db->dbprefix('quote_items')}.product_name, '__', {$this->db->dbprefix('quote_items')}.quantity) SEPARATOR '___') as item_nane from {$this->db->dbprefix('quote_items')} ";
            if ($product) {
                $qi .= " WHERE {$this->db->dbprefix('quote_items')}.product_id = {$product} ";
            }
            $qi .= " GROUP BY {$this->db->dbprefix('quote_items')}.quote_id ) FQI";
            $this->load->library('datatables');
            $this->datatables
                ->select("date, reference_no, biller, customer, FQI.item_nane as iname, grand_total, status, {$this->db->dbprefix('quotes')}.id as id", FALSE)
                ->from('quotes')
                ->join($qi, 'FQI.quote_id=quotes.id', 'left')
                ->join('warehouses', 'warehouses.id=quotes.warehouse_id', 'left')
                ->group_by('quotes.id');

            if ($user) {
                $this->datatables->where('quotes.created_by', $user);
            }
            if ($product) {
                $this->datatables->where('FQI.product_id', $product, FALSE);
            }
            if ($biller) {
                $this->datatables->where('quotes.biller_id', $biller);
            }
            if ($customer) {
                $this->datatables->where('quotes.customer_id', $customer);
            }
            if ($warehouse) {
                $this->datatables->where('quotes.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->datatables->like('quotes.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->datatables->where($this->db->dbprefix('quotes').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();

        }

    }

    function getTransfersReport($pdf = NULL, $xls = NULL)
    {
        if ($this->input->get('product')) {
            $product = $this->input->get('product');
        } else {
            $product = NULL;
        }

        if ($pdf || $xls) {

            $this->db
                ->select($this->db->dbprefix('transfers') . ".date, transfer_no, (CASE WHEN " . $this->db->dbprefix('transfers') . ".status = 'completed' THEN  GROUP_CONCAT(CONCAT(" . $this->db->dbprefix('purchase_items') . ".product_name, ' (', " . $this->db->dbprefix('purchase_items') . ".quantity, ')') SEPARATOR '<br>') ELSE GROUP_CONCAT(CONCAT(" . $this->db->dbprefix('transfer_items') . ".product_name, ' (', " . $this->db->dbprefix('transfer_items') . ".quantity, ')') SEPARATOR '<br>') END) as iname, from_warehouse_name as fname, from_warehouse_code as fcode, to_warehouse_name as tname,to_warehouse_code as tcode, grand_total, " . $this->db->dbprefix('transfers') . ".status")
                ->from('transfers')
                ->join('transfer_items', 'transfer_items.transfer_id=transfers.id', 'left')
                ->join('purchase_items', 'purchase_items.transfer_id=transfers.id', 'left')
                ->group_by('transfers.id')->order_by('transfers.date desc');
            if ($product) {
                $this->db->where($this->db->dbprefix('purchase_items') . ".product_id", $product);
                $this->db->or_where($this->db->dbprefix('transfer_items') . ".product_id", $product);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('transfers_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('transfer_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('product_qty'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('warehouse') . ' (' . lang('from') . ')');
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('warehouse') . ' (' . lang('to') . ')');
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('status'));

                $row = 2;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->transfer_no);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->iname);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->fname . ' (' . $data_row->fcode . ')');
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->tname . ' (' . $data_row->tcode . ')');
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->grand_total);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->status);
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C2:C' . $row)->getAlignment()->setWrapText(true);
                $filename = 'transfers_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');
            $this->datatables
                ->select("{$this->db->dbprefix('transfers')}.date, transfer_no, (CASE WHEN {$this->db->dbprefix('transfers')}.status = 'completed' THEN  GROUP_CONCAT(CONCAT({$this->db->dbprefix('purchase_items')}.product_name, '__', {$this->db->dbprefix('purchase_items')}.quantity) SEPARATOR '___') ELSE GROUP_CONCAT(CONCAT({$this->db->dbprefix('transfer_items')}.product_name, '__', {$this->db->dbprefix('transfer_items')}.quantity) SEPARATOR '___') END) as iname, from_warehouse_name as fname, from_warehouse_code as fcode, to_warehouse_name as tname,to_warehouse_code as tcode, grand_total, {$this->db->dbprefix('transfers')}.status, {$this->db->dbprefix('transfers')}.id as id", FALSE)
                ->from('transfers')
                ->join('transfer_items', 'transfer_items.transfer_id=transfers.id', 'left')
                ->join('purchase_items', 'purchase_items.transfer_id=transfers.id', 'left')
                ->group_by('transfers.id');
            if ($product) {
                $this->datatables->where(" (({$this->db->dbprefix('purchase_items')}.product_id = {$product}) OR ({$this->db->dbprefix('transfer_items')}.product_id = {$product})) ", NULL, FALSE);
            }
            $this->datatables->edit_column("fname", "$1 ($2)", "fname, fcode")
                ->edit_column("tname", "$1 ($2)", "tname, tcode")
                ->unset_column('fcode')
                ->unset_column('tcode');
            echo $this->datatables->generate();

        }

    }

    function purchases()
    {
        $this->sma->checkPermissions('purchases');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('purchases_report')));
        $meta = array('page_title' => lang('purchases_report'), 'bc' => $bc);
        $this->page_construct('reports/purchases', $meta, $this->data);
    }

    function getPurchasesReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('purchases', TRUE);

        $product = $this->input->get('product') ? $this->input->get('product') : NULL;
        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $supplier = $this->input->get('supplier') ? $this->input->get('supplier') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $reference_no = $this->input->get('reference_no') ? $this->input->get('reference_no') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }
        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $user = $this->session->userdata('user_id');
        }

        if ($pdf || $xls) {

            $this->db
                ->select("" . $this->db->dbprefix('purchases') . ".date, reference_no, " . $this->db->dbprefix('warehouses') . ".name as wname, supplier, GROUP_CONCAT(CONCAT(" . $this->db->dbprefix('purchase_items') . ".product_name, ' (', " . $this->db->dbprefix('purchase_items') . ".quantity, ')') SEPARATOR '\n') as iname, grand_total, paid, " . $this->db->dbprefix('purchases') . ".status", FALSE)
                ->from('purchases')
                ->join('purchase_items', 'purchase_items.purchase_id=purchases.id', 'left')
                ->join('warehouses', 'warehouses.id=purchases.warehouse_id', 'left')
                ->group_by('purchases.id')
                ->order_by('purchases.date desc');

            if ($user) {
                $this->db->where('purchases.created_by', $user);
            }
            if ($product) {
                $this->db->where('purchase_items.product_id', $product);
            }
            if ($supplier) {
                $this->db->where('purchases.supplier_id', $supplier);
            }
            if ($warehouse) {
                $this->db->where('purchases.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->db->like('purchases.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->db->where($this->db->dbprefix('purchases').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('purchase_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('warehouse'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('supplier'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('product_qty'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('grand_total'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));
                $this->excel->getActiveSheet()->SetCellValue('I1', lang('status'));

                $row = 2;
                $total = 0;
                $paid = 0;
                $balance = 0;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference_no);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->wname);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->supplier);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->iname);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->grand_total);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->paid);
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, ($data_row->grand_total - $data_row->paid));
                    $this->excel->getActiveSheet()->SetCellValue('I' . $row, $data_row->status);
                    $total += $data_row->grand_total;
                    $paid += $data_row->paid;
                    $balance += ($data_row->grand_total - $data_row->paid);
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("F" . $row . ":H" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $total);
                $this->excel->getActiveSheet()->SetCellValue('G' . $row, $paid);
                $this->excel->getActiveSheet()->SetCellValue('H' . $row, $balance);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E2:E' . $row)->getAlignment()->setWrapText(true);
                $filename = 'purchase_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $pi = "( SELECT purchase_id, product_id, (GROUP_CONCAT(CONCAT({$this->db->dbprefix('purchase_items')}.product_name, '__', {$this->db->dbprefix('purchase_items')}.quantity) SEPARATOR '___')) as item_nane from {$this->db->dbprefix('purchase_items')} ";
            if ($product) {
                $pi .= " WHERE {$this->db->dbprefix('purchase_items')}.product_id = {$product} ";
            }
            $pi .= " GROUP BY {$this->db->dbprefix('purchase_items')}.purchase_id ) FPI";

            $this->load->library('datatables');
            $this->datatables
                ->select("DATE_FORMAT({$this->db->dbprefix('purchases')}.date, '%Y-%m-%d %T') as date, reference_no, {$this->db->dbprefix('warehouses')}.name as wname, supplier, (FPI.item_nane) as iname, grand_total, paid, (grand_total-paid) as balance, {$this->db->dbprefix('purchases')}.status, {$this->db->dbprefix('purchases')}.id as id", FALSE)
                ->from('purchases')
                ->join($pi, 'FPI.purchase_id=purchases.id', 'left')
                ->join('warehouses', 'warehouses.id=purchases.warehouse_id', 'left');
                // ->group_by('purchases.id');

            if ($user) {
                $this->datatables->where('purchases.created_by', $user);
            }
            if ($product) {
                $this->datatables->where('FPI.product_id', $product, FALSE);
            }
            if ($supplier) {
                $this->datatables->where('purchases.supplier_id', $supplier);
            }
            if ($warehouse) {
                $this->datatables->where('purchases.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->datatables->like('purchases.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->datatables->where($this->db->dbprefix('purchases').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();

        }

    }

    function payments()
    {
        $this->sma->checkPermissions('payments');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $this->data['pos_settings'] = POS ? $this->reports_model->getPOSSetting('biller') : FALSE;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('payments_report')));
        $meta = array('page_title' => lang('payments_report'), 'bc' => $bc);
        $this->page_construct('reports/payments', $meta, $this->data);
    }

    function getPaymentsReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('payments', TRUE);

        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $supplier = $this->input->get('supplier') ? $this->input->get('supplier') : NULL;
        $customer = $this->input->get('customer') ? $this->input->get('customer') : NULL;
        $biller = $this->input->get('biller') ? $this->input->get('biller') : NULL;
        $payment_ref = $this->input->get('payment_ref') ? $this->input->get('payment_ref') : NULL;
        $paid_by = $this->input->get('paid_by') ? $this->input->get('paid_by') : NULL;
        $sale_ref = $this->input->get('sale_ref') ? $this->input->get('sale_ref') : NULL;
        $purchase_ref = $this->input->get('purchase_ref') ? $this->input->get('purchase_ref') : NULL;
        $card = $this->input->get('card') ? $this->input->get('card') : NULL;
        $cheque = $this->input->get('cheque') ? $this->input->get('cheque') : NULL;
        $transaction_id = $this->input->get('tid') ? $this->input->get('tid') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        if ($start_date) {
            $start_date = $this->sma->fsd($start_date);
            $end_date = $this->sma->fsd($end_date);
        }
        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $user = $this->session->userdata('user_id');
        }
        if ($pdf || $xls) {

            $this->db
                ->select("" . $this->db->dbprefix('payments') . ".date, " . $this->db->dbprefix('payments') . ".reference_no as payment_ref, " . $this->db->dbprefix('sales') . ".reference_no as sale_ref, " . $this->db->dbprefix('purchases') . ".reference_no as purchase_ref, paid_by, amount, type")
                ->from('payments')
                ->join('sales', 'payments.sale_id=sales.id', 'left')
                ->join('purchases', 'payments.purchase_id=purchases.id', 'left')
                ->group_by('payments.id')
                ->order_by('payments.date desc');

            if ($user) {
                $this->db->where('payments.created_by', $user);
            }
            if ($card) {
                $this->db->like('payments.cc_no', $card, 'both');
            }
            if ($cheque) {
                $this->db->where('payments.cheque_no', $cheque);
            }
            if ($transaction_id) {
                $this->db->where('payments.transaction_id', $transaction_id);
            }
            if ($customer) {
                $this->db->where('sales.customer_id', $customer);
            }
            if ($supplier) {
                $this->db->where('purchases.supplier_id', $supplier);
            }
            if ($biller) {
                $this->db->where('sales.biller_id', $biller);
            }
            if ($customer) {
                $this->db->where('sales.customer_id', $customer);
            }
            if ($payment_ref) {
                $this->db->like('payments.reference_no', $payment_ref, 'both');
            }
            if ($paid_by) {
                $this->db->where('payments.paid_by', $paid_by);
            }
            if ($sale_ref) {
                $this->db->like('sales.reference_no', $sale_ref, 'both');
            }
            if ($purchase_ref) {
                $this->db->like('purchases.reference_no', $purchase_ref, 'both');
            }
            if ($start_date) {
                $this->db->where($this->db->dbprefix('payments').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('payments_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('payment_reference'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('sale_reference'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('purchase_reference'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('paid_by'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('amount'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('type'));

                $row = 2;
                $total = 0;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->payment_ref);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->sale_ref);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->purchase_ref);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, lang($data_row->paid_by));
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->amount);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->type);
                    if ($data_row->type == 'returned' || $data_row->type == 'sent') {
                        $total -= $data_row->amount;
                    } else {
                        $total += $data_row->amount;
                    }
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("F" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $total);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $filename = 'payments_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');
            $this->datatables
                ->select("DATE_FORMAT({$this->db->dbprefix('payments')}.date, '%Y-%m-%d %T') as date, " . $this->db->dbprefix('payments') . ".reference_no as payment_ref, " . $this->db->dbprefix('sales') . ".reference_no as sale_ref, " . $this->db->dbprefix('purchases') . ".reference_no as purchase_ref, paid_by, amount, type, {$this->db->dbprefix('payments')}.id as id")
                ->from('payments')
                ->join('sales', 'payments.sale_id=sales.id', 'left')
                ->join('purchases', 'payments.purchase_id=purchases.id', 'left')
                ->group_by('payments.id');

            if ($user) {
                $this->datatables->where('payments.created_by', $user);
            }
            if ($card) {
                $this->datatables->like('payments.cc_no', $card, 'both');
            }
            if ($cheque) {
                $this->datatables->where('payments.cheque_no', $cheque);
            }
            if ($transaction_id) {
                $this->datatables->where('payments.transaction_id', $transaction_id);
            }
            if ($customer) {
                $this->datatables->where('sales.customer_id', $customer);
            }
            if ($supplier) {
                $this->datatables->where('purchases.supplier_id', $supplier);
            }
            if ($biller) {
                $this->datatables->where('sales.biller_id', $biller);
            }
            if ($customer) {
                $this->datatables->where('sales.customer_id', $customer);
            }
            if ($payment_ref) {
                $this->datatables->like('payments.reference_no', $payment_ref, 'both');
            }
            if ($paid_by) {
                $this->datatables->where('payments.paid_by', $paid_by);
            }
            if ($sale_ref) {
                $this->datatables->like('sales.reference_no', $sale_ref, 'both');
            }
            if ($purchase_ref) {
                $this->datatables->like('purchases.reference_no', $purchase_ref, 'both');
            }
            if ($start_date) {
                $this->datatables->where($this->db->dbprefix('payments').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();

        }

    }

    function customers()
    {
        $this->sma->checkPermissions('customers');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('customers_report')));
        $meta = array('page_title' => lang('customers_report'), 'bc' => $bc);
        $this->page_construct('reports/customers', $meta, $this->data);
    }

    function getCustomers($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('customers', TRUE);

        if ($pdf || $xls) {

            $this->db
                ->select($this->db->dbprefix('companies') . ".id as id, company, name, phone, email, count(" . $this->db->dbprefix('sales') . ".id) as total, COALESCE(sum(grand_total), 0) as total_amount, COALESCE(sum(paid), 0) as paid, ( COALESCE(sum(grand_total), 0) - COALESCE(sum(paid), 0)) as balance", FALSE)
                ->from("companies")
                ->join('sales', 'sales.customer_id=companies.id')
                ->where('companies.group_name', 'customer')
                ->order_by('companies.company asc')
                ->group_by('companies.id');

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('customers_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('company'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('phone'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('email'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('total_sales'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('total_amount'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));

                $row = 2;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->company);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->phone);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->email);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->total);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->sma->formatMoney($data_row->total_amount));
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $this->sma->formatMoney($data_row->paid));
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, $this->sma->formatMoney($data_row->balance));
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $filename = 'customers_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $s = "( SELECT customer_id, count(" . $this->db->dbprefix('sales') . ".id) as total, COALESCE(sum(grand_total), 0) as total_amount, COALESCE(sum(paid), 0) as paid, ( COALESCE(sum(grand_total), 0) - COALESCE(sum(paid), 0)) as balance from {$this->db->dbprefix('sales')} GROUP BY {$this->db->dbprefix('sales')}.customer_id ) FS";

            $this->load->library('datatables');
            $this->datatables
                ->select($this->db->dbprefix('companies') . ".id as id, company, name, phone, email, FS.total, FS.total_amount, FS.paid, FS.balance", FALSE)
                ->from("companies")
                ->join($s, 'FS.customer_id=companies.id')
                ->where('companies.group_name', 'customer')
                ->group_by('companies.id')
                ->add_column("Actions", "<div class='text-center'><a class=\"tip\" title='" . lang("view_report") . "' href='" . admin_url('reports/customer_report/$1') . "'><span class='label label-primary'>" . lang("view_report") . "</span></a></div>", "id")
                ->unset_column('id');
            echo $this->datatables->generate();

        }

    }

    function customer_report($user_id = NULL)
    {
        $this->sma->checkPermissions('customers', TRUE);
        if (!$user_id) {
            $this->session->set_flashdata('error', lang("no_customer_selected"));
            admin_redirect('reports/customers');
        }

        $this->data['sales'] = $this->reports_model->getSalesTotals($user_id);
        $this->data['total_sales'] = $this->reports_model->getCustomerSales($user_id);
        $this->data['total_quotes'] = $this->reports_model->getCustomerQuotes($user_id);
        $this->data['total_returns'] = $this->reports_model->getCustomerReturns($user_id);
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $this->data['user_id'] = $user_id;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('customers_report')));
        $meta = array('page_title' => lang('customers_report'), 'bc' => $bc);
        $this->page_construct('reports/customer_report', $meta, $this->data);

    }

    function suppliers()
    {
        $this->sma->checkPermissions('suppliers');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('suppliers_report')));
        $meta = array('page_title' => lang('suppliers_report'), 'bc' => $bc);
        $this->page_construct('reports/suppliers', $meta, $this->data);
    }

    function getSuppliers($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('suppliers', TRUE);

        if ($pdf || $xls) {

            $this->db
                ->select($this->db->dbprefix('companies') . ".id as id, company, name, phone, email, count({$this->db->dbprefix('purchases')}.id) as total, COALESCE(sum(grand_total), 0) as total_amount, COALESCE(sum(paid), 0) as paid, ( COALESCE(sum(grand_total), 0) - COALESCE(sum(paid), 0)) as balance", FALSE)
                ->from("companies")
                ->join('purchases', 'purchases.supplier_id=companies.id')
                ->where('companies.group_name', 'supplier')
                ->order_by('companies.company asc')
                ->group_by('companies.id');

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('suppliers_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('company'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('phone'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('email'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('total_purchases'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('total_amount'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('paid'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('balance'));

                $row = 2;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->company);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->phone);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->email);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->sma->formatDecimal($data_row->total));
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->sma->formatDecimal($data_row->total_amount));
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $this->sma->formatDecimal($data_row->paid));
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, $this->sma->formatDecimal($data_row->balance));
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $filename = 'suppliers_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $p = "( SELECT supplier_id, count(" . $this->db->dbprefix('purchases') . ".id) as total, COALESCE(sum(grand_total), 0) as total_amount, COALESCE(sum(paid), 0) as paid, ( COALESCE(sum(grand_total), 0) - COALESCE(sum(paid), 0)) as balance from {$this->db->dbprefix('purchases')} GROUP BY {$this->db->dbprefix('purchases')}.supplier_id ) FP";

            $this->load->library('datatables');
            $this->datatables
                ->select($this->db->dbprefix('companies') . ".id as id, company, name, phone, email, FP.total, FP.total_amount, FP.paid, FP.balance", FALSE)
                ->from("companies")
                ->join($p, 'FP.supplier_id=companies.id')
                ->where('companies.group_name', 'supplier')
                ->group_by('companies.id')
                ->add_column("Actions", "<div class='text-center'><a class=\"tip\" title='" . lang("view_report") . "' href='" . admin_url('reports/supplier_report/$1') . "'><span class='label label-primary'>" . lang("view_report") . "</span></a></div>", "id")
                ->unset_column('id');
            echo $this->datatables->generate();

        }

    }

    function supplier_report($user_id = NULL)
    {
        $this->sma->checkPermissions('suppliers', TRUE);
        if (!$user_id) {
            $this->session->set_flashdata('error', lang("no_supplier_selected"));
            admin_redirect('reports/suppliers');
        }

        $this->data['purchases'] = $this->reports_model->getPurchasesTotals($user_id);
        $this->data['total_purchases'] = $this->reports_model->getSupplierPurchases($user_id);
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');

        $this->data['user_id'] = $user_id;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('suppliers_report')));
        $meta = array('page_title' => lang('suppliers_report'), 'bc' => $bc);
        $this->page_construct('reports/supplier_report', $meta, $this->data);

    }

    function users()
    {
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('staff_report')));
        $meta = array('page_title' => lang('staff_report'), 'bc' => $bc);
        $this->page_construct('reports/users', $meta, $this->data);
    }

    function getUsers()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('users').".id as id, first_name, last_name, email, company, ".$this->db->dbprefix('groups').".name, active")
            ->from("users")
            ->join('groups', 'users.group_id=groups.id', 'left')
            ->group_by('users.id')
            ->where('company_id', NULL);
        if (!$this->Owner) {
            $this->datatables->where('group_id !=', 1);
        }
        $this->datatables
            ->edit_column('active', '$1__$2', 'active, id')
            ->add_column("Actions", "<div class='text-center'><a class=\"tip\" title='" . lang("view_report") . "' href='" . admin_url('reports/staff_report/$1') . "'><span class='label label-primary'>" . lang("view_report") . "</span></a></div>", "id")
            ->unset_column('id');
        echo $this->datatables->generate();
    }

    function staff_report($user_id = NULL, $year = NULL, $month = NULL, $pdf = NULL, $cal = 0)
    {

        if (!$user_id) {
            $this->session->set_flashdata('error', lang("no_user_selected"));
            admin_redirect('reports/users');
        }
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $this->data['purchases'] = $this->reports_model->getStaffPurchases($user_id);
        $this->data['sales'] = $this->reports_model->getStaffSales($user_id);
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $this->data['warehouses'] = $this->site->getAllWarehouses();

        if (!$year) {
            $year = date('Y');
        }
        if (!$month || $month == '#monthly-con') {
            $month = date('m');
        }
        if ($pdf) {
            if ($cal) {
                $this->monthly_sales($year, $pdf, $user_id);
            } else {
                $this->daily_sales($year, $month, $pdf, $user_id);
            }
        }
        $config = array(
            'show_next_prev' => TRUE,
            'next_prev_url' => admin_url('reports/staff_report/'.$user_id),
            'month_type' => 'long',
            'day_type' => 'long'
        );

        $config['template'] = '{table_open}<div class="table-responsive"><table border="0" cellpadding="0" cellspacing="0" class="table table-bordered dfTable reports-table">{/table_open}
        {heading_row_start}<tr>{/heading_row_start}
        {heading_previous_cell}<th class="text-center"><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th class="text-center" colspan="{colspan}" id="month_year">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th class="text-center"><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
        {heading_row_end}</tr>{/heading_row_end}
        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td class="cl_wday">{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}
        {cal_row_start}<tr class="days">{/cal_row_start}
        {cal_cell_start}<td class="day">{/cal_cell_start}
        {cal_cell_content}
        <div class="day_num">{day}</div>
        <div class="content">{content}</div>
        {/cal_cell_content}
        {cal_cell_content_today}
        <div class="day_num highlight">{day}</div>
        <div class="content">{content}</div>
        {/cal_cell_content_today}
        {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
        {cal_cell_blank}&nbsp;{/cal_cell_blank}
        {cal_cell_end}</td>{/cal_cell_end}
        {cal_row_end}</tr>{/cal_row_end}
        {table_close}</table></div>{/table_close}';

        $this->load->library('calendar', $config);
        $sales = $this->reports_model->getStaffDailySales($user_id, $year, $month);

        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $daily_sale[$sale->date] = "<table class='table table-bordered table-hover table-striped table-condensed data' style='margin:0;'><tr><td>" . lang("discount") . "</td><td>" . $this->sma->formatMoney($sale->discount) . "</td></tr><tr><td>" . lang("product_tax") . "</td><td>" . $this->sma->formatMoney($sale->tax1) . "</td></tr><tr><td>" . lang("order_tax") . "</td><td>" . $this->sma->formatMoney($sale->tax2) . "</td></tr><tr><td>" . lang("total") . "</td><td>" . $this->sma->formatMoney($sale->total) . "</td></tr></table>";
            }
        } else {
            $daily_sale = array();
        }
        $this->data['calender'] = $this->calendar->generate($year, $month, $daily_sale);
        if ($this->input->get('pdf')) {

        }
        $this->data['year'] = $year;
        $this->data['month'] = $month;
        $this->data['msales'] = $this->reports_model->getStaffMonthlySales($user_id, $year);
        $this->data['user_id'] = $user_id;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('staff_report')));
        $meta = array('page_title' => lang('staff_report'), 'bc' => $bc);
        $this->page_construct('reports/staff_report', $meta, $this->data);

    }

    function getUserLogins($id = NULL, $pdf = NULL, $xls = NULL)
    {
        if ($this->input->get('start_date')) {
            $login_start_date = $this->input->get('start_date');
        } else {
            $login_start_date = NULL;
        }
        if ($this->input->get('end_date')) {
            $login_end_date = $this->input->get('end_date');
        } else {
            $login_end_date = NULL;
        }
        if ($login_start_date) {
            $login_start_date = $this->sma->fld($login_start_date);
            $login_end_date = $login_end_date ? $this->sma->fld($login_end_date) : date('Y-m-d H:i:s');
        }
        if ($pdf || $xls) {

            $this->db
                ->select("login, ip_address, time")
                ->from("user_logins")
                ->where('user_id', $id)
                ->order_by('time desc');
            if ($login_start_date) {
                $this->db->where("time BETWEEN '{$login_start_date}' and '{$login_end_date}'", NULL, FALSE);
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('staff_login_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('email'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('ip_address'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('time'));

                $row = 2;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->login);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->ip_address);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $this->sma->hrld($data_row->time));
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C2:C' . $row)->getAlignment()->setWrapText(true);
                $filename = 'staff_login_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');
            $this->datatables
                ->select("login, ip_address, DATE_FORMAT(time, '%Y-%m-%d %T') as time")
                ->from("user_logins")
                ->where('user_id', $id);
            if ($login_start_date) {
                $this->datatables->where("time BETWEEN '{$login_start_date}' and '{$login_end_date}'", NULL, FALSE);
            }
            echo $this->datatables->generate();

        }

    }

    function getCustomerLogins($id = NULL)
    {
        if ($this->input->get('login_start_date')) {
            $login_start_date = $this->input->get('login_start_date');
        } else {
            $login_start_date = NULL;
        }
        if ($this->input->get('login_end_date')) {
            $login_end_date = $this->input->get('login_end_date');
        } else {
            $login_end_date = NULL;
        }
        if ($login_start_date) {
            $login_start_date = $this->sma->fld($login_start_date);
            $login_end_date = $login_end_date ? $this->sma->fld($login_end_date) : date('Y-m-d H:i:s');
        }
        $this->load->library('datatables');
        $this->datatables
            ->select("login, ip_address, time")
            ->from("user_logins")
            ->where('customer_id', $id);
        if ($login_start_date) {
            $this->datatables->where('time BETWEEN "' . $login_start_date . '" and "' . $login_end_date . '"');
        }
        echo $this->datatables->generate();
    }

    function profit_loss($start_date = NULL, $end_date = NULL)
    {
        $this->sma->checkPermissions('profit_loss');
        if (!$start_date) {
            $start = $this->db->escape(date('Y-m') . '-1');
            $start_date = date('Y-m') . '-1';
        } else {
            $start = $this->db->escape(urldecode($start_date));
        }
        if (!$end_date) {
            $end = $this->db->escape(date('Y-m-d H:i'));
            $end_date = date('Y-m-d H:i');
        } else {
            $end = $this->db->escape(urldecode($end_date));
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

        $this->data['total_purchases'] = $this->reports_model->getTotalPurchases($start, $end);
        $this->data['total_sales'] = $this->reports_model->getTotalSales($start, $end);
        $this->data['total_expenses'] = $this->reports_model->getTotalExpenses($start, $end);
        $this->data['total_paid'] = $this->reports_model->getTotalPaidAmount($start, $end);
        $this->data['total_received'] = $this->reports_model->getTotalReceivedAmount($start, $end);
        $this->data['total_received_cash'] = $this->reports_model->getTotalReceivedCashAmount($start, $end);
        $this->data['total_received_cc'] = $this->reports_model->getTotalReceivedCCAmount($start, $end);
        $this->data['total_received_cheque'] = $this->reports_model->getTotalReceivedChequeAmount($start, $end);
        $this->data['total_received_ppp'] = $this->reports_model->getTotalReceivedPPPAmount($start, $end);
        $this->data['total_received_stripe'] = $this->reports_model->getTotalReceivedStripeAmount($start, $end);
        $this->data['total_returned'] = $this->reports_model->getTotalReturnedAmount($start, $end);
        $this->data['start'] = urldecode($start_date);
        $this->data['end'] = urldecode($end_date);

        $warehouses = $this->site->getAllWarehouses();
        foreach ($warehouses as $warehouse) {
            $total_purchases = $this->reports_model->getTotalPurchases($start, $end, $warehouse->id);
            $total_sales = $this->reports_model->getTotalSales($start, $end, $warehouse->id);
            $total_expenses = $this->reports_model->getTotalExpenses($start, $end, $warehouse->id);
            $warehouses_report[] = array(
                'warehouse' => $warehouse,
                'total_purchases' => $total_purchases,
                'total_sales' => $total_sales,
                'total_expenses' => $total_expenses,
                );
        }
        $this->data['warehouses_report'] = $warehouses_report;

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('profit_loss')));
        $meta = array('page_title' => lang('profit_loss'), 'bc' => $bc);
        $this->page_construct('reports/profit_loss', $meta, $this->data);
    }

    function profit_loss_pdf($start_date = NULL, $end_date = NULL)
    {
        $this->sma->checkPermissions('profit_loss');
        if (!$start_date) {
            $start = $this->db->escape(date('Y-m') . '-1');
            $start_date = date('Y-m') . '-1';
        } else {
            $start = $this->db->escape(urldecode($start_date));
        }
        if (!$end_date) {
            $end = $this->db->escape(date('Y-m-d H:i'));
            $end_date = date('Y-m-d H:i');
        } else {
            $end = $this->db->escape(urldecode($end_date));
        }

        $this->data['total_purchases'] = $this->reports_model->getTotalPurchases($start, $end);
        $this->data['total_sales'] = $this->reports_model->getTotalSales($start, $end);
        $this->data['total_expenses'] = $this->reports_model->getTotalExpenses($start, $end);
        $this->data['total_paid'] = $this->reports_model->getTotalPaidAmount($start, $end);
        $this->data['total_received'] = $this->reports_model->getTotalReceivedAmount($start, $end);
        $this->data['total_received_cash'] = $this->reports_model->getTotalReceivedCashAmount($start, $end);
        $this->data['total_received_cc'] = $this->reports_model->getTotalReceivedCCAmount($start, $end);
        $this->data['total_received_cheque'] = $this->reports_model->getTotalReceivedChequeAmount($start, $end);
        $this->data['total_received_ppp'] = $this->reports_model->getTotalReceivedPPPAmount($start, $end);
        $this->data['total_received_stripe'] = $this->reports_model->getTotalReceivedStripeAmount($start, $end);
        $this->data['total_returned'] = $this->reports_model->getTotalReturnedAmount($start, $end);
        $this->data['start'] = urldecode($start_date);
        $this->data['end'] = urldecode($end_date);

        $warehouses = $this->site->getAllWarehouses();
        foreach ($warehouses as $warehouse) {
            $total_purchases = $this->reports_model->getTotalPurchases($start, $end, $warehouse->id);
            $total_sales = $this->reports_model->getTotalSales($start, $end, $warehouse->id);
            $warehouses_report[] = array(
                'warehouse' => $warehouse,
                'total_purchases' => $total_purchases,
                'total_sales' => $total_sales,
                );
        }
        $this->data['warehouses_report'] = $warehouses_report;

        $html = $this->load->view($this->theme . 'reports/profit_loss_pdf', $this->data, true);
        $name = lang("profit_loss") . "-" . str_replace(array('-', ' ', ':'), '_', $this->data['start']) . "-" . str_replace(array('-', ' ', ':'), '_', $this->data['end']) . ".pdf";
        $this->sma->generate_pdf($html, $name, false, false, false, false, false, 'L');
    }

    function register()
    {
        $this->sma->checkPermissions('register');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['users'] = $this->reports_model->getStaff();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('register_report')));
        $meta = array('page_title' => lang('register_report'), 'bc' => $bc);
        $this->page_construct('reports/register', $meta, $this->data);
    }

    function getRrgisterlogs($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('register', TRUE);
        if ($this->input->get('user')) {
            $user = $this->input->get('user');
        } else {
            $user = NULL;
        }
        if ($this->input->get('start_date')) {
            $start_date = $this->input->get('start_date');
        } else {
            $start_date = NULL;
        }
        if ($this->input->get('end_date')) {
            $end_date = $this->input->get('end_date');
        } else {
            $end_date = NULL;
        }
        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }

        if ($pdf || $xls) {

            $this->db
                ->select("date, closed_at, CONCAT(" . $this->db->dbprefix('users') . ".first_name, ' ', " . $this->db->dbprefix('users') . ".last_name, ' (', users.email, ')') as user, cash_in_hand, total_cc_slips, total_cheques, total_cash, total_cc_slips_submitted, total_cheques_submitted,total_cash_submitted, note", FALSE)
                ->from("pos_register")
                ->join('users', 'users.id=pos_register.user_id', 'left')
                ->order_by('date desc');
            //->where('status', 'close');

            if ($user) {
                $this->db->where('pos_register.user_id', $user);
            }
            if ($start_date) {
                $this->db->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('register_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('open_time'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('close_time'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('user'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('cash_in_hand'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('cc_slips'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('cheques'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('total_cash'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('cc_slips_submitted'));
                $this->excel->getActiveSheet()->SetCellValue('I1', lang('cheques_submitted'));
                $this->excel->getActiveSheet()->SetCellValue('J1', lang('total_cash_submitted'));
                $this->excel->getActiveSheet()->SetCellValue('K1', lang('note'));

                $row = 2;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->closed_at);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->user);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->cash_in_hand);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->total_cc_slips);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->total_cheques);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->total_cash);
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, $data_row->total_cc_slips_submitted);
                    $this->excel->getActiveSheet()->SetCellValue('I' . $row, $data_row->total_cheques_submitted);
                    $this->excel->getActiveSheet()->SetCellValue('J' . $row, $data_row->total_cash_submitted);
                    $this->excel->getActiveSheet()->SetCellValue('K' . $row, $data_row->note);
                    if($data_row->total_cash_submitted < $data_row->total_cash || $data_row->total_cheques_submitted < $data_row->total_cheques || $data_row->total_cc_slips_submitted < $data_row->total_cc_slips) {
                        $this->excel->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray(
                                array( 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F2DEDE')) )
                                );
                    }
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(35);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $filename = 'register_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');
            $this->datatables
                ->select("date, closed_at, CONCAT(" . $this->db->dbprefix('users') . ".first_name, ' ', " . $this->db->dbprefix('users') . ".last_name, '<br>', " . $this->db->dbprefix('users') . ".email) as user, cash_in_hand, CONCAT(total_cc_slips, ' (', total_cc_slips_submitted, ')'), CONCAT(total_cheques, ' (', total_cheques_submitted, ')'), CONCAT(total_cash, ' (', total_cash_submitted, ')'), note", FALSE)
                ->from("pos_register")
                ->join('users', 'users.id=pos_register.user_id', 'left');

            if ($user) {
                $this->datatables->where('pos_register.user_id', $user);
            }
            if ($start_date) {
                $this->datatables->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();

        }

    }

    public function expenses($id = null)
    {
        $this->sma->checkPermissions();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['categories'] = $this->reports_model->getExpenseCategories();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('expenses')));
        $meta = array('page_title' => lang('expenses'), 'bc' => $bc);
        $this->page_construct('reports/expenses', $meta, $this->data);
    }

    public function getExpensesReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('expenses');

        $reference_no = $this->input->get('reference_no') ? $this->input->get('reference_no') : NULL;
        $category = $this->input->get('category') ? $this->input->get('category') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $note = $this->input->get('note') ? $this->input->get('note') : NULL;
        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }

        if ($pdf || $xls) {

            $this->db
                ->select("date, reference, {$this->db->dbprefix('expense_categories')}.name as category, amount, note, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as user, attachment, {$this->db->dbprefix('expenses')}.id as id", false)
            ->from('expenses')
            ->join('users', 'users.id=expenses.created_by', 'left')
            ->join('expense_categories', 'expense_categories.id=expenses.category_id', 'left')
            ->group_by('expenses.id');

            if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
                $this->db->where('created_by', $this->session->userdata('user_id'));
            }

            if ($note) {
                $this->db->like('note', $note, 'both');
            }
            if ($reference_no) {
                $this->db->like('reference', $reference_no, 'both');
            }
            if ($category) {
                $this->db->where('category_id', $category);
            }
            if ($warehouse) {
                $this->db->where('expenses.warehouse_id', $warehouse);
            }
            if ($user) {
                $this->db->where('created_by', $user);
            }
            if ($start_date) {
                $this->db->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('expenses_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('category'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('amount'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('note'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('created_by'));

                $row = 2; $total = 0;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->category);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->amount);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->note);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->created_by);
                    $total += $data_row->amount;
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("D" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('D' . $row, $total);

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $filename = 'expenses_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');
            $this->datatables
            ->select("DATE_FORMAT(date, '%Y-%m-%d %T') as date, reference, {$this->db->dbprefix('expense_categories')}.name as category, amount, note, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as user, attachment, {$this->db->dbprefix('expenses')}.id as id", false)
            ->from('expenses')
            ->join('users', 'users.id=expenses.created_by', 'left')
            ->join('expense_categories', 'expense_categories.id=expenses.category_id', 'left')
            ->group_by('expenses.id');

            if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
                $this->datatables->where('created_by', $this->session->userdata('user_id'));
            }

            if ($note) {
                $this->datatables->like('note', $note, 'both');
            }
            if ($reference_no) {
                $this->datatables->like('reference', $reference_no, 'both');
            }
            if ($category) {
                $this->datatables->where('category_id', $category);
            }
            if ($warehouse) {
                $this->datatables->where('expenses.warehouse_id', $warehouse);
            }
            if ($user) {
                $this->datatables->where('created_by', $user);
            }
            if ($start_date) {
                $this->datatables->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();
        }
    }

    function daily_purchases($warehouse_id = NULL, $year = NULL, $month = NULL, $pdf = NULL, $user_id = NULL)
    {
        $this->sma->checkPermissions();
        if (!$this->Owner && !$this->Admin && $this->session->userdata('warehouse_id')) {
            $warehouse_id = $this->session->userdata('warehouse_id');
        }
        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }
        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $config = array(
            'show_next_prev' => TRUE,
            'next_prev_url' => admin_url('reports/daily_purchases/'.($warehouse_id ? $warehouse_id : 0)),
            'month_type' => 'long',
            'day_type' => 'long'
        );

        $config['template'] = '{table_open}<div class="table-responsive"><table border="0" cellpadding="0" cellspacing="0" class="table table-bordered dfTable">{/table_open}
        {heading_row_start}<tr>{/heading_row_start}
        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}" id="month_year">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
        {heading_row_end}</tr>{/heading_row_end}
        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td class="cl_wday">{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}
        {cal_row_start}<tr class="days">{/cal_row_start}
        {cal_cell_start}<td class="day">{/cal_cell_start}
        {cal_cell_content}
        <div class="day_num">{day}</div>
        <div class="content">{content}</div>
        {/cal_cell_content}
        {cal_cell_content_today}
        <div class="day_num highlight">{day}</div>
        <div class="content">{content}</div>
        {/cal_cell_content_today}
        {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
        {cal_cell_blank}&nbsp;{/cal_cell_blank}
        {cal_cell_end}</td>{/cal_cell_end}
        {cal_row_end}</tr>{/cal_row_end}
        {table_close}</table></div>{/table_close}';

        $this->load->library('calendar', $config);
        $purchases = $user_id ? $this->reports_model->getStaffDailyPurchases($user_id, $year, $month, $warehouse_id) : $this->reports_model->getDailyPurchases($year, $month, $warehouse_id);

        if (!empty($purchases)) {
            foreach ($purchases as $purchase) {
                $daily_purchase[$purchase->date] = "<table class='table table-bordered table-hover table-striped table-condensed data' style='margin:0;'><tr><td>" . lang("discount") . "</td><td>" . $this->sma->formatMoney($purchase->discount) . "</td></tr><tr><td>" . lang("shipping") . "</td><td>" . $this->sma->formatMoney($purchase->shipping) . "</td></tr><tr><td>" . lang("product_tax") . "</td><td>" . $this->sma->formatMoney($purchase->tax1) . "</td></tr><tr><td>" . lang("order_tax") . "</td><td>" . $this->sma->formatMoney($purchase->tax2) . "</td></tr><tr><td>" . lang("total") . "</td><td>" . $this->sma->formatMoney($purchase->total) . "</td></tr></table>";
            }
        } else {
            $daily_purchase = array();
        }

        $this->data['calender'] = $this->calendar->generate($year, $month, $daily_purchase);
        $this->data['year'] = $year;
        $this->data['month'] = $month;
        if ($pdf) {
            $html = $this->load->view($this->theme . 'reports/daily', $this->data, true);
            $name = lang("daily_purchases") . "_" . $year . "_" . $month . ".pdf";
            $html = str_replace('<p class="introtext">' . lang("reports_calendar_text") . '</p>', '', $html);
            $this->sma->generate_pdf($html, $name, null, null, null, null, null, 'L');
        }
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['warehouse_id'] = $warehouse_id;
        $this->data['sel_warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('daily_purchases_report')));
        $meta = array('page_title' => lang('daily_purchases_report'), 'bc' => $bc);
        $this->page_construct('reports/daily_purchases', $meta, $this->data);

    }


    function monthly_purchases($warehouse_id = NULL, $year = NULL, $pdf = NULL, $user_id = NULL)
    {
        $this->sma->checkPermissions();
        if (!$this->Owner && !$this->Admin && $this->session->userdata('warehouse_id')) {
            $warehouse_id = $this->session->userdata('warehouse_id');
        }
        if (!$year) {
            $year = date('Y');
        }
        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->load->language('calendar');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['year'] = $year;
        $this->data['purchases'] = $user_id ? $this->reports_model->getStaffMonthlyPurchases($user_id, $year, $warehouse_id) : $this->reports_model->getMonthlyPurchases($year, $warehouse_id);
        if ($pdf) {
            $html = $this->load->view($this->theme . 'reports/monthly', $this->data, true);
            $name = lang("monthly_purchases") . "_" . $year . ".pdf";
            $html = str_replace('<p class="introtext">' . lang("reports_calendar_text") . '</p>', '', $html);
            $this->sma->generate_pdf($html, $name, null, null, null, null, null, 'L');
        }
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['warehouse_id'] = $warehouse_id;
        $this->data['sel_warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('monthly_purchases_report')));
        $meta = array('page_title' => lang('monthly_purchases_report'), 'bc' => $bc);
        $this->page_construct('reports/monthly_purchases', $meta, $this->data);

    }

    function adjustments($warehouse_id = NULL)
    {
        $this->sma->checkPermissions('products');

        $this->data['users'] = $this->reports_model->getStaff();
        $this->data['warehouses'] = $this->site->getAllWarehouses();

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('adjustments_report')));
        $meta = array('page_title' => lang('adjustments_report'), 'bc' => $bc);
        $this->page_construct('reports/adjustments', $meta, $this->data);
    }

    function getAdjustmentReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('products', TRUE);

        $product = $this->input->get('product') ? $this->input->get('product') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $reference_no = $this->input->get('reference_no') ? $this->input->get('reference_no') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        $serial = $this->input->get('serial') ? $this->input->get('serial') : NULL;

        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }
        if (!$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $user = $this->session->userdata('user_id');
        }

        if ($pdf || $xls) {

            $ai = "( SELECT adjustment_id, product_id, serial_no, GROUP_CONCAT(CONCAT({$this->db->dbprefix('products')}.name, ' (', (CASE WHEN {$this->db->dbprefix('adjustment_items')}.type  = 'subtraction' THEN (0-{$this->db->dbprefix('adjustment_items')}.quantity) ELSE {$this->db->dbprefix('adjustment_items')}.quantity END), ')') SEPARATOR '\n') as item_nane from {$this->db->dbprefix('adjustment_items')} LEFT JOIN {$this->db->dbprefix('products')} ON {$this->db->dbprefix('products')}.id={$this->db->dbprefix('adjustment_items')}.product_id GROUP BY {$this->db->dbprefix('adjustment_items')}.adjustment_id ) FAI";

            $this->db->select("DATE_FORMAT(date, '%Y-%m-%d %T') as date, reference_no, warehouses.name as wh_name, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as created_by, note, FAI.item_nane as iname, {$this->db->dbprefix('adjustments')}.id as id", FALSE)
            ->from('adjustments')
            ->join($ai, 'FAI.adjustment_id=adjustments.id', 'left')
            ->join('users', 'users.id=adjustments.created_by', 'left')
            ->join('warehouses', 'warehouses.id=adjustments.warehouse_id', 'left');

            if ($user) {
                $this->db->where('adjustments.created_by', $user);
            }
            if ($product) {
                $this->db->where('FAI.product_id', $product);
            }
            if ($serial) {
                $this->db->like('FAI.serial_no', $serial);
            }
            if ($warehouse) {
                $this->db->where('adjustments.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->db->like('adjustments.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->db->where($this->db->dbprefix('adjustments').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('adjustments_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('warehouse'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('created_by'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('note'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('products'));

                $row = 2;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference_no);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->wh_name);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->created_by);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->sma->decode_html($data_row->note));
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->iname);
                    $row++;
                }

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E2:E' . $row)->getAlignment()->setWrapText(true);
                $this->excel->getActiveSheet()->getStyle('F2:F' . $row)->getAlignment()->setWrapText(true);
                $filename = 'adjustments_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $ai = "( SELECT adjustment_id, product_id, serial_no, GROUP_CONCAT(CONCAT({$this->db->dbprefix('products')}.name, '__', (CASE WHEN {$this->db->dbprefix('adjustment_items')}.type  = 'subtraction' THEN (0-{$this->db->dbprefix('adjustment_items')}.quantity) ELSE {$this->db->dbprefix('adjustment_items')}.quantity END)) SEPARATOR '___') as item_nane from {$this->db->dbprefix('adjustment_items')} LEFT JOIN {$this->db->dbprefix('products')} ON {$this->db->dbprefix('products')}.id={$this->db->dbprefix('adjustment_items')}.product_id ";
            if ($product || $serial) { $ai .= " WHERE "; }
            if ($product) {
                $ai .= " {$this->db->dbprefix('adjustment_items')}.product_id = {$product} ";
            }
            if ($product && $serial) { $ai .= " AND "; }
            if ($serial) {
                $ai .= " {$this->db->dbprefix('adjustment_items')}.serial_no LIKe '%{$serial}%' ";
            }
            $ai .= " GROUP BY {$this->db->dbprefix('adjustment_items')}.adjustment_id ) FAI";
            $this->load->library('datatables');
            $this->datatables
            ->select("DATE_FORMAT(date, '%Y-%m-%d %T') as date, reference_no, warehouses.name as wh_name, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as created_by, note, FAI.item_nane as iname, {$this->db->dbprefix('adjustments')}.id as id", FALSE)
            ->from('adjustments')
            ->join($ai, 'FAI.adjustment_id=adjustments.id', 'left')
            ->join('users', 'users.id=adjustments.created_by', 'left')
            ->join('warehouses', 'warehouses.id=adjustments.warehouse_id', 'left');

            if ($user) {
                $this->datatables->where('adjustments.created_by', $user);
            }
            if ($product) {
                $this->datatables->where('FAI.product_id', $product);
            }
            if ($serial) {
                $this->datatables->like('FAI.serial_no', $serial);
            }
            if ($warehouse) {
                $this->datatables->where('adjustments.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->datatables->like('adjustments.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->datatables->where($this->db->dbprefix('adjustments').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();
        }

    }

    function get_deposits($company_id = NULL)
    {
        $this->sma->checkPermissions('customers', TRUE);
        $this->load->library('datatables');
        $this->datatables
            ->select("date, amount, paid_by, CONCAT({$this->db->dbprefix('users')}.first_name, ' ', {$this->db->dbprefix('users')}.last_name) as created_by, note", FALSE)
            ->from("deposits")
            ->join('users', 'users.id=deposits.created_by', 'left')
            ->where($this->db->dbprefix('deposits').'.company_id', $company_id);
        echo $this->datatables->generate();
    }

    function tax()
    {
        $this->sma->checkPermissions();
        $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : NULL;
        $end_date = $this->input->post('end_date') ? $this->input->post('end_date') : NULL;
        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        $this->data['billers'] = $this->site->getAllCompanies('biller');
        $this->data['sale_tax'] = $this->reports_model->getSalesTax($start_date, $end_date);
        $this->data['purchase_tax'] = $this->reports_model->getPurchasesTax($start_date, $end_date);
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => lang('tax_report')));
        $meta = array('page_title' => lang('tax_report'), 'bc' => $bc);
        $this->page_construct('reports/tax', $meta, $this->data);
    }

    function get_sale_taxes($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('tax', TRUE);
        $biller = $this->input->get('biller') ? $this->input->get('biller') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }

        if ($pdf || $xls) {

            $this->db
                ->select("date, reference_no, CONCAT({$this->db->dbprefix('warehouses')}.name, ' (', {$this->db->dbprefix('warehouses')}.code, ')') as warehouse, biller, igst, cgst, sgst, product_tax, order_tax, grand_total, paid, payment_status")
                ->from('sales')
                ->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left')
                ->order_by('date desc');

            if ($biller) {
                $this->db->where('biller_id', $biller);
            }
            if ($warehouse) {
                $this->db->where('warehouse_id', $warehouse);
            }
            if ($start_date) {
                $this->db->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {
                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle(lang('sales_report'));
                $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                $this->excel->getActiveSheet()->SetCellValue('C1', lang('warehouse'));
                $this->excel->getActiveSheet()->SetCellValue('D1', lang('biller'));
                $this->excel->getActiveSheet()->SetCellValue('E1', lang('igst'));
                $this->excel->getActiveSheet()->SetCellValue('F1', lang('cgst'));
                $this->excel->getActiveSheet()->SetCellValue('G1', lang('sgst'));
                $this->excel->getActiveSheet()->SetCellValue('H1', lang('product_tax'));
                $this->excel->getActiveSheet()->SetCellValue('I1', lang('order_tax'));
                $this->excel->getActiveSheet()->SetCellValue('J1', lang('grand_total'));

                $row = 2;
                $total = $order_tax = $product_tax = $igst = $cgst = $sgst = 0;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference_no);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->warehouse);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->biller);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->sma->formatDecimal($data_row->igst));
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->sma->formatDecimal($data_row->cgst));
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $this->sma->formatDecimal($data_row->sgst));
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, $this->sma->formatDecimal($data_row->product_tax));
                    $this->excel->getActiveSheet()->SetCellValue('I' . $row, $this->sma->formatDecimal($data_row->order_tax));
                    $this->excel->getActiveSheet()->SetCellValue('J' . $row, $this->sma->formatDecimal($data_row->grand_total));
                    $igst += $data_row->igst;
                    $cgst += $data_row->cgst;
                    $sgst += $data_row->sgst;
                    $product_tax += $data_row->product_tax;
                    $order_tax += $data_row->order_tax;
                    $total += $data_row->grand_total;
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("E" . $row . ":J" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->sma->formatDecimal($igst));
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->sma->formatDecimal($cgst));
                $this->excel->getActiveSheet()->SetCellValue('G' . $row, $this->sma->formatDecimal($sgst));
                $this->excel->getActiveSheet()->SetCellValue('H' . $row, $this->sma->formatDecimal($product_tax));
                $this->excel->getActiveSheet()->SetCellValue('I' . $row, $this->sma->formatDecimal($order_tax));
                $this->excel->getActiveSheet()->SetCellValue('J' . $row, $this->sma->formatDecimal($total));

                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('E2:E' . $row)->getAlignment()->setWrapText(true);
                $filename = 'sale_tax_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);
            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->load->library('datatables');
            $this->datatables
                ->select("DATE_FORMAT(date, '%Y-%m-%d %T') as date, reference_no, sale_status, CONCAT({$this->db->dbprefix('warehouses')}.name, ' (', {$this->db->dbprefix('warehouses')}.code, ')') as warehouse, biller, ".($this->Settings->indian_gst ? "igst, cgst, sgst," : "")." product_tax, order_tax, grand_total, {$this->db->dbprefix('sales')}.id as id", FALSE)
                ->from('sales')
                ->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left');
            if ($biller) {
                $this->datatables->where('biller_id', $biller);
            }
            if ($warehouse) {
                $this->datatables->where('warehouse_id', $warehouse);
            }
            if ($start_date) {
                $this->datatables->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();
        }
    }

    function get_purchase_taxes($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('tax', TRUE);
        $supplier = $this->input->get('supplier') ? $this->input->get('supplier') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        if ($start_date) {
            $start_date = $this->sma->fld($start_date);
            $end_date = $this->sma->fld($end_date);
        }

        if ($pdf || $xls) {

            $this->db
                ->select("date, reference_no, CONCAT({$this->db->dbprefix('warehouses')}.name, ' (', {$this->db->dbprefix('warehouses')}.code, ')') as warehouse, supplier, igst, cgst, sgst, product_tax, order_tax, grand_total, paid")
                ->from('purchases')
                ->join('warehouses', 'warehouses.id=purchases.warehouse_id', 'left')
                ->order_by('purchases.date desc');

            if ($supplier) {
                $this->db->where('supplier_id', $supplier);
            }
            if ($warehouse) {
                $this->db->where('warehouse_id', $warehouse);
            }
            if ($start_date) {
                $this->db->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {
                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('sales_report'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('warehouse'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('supplier'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('igst'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('cgst'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('sgst'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('product_tax'));
                    $this->excel->getActiveSheet()->SetCellValue('I1', lang('order_tax'));
                    $this->excel->getActiveSheet()->SetCellValue('J1', lang('grand_total'));

                    $row = 2;
                    $total = $order_tax = $product_tax = $igst = $cgst = $sgst = 0;
                    foreach ($data as $data_row) {
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($data_row->date));
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->reference_no);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->warehouse);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->supplier);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->sma->formatDecimal($data_row->igst));
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->sma->formatDecimal($data_row->cgst));
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $this->sma->formatDecimal($data_row->sgst));
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $this->sma->formatDecimal($data_row->product_tax));
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $this->sma->formatDecimal($data_row->order_tax));
                        $this->excel->getActiveSheet()->SetCellValue('J' . $row, $this->sma->formatDecimal($data_row->grand_total));
                        $igst += $data_row->igst;
                        $cgst += $data_row->cgst;
                        $sgst += $data_row->sgst;
                        $product_tax += $data_row->product_tax;
                        $order_tax += $data_row->order_tax;
                        $total += $data_row->grand_total;
                        $row++;
                    }
                    $this->excel->getActiveSheet()->getStyle("E" . $row . ":J" . $row)->getBorders()
                        ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->sma->formatDecimal($igst));
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->sma->formatDecimal($cgst));
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $this->sma->formatDecimal($sgst));
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, $this->sma->formatDecimal($product_tax));
                    $this->excel->getActiveSheet()->SetCellValue('I' . $row, $this->sma->formatDecimal($order_tax));
                    $this->excel->getActiveSheet()->SetCellValue('J' . $row, $this->sma->formatDecimal($total));

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                    $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('E2:E' . $row)->getAlignment()->setWrapText(true);
                    $filename = 'purchase_tax_report';
                    $this->load->helper('excel');
                    create_excel($this->excel, $filename);
                }
                $this->session->set_flashdata('error', lang('nothing_found'));
                redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $this->load->library('datatables');
            $this->datatables
                ->select("DATE_FORMAT(date, '%Y-%m-%d %T') as date, reference_no, status, CONCAT({$this->db->dbprefix('warehouses')}.name, ' (', {$this->db->dbprefix('warehouses')}.code, ')') as warehouse, supplier, ".($this->Settings->indian_gst ? "igst, cgst, sgst," : "")." product_tax, order_tax, grand_total, {$this->db->dbprefix('purchases')}.id as id", FALSE)
                ->from('purchases')
                ->join('warehouses', 'warehouses.id=purchases.warehouse_id', 'left');
            if ($supplier) {
                $this->datatables->where('supplier_id', $supplier);
            }
            if ($warehouse) {
                $this->datatables->where('warehouse_id', $warehouse);
            }
            if ($start_date) {
                $this->datatables->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }

            echo $this->datatables->generate();
        }
    }



    function damages()
    {
        $this->sma->checkPermissions('products');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['categories'] = $this->site->getAllCategories();
        $this->data['brands'] = $this->site->getAllBrands();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        if ($this->input->post('start_date')) {
            $dt = "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
        } else {
            $dt = "Till " . $this->input->post('end_date');
        }
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => 'Damage Report'));
        $meta = array('page_title' => 'Damage Report', 'bc' => $bc);
        $this->page_construct('reports/damage_report', $meta, $this->data);
    }

    function getDamagesReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('products', TRUE);

        $product = $this->input->get('product') ? $this->input->get('product') : NULL;
        $category = $this->input->get('category') ? $this->input->get('category') : NULL;
        $brand = $this->input->get('brand') ? $this->input->get('brand') : NULL;
        $subcategory = $this->input->get('subcategory') ? $this->input->get('subcategory') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $origin = $this->input->get('origin') ? $this->input->get('origin') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        
        if ($pdf || $xls) {


             $this->db
                ->select("sma_products.code, DATE_FORMAT(sma_adjustments.date, '%Y-%m-%d') as date, sma_products.name, sma_brands.name as brand, sma_products.origin, sma_products.product_details, sma_adjustment_items.quantity as damage_unit, sma_products.id", FALSE)
                ->from('sma_products')
                ->join('sma_brands', 'sma_products.brand = sma_brands.id ', 'left')
                ->join('sma_adjustment_items', 'sma_products.id = sma_adjustment_items.product_id ', 'left')
                ->join('sma_adjustments', 'sma_adjustment_items.adjustment_id = sma_adjustments.id ', 'left')
                ->where('sma_adjustment_items.type', 'subtraction');

                // ->select("sma_products.code, sma_products.name, sma_brands.name as brand, sma_products.origin, sma_products.product_details, sma_products.damage_unit, sma_products.id", FALSE)
                // ->from('sma_products')
                // ->join('sma_brands', 'sma_products.brand = sma_brands.id ', 'left')
                // ->where('sma_products.damage_unit >', '0')
                // ->group_by('sma_products.code');

              
            if ($product) {
                $this->db->where("sma_products.id", $product);
            }
            if ($origin) {
                $this->db->where('sma_products.origin', $origin);
            }
            if ($category) {
                $this->db->where("sma_products.category_id", $category);
            }
            if ($subcategory) {
                $this->db->where("sma_products.subcategory_id", $subcategory);
            }
            if ($brand) {
                $this->db->where("sma_brands.id", $brand);
            }

            if ($start_date) {
                $this->db->where("DATE_FORMAT(sma_adjustments.date, '%d/%m/%Y') >=", $start_date);
            }

            if ($end_date) {
                $this->db->where("DATE_FORMAT(sma_adjustments.date, '%d/%m/%Y') <=", $end_date);
            }

            if ($warehouse) {
                $this->db->where("sma_products.warehouse", $warehouse);
            }



            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle('Damages Report');
                $this->excel->getActiveSheet()->SetCellValue('A3', lang('product_code'));
                $this->excel->getActiveSheet()->SetCellValue('B3', 'Date');
                $this->excel->getActiveSheet()->SetCellValue('C3', lang('product_name'));
                $this->excel->getActiveSheet()->SetCellValue('D3', lang('brand'));
                $this->excel->getActiveSheet()->SetCellValue('E3', 'Origin');
                $this->excel->getActiveSheet()->SetCellValue('F3', 'Product Report');
                $this->excel->getActiveSheet()->SetCellValue('G3', 'Damage Unit');

                  // set boarder

                $this->excel->getActiveSheet()->getStyle("A3:G3")->getBorders()
                ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                $row = 4;
                $dUnit = 0;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->code);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->date);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->brand);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->origin);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, strip_tags($data_row->product_details));
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->damage_unit);

                    // set boarder

                    $this->excel->getActiveSheet()->getStyle("A" . $row . ":G" . $row)->getBorders()
                    ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                    
                    $dUnit += $data_row->damage_unit;
                    
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("G" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                
                $this->excel->getActiveSheet()->SetCellValue('G' . $row, $dUnit);
                
                
                //set boarder
                $this->excel->getActiveSheet()->getStyle("A" . $row . ":G" . $row)->getBorders()
                    ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);


                //header text and style
                $this->excel->getActiveSheet()->SetCellValue('A1', "NOOR TRADE HOUSE");
                $this->excel->getActiveSheet()->SetCellValue('A2', "DAMAGE REPORT :".date("n-j-y"));

                $this->excel->getActiveSheet()->mergeCells('A1:O1');
                $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(-1);
                $this->excel->getActiveSheet()->mergeCells('A2:O2');
                $this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(-1);

                $styleArray = array(
                    'font' => array(
                        'bold' => true,
                        'size' => 14,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'borders' => array(
                        'top' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                    ),
                );

                $this->excel->getActiveSheet()->getStyle('A1:O2')->applyFromArray($styleArray);
                //header text and style

                //footer text and style
                $row++;
                $this->excel->getActiveSheet()->mergeCells('A'.$row.':O'.$row);
                $this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(60);
                $row++;
                $this->excel->getActiveSheet()->SetCellValue('A'.$row, "                              Accounts Exe:                              Store Manager                                          Accounts Manager                                              COO                                        CEO  ");
                $this->excel->getActiveSheet()->getStyle('A'.$row.':O'.($row+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $this->excel->getActiveSheet()->mergeCells('A'.$row.':O'.($row+1));
                $this->excel->getActiveSheet()->getStyle('A'.$row.':O'.$row)->applyFromArray($styleArray);
               

                //footer text and style

                //page setup
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

                //page setup







                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C2:G' . $row)->getAlignment()->setWrapText(true);
                $filename = 'damages_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');

            $this->datatables
                ->select("sma_products.code, DATE_FORMAT(sma_adjustments.date, '%Y-%m-%d') as date, sma_products.name, sma_brands.name as brand, sma_products.origin, sma_products.product_details, sma_adjustment_items.quantity, sma_products.id", FALSE)
                ->from('sma_products')
                ->join('sma_brands', 'sma_products.brand = sma_brands.id ', 'left')
                ->join('sma_adjustment_items', 'sma_products.id = sma_adjustment_items.product_id ', 'left')
                ->join('sma_adjustments', 'sma_adjustment_items.adjustment_id = sma_adjustments.id ', 'left')
                ->where('sma_adjustment_items.type', 'subtraction');
              
            if ($product) {
                $this->datatables->where("sma_products.id", $product);
            }
            if ($origin) {
                $this->datatables->where('sma_products.origin', $origin);
            }
            if ($category) {
                $this->datatables->where("sma_products.category_id", $category);
            }
            if ($subcategory) {
                $this->datatables->where("sma_products.subcategory_id", $subcategory);
            }
            if ($brand) {
                $this->datatables->where("sma_brands.id", $brand);
            }

            if ($start_date) {
                $this->datatables->where("DATE_FORMAT(sma_adjustments.date, '%d/%m/%Y') >=", $start_date);
            }

            if ($end_date) {
                $this->datatables->where("DATE_FORMAT(sma_adjustments.date, '%d/%m/%Y') <=", $end_date);
            }

            if ($warehouse) {
                $this->datatables->where("sma_products.warehouse", $warehouse);
            }

            echo $this->datatables->generate();

        }

    }


    function returns()
    {
        $this->sma->checkPermissions('products');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['categories'] = $this->site->getAllCategories();
        $this->data['brands'] = $this->site->getAllBrands();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        if ($this->input->post('start_date')) {
            $dt = "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
        } else {
            $dt = "Till " . $this->input->post('end_date');
        }
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => 'Return Report'));
        $meta = array('page_title' => 'Return Report', 'bc' => $bc);
        $this->page_construct('reports/return_report', $meta, $this->data);
    }


    function getReturnsReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('products', TRUE);

        $product = $this->input->get('product') ? $this->input->get('product') : NULL;
        $category = $this->input->get('category') ? $this->input->get('category') : NULL;
        $brand = $this->input->get('brand') ? $this->input->get('brand') : NULL;
        $subcategory = $this->input->get('subcategory') ? $this->input->get('subcategory') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $origin = $this->input->get('origin') ? $this->input->get('origin') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        
        if ($pdf || $xls) {


             $this->db
                 ->select("sma_sale_items.product_code as code, DATE_FORMAT(sma_sales.date, '%Y-%m-%d') as date, sma_sale_items.product_name as name, sma_brands.name as brand, sma_products.origin, sma_products.product_details, sma_sales.customer, ABS(sma_sale_items.quantity) as unit, sma_sale_items.id", FALSE)
                ->from('sma_sale_items')
                ->join('sma_sales', 'sma_sale_items.sale_id = sma_sales.id', 'left')
                ->join('sma_products', 'sma_sale_items.product_id = sma_products.id', 'left')
                ->join('sma_brands', 'sma_products.brand = sma_brands.id', 'left')
                // ->group_by('sma_sale_items.product_code')
                ->where("sma_sales.sale_status", "returned");
              
            if ($product) {
                $this->db->where("sma_sale_items.product_id", $product);
            }
            if ($origin) {
                $this->db->where('sma_products.origin', $origin);
            }
            if ($category) {
                $this->db->where("sma_products.category_id", $category);
            }
            if ($subcategory) {
                $this->db->where("sma_products.subcategory_id", $subcategory);
            }
            if ($brand) {
                $this->db->where("sma_brands.id", $brand);
            }

            if ($start_date) {
                $this->db->where("DATE_FORMAT(sma_sales.date, '%d/%m/%Y') >=", $start_date);
            }

            if ($end_date) {
                $this->db->where("DATE_FORMAT(sma_sales.date, '%d/%m/%Y') <=", $end_date);
            }

            if ($warehouse) {
                $this->db->where("sma_products.warehouse", $warehouse);
            }



            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle('Return Report');
                $this->excel->getActiveSheet()->SetCellValue('A3', lang('product_code'));
                $this->excel->getActiveSheet()->SetCellValue('B3', 'Date');
                $this->excel->getActiveSheet()->SetCellValue('C3', lang('product_name'));
                $this->excel->getActiveSheet()->SetCellValue('D3', lang('brand'));
                $this->excel->getActiveSheet()->SetCellValue('E3', 'Origin');
                $this->excel->getActiveSheet()->SetCellValue('F3', 'Poduct Details');
                $this->excel->getActiveSheet()->SetCellValue('G3', 'Customer');
                $this->excel->getActiveSheet()->SetCellValue('H3', 'Return Unit');

                  // set boarder

                $this->excel->getActiveSheet()->getStyle("A3:H3")->getBorders()
                ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                $row = 4;
                $dUnit = 0;
                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->code);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->date);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->brand);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, $data_row->origin);
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, strip_tags($data_row->product_details));
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->customer);
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, $data_row->unit);

                    // set boarder

                    $this->excel->getActiveSheet()->getStyle("A" . $row . ":H" . $row)->getBorders()
                    ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    
                    $dUnit += $data_row->unit;
                    
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("H" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                $this->excel->getActiveSheet()->SetCellValue('H' . $row, $dUnit);

                //set boarder
                $this->excel->getActiveSheet()->getStyle("A" . $row . ":H" . $row)->getBorders()
                    ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);


                //header text and style
                $this->excel->getActiveSheet()->SetCellValue('A1', "NOOR TRADE HOUSE");
                $this->excel->getActiveSheet()->SetCellValue('A2', "RETURN REPORT :".date("n-j-y"));

                $this->excel->getActiveSheet()->mergeCells('A1:O1');
                $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(-1);
                $this->excel->getActiveSheet()->mergeCells('A2:O2');
                $this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(-1);

                $styleArray = array(
                    'font' => array(
                        'bold' => true,
                        'size' => 14,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'borders' => array(
                        'top' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                    ),
                );

                $this->excel->getActiveSheet()->getStyle('A1:O2')->applyFromArray($styleArray);
                //header text and style

                //footer text and style
                $row++;
                $this->excel->getActiveSheet()->mergeCells('A'.$row.':O'.$row);
                $this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(60);
                $row++;
                $this->excel->getActiveSheet()->SetCellValue('A'.$row, "                              Accounts Exe:                              Store Manager                                          Accounts Manager                                              COO                                        CEO  ");
                $this->excel->getActiveSheet()->getStyle('A'.$row.':O'.($row+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $this->excel->getActiveSheet()->mergeCells('A'.$row.':O'.($row+1));
                $this->excel->getActiveSheet()->getStyle('A'.$row.':O'.$row)->applyFromArray($styleArray);
               

                //footer text and style

                //page setup
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

                //page setup






                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C2:H' . $row)->getAlignment()->setWrapText(true);
                $filename = 'return_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');

            $this->datatables
                ->select("sma_sale_items.product_code as code, DATE_FORMAT(sma_sales.date, '%Y-%m-%d') as date, sma_sale_items.product_name as name, sma_brands.name as brand, sma_products.origin, sma_products.product_details, sma_sales.customer, ABS(sma_sale_items.quantity) as unit, sma_sale_items.id, sma_products.id as prod", FALSE)
                ->from('sma_sale_items')
                ->join('sma_sales', 'sma_sale_items.sale_id = sma_sales.id', 'left')
                ->join('sma_products', 'sma_sale_items.product_id = sma_products.id', 'left')
                ->join('sma_brands', 'sma_products.brand = sma_brands.id', 'left')
                // ->group_by('sma_sale_items.product_code')
                ->where("sma_sales.sale_status", "returned");


            if ($product) {
                $this->datatables->where("sma_sale_items.product_id", $product);
            }
            if ($origin) {
                $this->datatables->where('sma_products.origin', $origin);
            }
            if ($category) {
                $this->datatables->where("sma_products.category_id", $category);
            }
            if ($subcategory) {
                $this->datatables->where("sma_products.subcategory_id", $subcategory);
            }
            if ($brand) {
                $this->datatables->where("sma_brands.id", $brand);
            }

            if ($start_date) {
                $this->datatables->where("DATE_FORMAT(sma_sales.date, '%d/%m/%Y') >=", $start_date);
            }

            if ($end_date) {
                $this->datatables->where("DATE_FORMAT(sma_sales.date, '%d/%m/%Y') <=", $end_date);
            }

            if ($warehouse) {
                $this->datatables->where("sma_products.warehouse", $warehouse);
            }

            echo $this->datatables->generate();

        }

    }





    function stocks()
    {
        $this->sma->checkPermissions('products');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['categories'] = $this->site->getAllCategories();
        $this->data['brands'] = $this->site->getAllBrands();
        $this->data['warehouses'] = $this->site->getAllWarehouses();
        if ($this->input->post('start_date')) {
            $dt = "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
        } else {
            $dt = "Till " . $this->input->post('end_date');
        }
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => admin_url('reports'), 'page' => lang('reports')), array('link' => '#', 'page' => 'Stock Report'));
        $meta = array('page_title' => 'Stock Report', 'bc' => $bc);
        $this->page_construct('reports/stock_report', $meta, $this->data);
    }


        function getStocksReport($pdf = NULL, $xls = NULL)
    {
        $this->sma->checkPermissions('products', TRUE);

        $product = $this->input->get('product') ? $this->input->get('product') : NULL;
        $category = $this->input->get('category') ? $this->input->get('category') : NULL;
        $brand = $this->input->get('brand') ? $this->input->get('brand') : NULL;
        $subcategory = $this->input->get('subcategory') ? $this->input->get('subcategory') : NULL;
        $warehouse = $this->input->get('warehouse') ? $this->input->get('warehouse') : NULL;
        $origin = $this->input->get('origin') ? $this->input->get('origin') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        
        if ($pdf || $xls) {

           $sp = "(SELECT sma_sale_items.product_id as product_id, COALESCE(SUM(sma_sale_items.quantity),0) soldQty FROM sma_sale_items LEFT JOIN sma_sales ON sma_sales.id = sma_sale_items.sale_id WHERE sma_sales.sale_status ='completed' GROUP BY product_code) sold";

            
            $pp = "(SELECT sma_sale_items.product_id as product_id, COALESCE(SUM(ABS(sma_sale_items.quantity)),0) retQty FROM sma_sale_items LEFT JOIN sma_sales ON sma_sales.id = sma_sale_items.sale_id WHERE sma_sales.sale_status ='returned' GROUP BY product_code) ret";

            $tp = "(SELECT code, manufacturing, a, expire, receive_date, SUM(receiving_quantity) AS receiving_quantity, SUM(opening_stock) AS opening_stock FROM (SELECT code, manufacturing, ABS(DATEDIFF(expire, CURDATE())) as a, expire, receive_date, receiving_quantity, opening_stock FROM ((SELECT code, manufacturing, expire, receive_date, receiving_quantity, opening_stock FROM sma_products) UNION ALL (SELECT product_code, manufacturing, expire, receive_date, receiving_quantity, opening_stock FROM sma_existing_products)) b ORDER BY CASE WHEN expire >= CURDATE() THEN 0 ELSE 1 END, a LIMIT 1000) as c GROUP BY code) p";

            $dp = "(SELECT sum(quantity) AS quantity, product_id from sma_adjustment_items WHERE type = 'subtraction' GROUP BY product_id) damage";

             $this->db
                ->select("sma_products.code, sma_products.name, sma_brands.name as brand, sma_products.origin, sma_products.product_details, sma_units.name as unit, sma_products.opening_stock as opening_stock, p.receiving_quantity as receiving_quantity, sold.soldQty, ret.retQty, damage.quantity as damage_unit, IF(COALESCE(sum(sma_products.closing_stock),0) = '0', COALESCE(sma_products.opening_stock,0)+COALESCE(p.receiving_quantity,0)+COALESCE(ret.retQty,0)-COALESCE(sold.soldQty,0)-COALESCE(damage.quantity,0), sum(sma_products.closing_stock)) as closing_stock, sma_products.id", FALSE)
                ->from('sma_products')
                ->join($tp, 'sma_products.code = p.code', 'left')
                ->join($sp, 'sma_products.id = sold.product_id', 'left')
                ->join($pp, 'sma_products.id = ret.product_id', 'left')
                ->join($dp, 'sma_products.id = damage.product_id', 'left')
                ->join('sma_brands', 'sma_products.brand = sma_brands.id', 'left')
                ->join('sma_units', 'sma_products.unit = sma_units.id', 'left')
                ->group_by('sma_products.code');
              
            if ($product) {
                $this->db->where("sma_products.id", $product);
            }
            if ($origin) {
                $this->db->where('sma_products.origin', $origin);
            }
            if ($category) {
                $this->db->where("sma_products.category_id", $category);
            }
            if ($subcategory) {
                $this->db->where("sma_products.subcategory_id", $subcategory);
            }
            if ($brand) {
                $this->db->where("sma_products.brand", $brand);
            }

            if ($start_date) {
                $this->db->where("sma_products.start_date >=", $start_date);
            }

            if ($end_date) {
                $this->db->where("sma_products.end_date <=", $end_date);
            }

            if ($warehouse) {
                $this->db->where("sma_products.warehouse", $warehouse);
            }



            $q = $this->db->get();
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
            } else {
                $data = NULL;
            }

            if (!empty($data)) {

                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle('Return Report');
                $this->excel->getActiveSheet()->SetCellValue('A3', lang('product_code'));
                $this->excel->getActiveSheet()->SetCellValue('B3', lang('product_name'));
                $this->excel->getActiveSheet()->SetCellValue('C3', lang('brand'));
                $this->excel->getActiveSheet()->SetCellValue('D3', 'Origin');
                $this->excel->getActiveSheet()->SetCellValue('E3', 'Product Details');
                $this->excel->getActiveSheet()->SetCellValue('F3', 'Unit');
                $this->excel->getActiveSheet()->SetCellValue('G3', 'Opening Stock');
                $this->excel->getActiveSheet()->SetCellValue('H3', 'Receiving Quantity');
                $this->excel->getActiveSheet()->SetCellValue('I3', 'Sale');
                $this->excel->getActiveSheet()->SetCellValue('J3', 'Return');
                $this->excel->getActiveSheet()->SetCellValue('K3', 'Damage');
                $this->excel->getActiveSheet()->SetCellValue('L3', 'Closing Stock');
                
                // set boarder

                $this->excel->getActiveSheet()->getStyle("A3:L3")->getBorders()
                ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                $row = 4;
                $recQty = 0;
                $openStk = 0;
                $sold = 0;
                $ret = 0;
                $dmgUnit = 0;
                $clsStk = 0;


                foreach ($data as $data_row) {
                    $this->excel->getActiveSheet()->SetCellValue('A' . $row, $data_row->code);
                    $this->excel->getActiveSheet()->SetCellValue('B' . $row, $data_row->name);
                    $this->excel->getActiveSheet()->SetCellValue('C' . $row, $data_row->brand);
                    $this->excel->getActiveSheet()->SetCellValue('D' . $row, $data_row->origin);
                    $this->excel->getActiveSheet()->SetCellValue('E' . $row, strip_tags($data_row->product_details));
                    $this->excel->getActiveSheet()->SetCellValue('F' . $row, $data_row->unit);
                    $this->excel->getActiveSheet()->SetCellValue('G' . $row, $data_row->opening_stock);
                    $this->excel->getActiveSheet()->SetCellValue('H' . $row, $data_row->receiving_quantity);
                    $this->excel->getActiveSheet()->SetCellValue('I' . $row, $data_row->soldQty);
                    $this->excel->getActiveSheet()->SetCellValue('J' . $row, $data_row->retQty);
                    $this->excel->getActiveSheet()->SetCellValue('K' . $row, $data_row->damage_unit);
                    $this->excel->getActiveSheet()->SetCellValue('L' . $row, $data_row->closing_stock);

                    // set boarder

                    $this->excel->getActiveSheet()->getStyle("A" . $row . ":L" . $row)->getBorders()
                    ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                    
                    
                    $recQty += $data_row->receiving_quantity;
                    $openStk += $data_row->opening_stock;
                    $sold += $data_row->soldQty;
                    $ret += $data_row->retQty;
                    $dmgUnit += $data_row->damage_unit;
                    $clsStk += $data_row->closing_stock;
                        
                    $row++;
                }
                $this->excel->getActiveSheet()->getStyle("F" . $row . ":O" . $row)->getBorders()
                    ->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
                
                $this->excel->getActiveSheet()->SetCellValue('G' . $row, $openStk);
                $this->excel->getActiveSheet()->SetCellValue('H' . $row, $recQty);
                $this->excel->getActiveSheet()->SetCellValue('I' . $row, $sold);
                $this->excel->getActiveSheet()->SetCellValue('J' . $row, $ret);
                $this->excel->getActiveSheet()->SetCellValue('K' . $row, $dmgUnit);
                $this->excel->getActiveSheet()->SetCellValue('L' . $row, $clsStk);

                //set boarder
                $this->excel->getActiveSheet()->getStyle("A" . $row . ":L" . $row)->getBorders()
                    ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                
                
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);


                //header text and style
                $this->excel->getActiveSheet()->SetCellValue('A1', "NOOR TRADE HOUSE");
                $this->excel->getActiveSheet()->SetCellValue('A2', "STOCK REPORT :".date("n-j-y"));

                $this->excel->getActiveSheet()->mergeCells('A1:L1');
                $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(-1);
                $this->excel->getActiveSheet()->mergeCells('A2:L2');
                $this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(-1);

                $styleArray = array(
                    'font' => array(
                        'bold' => true,
                        'size' => 14,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    ),
                    'borders' => array(
                        'top' => array(
                                'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                    ),
                );

                $this->excel->getActiveSheet()->getStyle('A1:L2')->applyFromArray($styleArray);
                //header text and style

                //footer text and style
                $row++;
                $this->excel->getActiveSheet()->mergeCells('A'.$row.':L'.$row);
                $this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(60);
                $row++;
                $this->excel->getActiveSheet()->SetCellValue('A'.$row, "                              Accounts Exe:                              Store Manager                                          Accounts Manager                                              COO                                        CEO  ");
                $this->excel->getActiveSheet()->getStyle('A'.$row.':L'.($row+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $this->excel->getActiveSheet()->mergeCells('A'.$row.':L'.($row+1));
                $this->excel->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray($styleArray);
               

                //footer text and style

                //page setup
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
                $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

                //page setup

                

                
                $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C4:G' . $row)->getAlignment()->setWrapText(true);
                $filename = 'stock_report';
                $this->load->helper('excel');
                create_excel($this->excel, $filename);

            }
            $this->session->set_flashdata('error', lang('nothing_found'));
            redirect($_SERVER["HTTP_REFERER"]);

        } else {

            $this->load->library('datatables');


            $sp = "(SELECT sma_sale_items.product_id as product_id, COALESCE(SUM(sma_sale_items.quantity),0) soldQty FROM sma_sale_items LEFT JOIN sma_sales ON sma_sales.id = sma_sale_items.sale_id WHERE sma_sales.sale_status ='completed' GROUP BY product_code) sold";

            
            $pp = "(SELECT sma_sale_items.product_id as product_id, COALESCE(SUM(ABS(sma_sale_items.quantity)),0) retQty FROM sma_sale_items LEFT JOIN sma_sales ON sma_sales.id = sma_sale_items.sale_id WHERE sma_sales.sale_status ='returned' GROUP BY product_code) ret";

            $tp = "(SELECT code, manufacturing, a, expire, receive_date, SUM(receiving_quantity) AS receiving_quantity, SUM(opening_stock) AS opening_stock FROM (SELECT code, manufacturing, ABS(DATEDIFF(expire, CURDATE())) as a, expire, receive_date, receiving_quantity, opening_stock FROM ((SELECT code, manufacturing, expire, receive_date, receiving_quantity, opening_stock FROM sma_products) UNION ALL (SELECT product_code, manufacturing, expire, receive_date, receiving_quantity, opening_stock FROM sma_existing_products)) b ORDER BY CASE WHEN expire >= CURDATE() THEN 0 ELSE 1 END, a LIMIT 1000) as c GROUP BY code) p";

            $dp = "(SELECT sum(quantity) AS quantity, product_id from sma_adjustment_items WHERE type = 'subtraction' GROUP BY product_id) damage";

            $this->datatables
                ->select("sma_products.code, sma_products.name, sma_brands.name as brand, sma_products.origin, sma_products.product_details, sma_units.name as unit, sma_products.opening_stock as opening_stock, p.receiving_quantity as receiving_quantity, sold.soldQty, ret.retQty, damage.quantity as damage_unit, IF(COALESCE(sum(sma_products.closing_stock),0) = '0', COALESCE(sma_products.opening_stock,0)+COALESCE(p.receiving_quantity,0)+COALESCE(ret.retQty,0)-COALESCE(sold.soldQty,0)-COALESCE(damage.quantity,0), sum(sma_products.closing_stock)) as closing_stock, sma_products.id", FALSE)
                ->from('sma_products')
                ->join($tp, 'sma_products.code = p.code', 'left')
                ->join($sp, 'sma_products.id = sold.product_id', 'left')
                ->join($pp, 'sma_products.id = ret.product_id', 'left')
                ->join($dp, 'sma_products.id = damage.product_id', 'left')
                ->join('sma_brands', 'sma_products.brand = sma_brands.id', 'left')
                ->join('sma_units', 'sma_products.unit = sma_units.id', 'left')
                ->group_by('sma_products.code');
               


            if ($product) {
                $this->datatables->where("sma_products.id", $product);
            }
            if ($origin) {
                $this->datatables->where('sma_products.origin', $origin);
            }
            if ($category) {
                $this->datatables->where("sma_products.category_id", $category);
            }
            if ($subcategory) {
                $this->datatables->where("sma_products.subcategory_id", $subcategory);
            }
            if ($brand) {
                $this->datatables->where("sma_products.brand", $brand);
            }

            if ($start_date) {
                $this->datatables->where("DATE_FORMAT(sma_products.start_date, '%d/%m/%Y') >=", $start_date);
            }

            if ($end_date) {
                $this->datatables->where("DATE_FORMAT(sma_products.end_date, '%d/%m/%Y') <=", $end_date);
            }

            if ($warehouse) {
                $this->datatables->where("sma_products.warehouse", $warehouse);
            }

            echo $this->datatables->generate();

        }

    }

}
