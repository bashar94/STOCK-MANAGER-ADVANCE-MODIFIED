<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->lang->admin_load('cron');
    }

    public function run_cron()
    {
        $m = [];
        if ($this->resetOrderRef()) {
            $m[] = lang('order_ref_updated');
        }
        if ($pendingInvoices = $this->getAllPendingInvoices()) {
            $p = 0;
            foreach ($pendingInvoices as $invoice) {
                $this->updateInvoiceStatus($invoice->id);
                $p++;
            }
            $m[] = sprintf(lang('x_pending_to_due'), $p);

        }
        if ($partialInvoices = $this->getAllPPInvoices()) {
            $pp = 0;
            foreach ($partialInvoices as $invoice) {
                $this->updateInvoiceStatus($invoice->id);
                $pp++;
            }
            $m[] = sprintf(lang('x_partial_to_due'), $pp);
        }
        if ($unpaidpurchases = $this->getUnpaidPuchases()) {
            $up = 0;
            foreach ($unpaidpurchases as $purchase) {
                $this->db->update('purchases', array('payment_status' => 'due'), array('id' => $purchase->id));
                $up++;
            }
            $m[] = sprintf(lang('x_purchases_changed'), $up);
        }
        if ($pis = $this->get_expired_products()) {
            $e = 0; $ep = 0;
            foreach($pis as $pi) {
                $this->db->update('purchase_items', array('quantity_balance' => 0), array('id' => $pi->id));
                $e++;
                $ep += $pi->quantity_balance;
            }
            $this->site->syncQuantity(NULL, NULL, $pis);
            $m[] = sprintf(lang('x_products_expired'), $e, $ep);
        }
        if ($promos = $this->getPromoProducts()) {
            $pro = 0;
            foreach($promos as $pr) {
                $this->db->update('products', array('promotion' => 0), array('id' => $pr->id));
                $pro++;
            }
            $m[] = sprintf(lang('x_promotions_expired'), $pro);
        }
        $date = date('Y-m-d H:i:s', strtotime('-1 month'));
        if ($this->deleteUserLgoins($date)) {
            $m[] = sprintf(lang('user_login_deleted'), $date);
        }
        if ($this->db_backup()) {
            $m[] = lang('backup_done');
        }
        if ($this->checkUpdate()) {
             $m[] = lang('update_available');
        }
        $r = !empty($m) ? $m : false;
        $this->send_email($r);
        $this->db->truncate('sessions');
        return $r;
    }

    private function getAllPendingInvoices()
    {
        $today = date('Y-m-d');
        $paid = $this->lang->line('paid');
        $canceled = $this->lang->line('cancelled');
        $q = $this->db->get_where('sales', array('due_date <=' => $today, 'due_date !=' => '1970-01-01', 'due_date !=' => NULL, 'payment_status' => 'pending'));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    private function getAllPPInvoices()
    {
        $today = date('Y-m-d');
        $paid = $this->lang->line('paid');
        $canceled = $this->lang->line('cancelled');
        $q = $this->db->get_where('sales', array('due_date <=' => $today, 'due_date !=' => '1970-01-01', 'due_date !=' => NULL, 'payment_status' => 'partial'));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    private function updateInvoiceStatus($id)
    {
        if ($this->db->update('sales', array('payment_status' => 'due'), array('id' => $id))) {
            return TRUE;
        }
        return FALSE;
    }

    private function resetOrderRef()
    {
        if ($this->Settings->reference_format == 1 || $this->Settings->reference_format == 2) {
            $month = date('Y-m') . '-01';
            $year = date('Y') . '-01-01';
            if ($ref = $this->getOrderRef()) {
                $reset_ref = array('so' => 1, 'qu' => 1, 'po' => 1, 'to' => 1, 'pos' => 1, 'do' => 1, 'pay' => 1, 'ppay' => 1, 're' => 1, 'rep' => 1, 'ex' => 1, 'qa' => 1);
                if ($this->Settings->reference_format == 1 && strtotime($ref->date) < strtotime($year)) {
                    $reset_ref['date'] = $year;
                    $this->db->update('order_ref', $reset_ref, array('ref_id' => 1));
                    return TRUE;
                } elseif ($this->Settings->reference_format == 2 && strtotime($ref->date) < strtotime($month)) {
                    $reset_ref['date'] = $month;
                    $this->db->update('order_ref', $reset_ref, array('ref_id' => 1));
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    private function getOrderRef()
    {
        $q = $this->db->get_where('order_ref', array('ref_id' => 1), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getSettings()
    {
        $q = $this->db->get_where('settings', array('setting_id' => 1), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    private function deleteUserLgoins($date)
    {
        $this->db->where('time <', $date);
        if ($this->db->delete('user_logins')) {
            return true;
        }
        return FALSE;
    }

    private function checkUpdate()
    {
        $fields = array('version' => $this->Settings->version, 'code' => $this->Settings->purchase_code, 'username' => $this->Settings->envato_username, 'site' => base_url());
        $this->load->helper('update');
        $protocol = is_https() ? 'https://' : 'http://';
        $updates = get_remote_contents($protocol.'tecdiary.com/api/v1/update/', $fields);
        $response = json_decode($updates);
        if (!empty($response->data->updates)) {
            $this->db->update('settings', array('update' => 1), array('setting_id' => 1));
            return TRUE;
        }
        return FALSE;
    }

    private function get_expired_products() {
        if ($this->Settings->remove_expired) {
            $date = date('Y-m-d');
            $this->db->where('expiry <=', $date)->where('expiry !=', NULL)->where('expiry !=', '0000-00-00')->where('quantity_balance >', 0);
            $q = $this->db->get('purchase_items');
            if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
        }
        return FALSE;
    }

    private function getUnpaidPuchases()
    {
        $today = date('Y-m-d');
        $q = $this->db->get_where('purchases', array('payment_status !=' => 'paid', 'payment_status !=' => 'due', 'payment_term >' => 0, 'due_date !=' => NULL, 'due_date <=' => $today));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    private function getPromoProducts()
    {
        $today = date('Y-m-d');
        $q = $this->db->get_where('products', array('promotion' => 1, 'end_date !=' => NULL, 'end_date <=' => $today));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    private function db_backup() {
        $this->load->dbutil();
        $prefs = array(
            'format' => 'txt',
            'filename' => 'sma_db_backup.sql'
        );
        $back = $this->dbutil->backup($prefs);
        $backup =& $back;
        $db_name = 'db-backup-on-' . date("Y-m-d-H-i-s") . '.txt';
        $save = './files/backups/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);

        $files = glob('./files/backups/*.txt', GLOB_BRACE);
        $now   = time();
        foreach ($files as $file) {
            if (is_file($file)) {
                if ($now - filemtime($file) >= 60 * 60 * 24 * 30) {
                    unlink($file);
                }
            }
        }

        return TRUE;
    }

    function send_email($details) {
        if ($details) {
            $table_html = '';
            $tables = $this->cron_model->yesterday_report();
            foreach ($tables as $table) {
                $table_html .= $table.'<div style="clear:both"></div>';
            }
            foreach ($details as $detail) {
                $table_html = $table_html.$detail;
            }
            $msg_with_yesterday_report = $table_html;
            $owners = $this->db->get_where('users', array('group_id' => 1))->result();
            $this->load->library('email');
            $config['useragent'] = "Stock Manager Advance";
            $config['protocol'] = $this->Settings->protocol;
            $config['mailtype'] = "html";
            $config['crlf'] = "\r\n";
            $config['newline'] = "\r\n";
            if ($this->Settings->protocol == 'sendmail') {
                $config['mailpath'] = $this->Settings->mailpath;
            } elseif ($this->Settings->protocol == 'smtp') {
                $config['smtp_host'] = $this->Settings->smtp_host;
                $config['smtp_user'] = $this->Settings->smtp_user;
                $config['smtp_pass'] = $this->Settings->smtp_pass;
                $config['smtp_port'] = $this->Settings->smtp_port;
                if (!empty($this->Settings->smtp_crypto)) {
                    $config['smtp_crypto'] = $this->Settings->smtp_crypto;
                }
            }
            $this->email->initialize($config);

            foreach ($owners as $owner) {
                list($user, $domain) = explode('@', $owner->email);
                if ($domain != 'tecdiary.com') {
                    $this->load->library('parser');
                    $parse_data = array(
                        'name' => $owner->first_name . ' ' . $owner->last_name,
                        'email' => $owner->email,
                        'msg' => $msg_with_yesterday_report,
                        'site_link' => base_url(),
                        'site_name' => $this->Settings->site_name,
                        'logo' => '<img src="' . base_url('assets/uploads/logos/' . $this->Settings->logo) . '" alt="' . $this->Settings->site_name . '"/>'
                        );
                    $msg = file_get_contents('./themes/' . $this->Settings->theme . '/admin/views/email_templates/cron.html');
                    $message = $this->parser->parse_string($msg, $parse_data);
                    $subject = lang('cron_job') . ' - ' . $this->Settings->site_name;

                    $this->email->from($this->Settings->default_email, $this->Settings->site_name);
                    $this->email->to($owner->email);
                    $this->email->subject($subject);
                    $this->email->message($message);
                    $this->email->send();
                }
            }
        }
    }

    private function yesterday_report() {
        $date = date('Y-m-d', strtotime('-1 day'));
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $warehouses = $this->db->get('warehouses')->result();
        foreach ($warehouses as $warehouse) {
            $costing = $this->getCosting($date, $warehouse->id);
            $discount = $this->getOrderDiscount($sdate, $edate, $warehouse->id);
            $expenses = $this->getExpenses($sdate, $edate, $warehouse->id);
            $returns = $this->getReturns($sdate, $edate, $warehouse->id);
            $total_purchases = $this->getTotalPurchases($sdate, $edate, $warehouse->id);
            $total_sales = $this->getTotalSales($sdate, $edate, $warehouse->id);
            $html[] = $this->gen_html($costing, $discount, $expenses, $returns, $total_purchases, $total_sales, $warehouse);
        }

        $costing = $this->getCosting($date);
        $discount = $this->getOrderDiscount($sdate, $edate);
        $expenses = $this->getExpenses($sdate, $edate);
        $returns = $this->getReturns($sdate, $edate);
        $total_purchases = $this->getTotalPurchases($sdate, $edate);
        $total_sales = $this->getTotalSales($sdate, $edate);
        $html[] = $this->gen_html($costing, $discount, $expenses, $returns, $total_purchases, $total_sales);

        return $html;
    }

    private function gen_html($costing, $discount, $expenses, $returns, $purchases, $sales, $warehouse = NULL) {
        $html = '<div style="border:1px solid #DDD; padding:10px; margin:10px 0;"><h3>'.($warehouse ? $warehouse->name.' ('.$warehouse->code.')' : lang('all_warehouses')).'</h3>
        <table width="100%" class="stable">
        <tr>
            <td style="border-bottom: 1px solid #EEE;">'.lang('products_sale').'</td>
            <td style="text-align:right; border-bottom: 1px solid #EEE;">'.$this->sma->formatMoney($costing->sales).'</td>
        </tr>';
        if ($discount && $discount->order_discount > 0) {
            $html .= '
            <tr>
                <td style="border-bottom: 1px solid #DDD;">'.lang('order_discount').'</td>
                <td style="text-align:right;border-bottom: 1px solid #DDD;">'. $this->sma->formatMoney($discount->order_discount).'</td>
            </tr>';
        }
        $html .= '
        <tr>
            <td style="border-bottom: 1px solid #EEE;">'.lang('products_cost').'</td>
            <td style="text-align:right; border-bottom: 1px solid #EEE;">'.$this->sma->formatMoney($costing->cost).'</td>
        </tr>';
        if ($expenses && $expenses->total > 0) {
            $html .= '
            <tr>
                <td style="border-bottom: 1px solid #DDD;">'.lang('expenses').'</td>
                <td style="text-align:right;border-bottom: 1px solid #DDD;">'. $this->sma->formatMoney($expenses->total).'</td>
            </tr>';
        }
        $html .= '
        <tr>
            <td width="300px;" style="border-bottom: 1px solid #DDD;"><strong>'.lang('profit').'</strong></td>
            <td style="text-align:right;border-bottom: 1px solid #DDD;">
                <strong>'.$this->sma->formatMoney($costing->sales - $costing->cost - ($discount ? $discount->order_discount : 0) - ($expenses ? $expenses->total : 0)).'</strong>
            </td>
        </tr>';
        if (isset($returns->total)) {
            $html .= '
            <tr>
                <td width="300px;" style="border-bottom: 2px solid #DDD;"><strong>'.lang('return_sales').'</strong></td>
                <td style="text-align:right;border-bottom: 2px solid #DDD;"><strong>'.$this->sma->formatMoney($returns->total).'</strong></td>
            </tr>';
        }
        $html .= '</table><h4 style="margin-top:15px;">'. lang('general_ledger') .'</h4>
        <table width="100%" class="stable">';
        if ($sales) {
            $html .= '
            <tr>
                <td width="33%" style="border-bottom: 1px solid #DDD;">'.lang('total_sales').': <strong>'.$this->sma->formatMoney($sales->total_amount).'('.$sales->total.')</strong></td>
                <td width="33%" style="border-bottom: 1px solid #DDD;">'.lang('received').': <strong>'.$this->sma->formatMoney($sales->paid).'</strong></td>
                <td width="33%" style="border-bottom: 1px solid #DDD;">'.lang('taxes').': <strong>'.$this->sma->formatMoney($sales->tax).'</strong></td>
            </tr>';
        }
        if ($purchases) {
            $html .= '
            <tr>
                <td width="33%">'.lang('total_purchases').': <strong>'.$this->sma->formatMoney($purchases->total_amount).'('.$purchases->total.')</strong></td>
                <td width="33%">'.lang('paid').': <strong>'.$this->sma->formatMoney($purchases->paid).'</strong></td>
                <td width="33%">'.lang('taxes').': <strong>'.$this->sma->formatMoney($purchases->tax).'</strong></td>
            </tr>';
        }
        $html .= '</table></div>';
        return $html;
    }

    private function getCosting($date, $warehouse_id = NULL)
    {
        $this->db->select('SUM( COALESCE( purchase_unit_cost, 0 ) * quantity ) AS cost, SUM( COALESCE( sale_unit_price, 0 ) * quantity ) AS sales, SUM( COALESCE( purchase_net_unit_cost, 0 ) * quantity ) AS net_cost, SUM( COALESCE( sale_net_unit_price, 0 ) * quantity ) AS net_sales', FALSE);
        $this->db->where('costing.date', $date);
        if ($warehouse_id) {
            $this->db->join('sales', 'sales.id=costing.sale_id')
            ->where('sales.warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('costing');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    private function getOrderDiscount($sdate, $edate, $warehouse_id = NULL)
    {
        $this->db->select('SUM( COALESCE( order_discount, 0 ) ) AS order_discount', FALSE);
        $this->db->where('date >=', $sdate)->where('date <=', $edate);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    private function getExpenses($sdate, $edate, $warehouse_id = NULL)
    {
        $this->db->select('SUM( COALESCE( amount, 0 ) ) AS total', FALSE);
        $this->db->where('date >=', $sdate)->where('date <=', $edate);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    private function getReturns($sdate, $edate, $warehouse_id = NULL)
    {
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total', FALSE)
        ->where('sale_status', 'returned');
        $this->db->where('date >=', $sdate)->where('date <=', $edate);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    private function getTotalPurchases($sdate, $edate, $warehouse_id = NULL)
    {
        $this->db->select('count(id) as total, sum(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid, SUM(COALESCE(total_tax, 0)) as tax', FALSE)
            ->where('status !=', 'pending')
            ->where('date >=', $sdate)->where('date <=', $edate);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    private function getTotalSales($sdate, $edate, $warehouse_id = NULL)
    {
        $this->db->select('count(id) as total, sum(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid, SUM(COALESCE(total_tax, 0)) as tax', FALSE)
            ->where('sale_status !=', 'pending')
            ->where('date >=', $sdate)->where('date <=', $edate);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

}
