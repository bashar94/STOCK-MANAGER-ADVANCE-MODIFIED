<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sync extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            admin_redirect('welcome');
        }
        $this->load->admin_model('sync_model');
    }

    public function index()
    {
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc = array(array('link' => '#', 'page' => 'sync database'));
        $meta = array('page_title' => 'sync database', 'bc' => $bc);
        $this->page_construct('syncdb/index', $meta, $this->data);

    }

    public function import_billers()
    {

        if ($this->sync_model->importBillers()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function import_customers()
    {

        if ($this->sync_model->importCustomers()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function import_suppliers()
    {

        if ($this->sync_model->importSuppliers()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function user_groups()
    {

        if ($this->sync_model->userGroups()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function delete_extra_tables()
    {

        if ($this->sync_model->deleteExtraTables()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function reset_sales()
    {

        if ($this->sync_model->resetSalesTable()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function reset_quotes()
    {

        if ($this->sync_model->resetQuotesTable()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function reset_purchases()
    {

        if ($this->sync_model->resetPurchasesTable()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function reset_transfers()
    {

        if ($this->sync_model->resetTransfersTable()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function reset_deliveries()
    {

        if ($this->sync_model->resetDeliveriesTable()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function reset_products()
    {

        if ($this->sync_model->resetProductsTable()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function reset_damage_products()
    {

        if ($this->sync_model->resetDamageProductsTable()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function update_sales()
    {

        if ($this->sync_model->updateSales()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function update_quotes()
    {

        if ($this->sync_model->updateQuotes()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function update_purchases()
    {

        if ($this->sync_model->updatePurchases()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

    public function update_transfers()
    {

        if ($this->sync_model->updateTransfers()) {
            die('<i class="fa fa-check"></a> Success!');
        }
        die('<i class="fa fa-times"></a> Failed!');

    }

}
