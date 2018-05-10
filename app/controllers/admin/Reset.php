<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends CI_Controller
{

    function __construct() {
        parent::__construct();
    }

    function index() {
        show_404();
    }

    function demo() {
        if (DEMO) {
            $this->db->truncate('adjustments');
            $this->db->truncate('adjustment_items');
            $this->db->truncate('calendar');
            $this->db->truncate('captcha');
            $this->db->truncate('categories');
            $this->db->truncate('combo_items');
            $this->db->truncate('companies');
            $this->db->truncate('costing');
            $this->db->truncate('currencies');
            $this->db->truncate('customer_groups');
            $this->db->truncate('deliveries');
            $this->db->truncate('deposits');
            $this->db->truncate('expenses');
            $this->db->truncate('gift_cards');
            $this->db->truncate('groups');
            $this->db->truncate('login_attempts');
            $this->db->truncate('notifications');
            $this->db->truncate('order_ref');
            $this->db->truncate('payments');
            $this->db->truncate('paypal');
            $this->db->truncate('permissions');
            $this->db->truncate('pos_register');
            $this->db->truncate('pos_settings');
            $this->db->truncate('products');
            $this->db->truncate('product_photos');
            $this->db->truncate('product_variants');
            $this->db->truncate('purchases');
            $this->db->truncate('purchase_items');
            $this->db->truncate('quotes');
            $this->db->truncate('quote_items');
            $this->db->truncate('sales');
            $this->db->truncate('sale_items');
            $this->db->truncate('sessions');
            $this->db->truncate('settings');
            $this->db->truncate('skrill');
            $this->db->truncate('suspended_bills');
            $this->db->truncate('suspended_items');
            $this->db->truncate('tax_rates');
            $this->db->truncate('transfers');
            $this->db->truncate('transfer_items');
            $this->db->truncate('users');
            $this->db->truncate('user_logins');
            $this->db->truncate('variants');
            $this->db->truncate('warehouses');
            $this->db->truncate('warehouses_products');
            $this->db->truncate('warehouses_products_variants');
            $this->db->truncate('expense_categories');
            $this->db->truncate('gift_card_topups');
            $this->db->truncate('addresses');
            $this->db->truncate('brands');
            $this->db->truncate('price_groups');
            $this->db->truncate('product_prices');
            $this->db->truncate('units');
            $this->db->truncate('stock_counts');
            $this->db->truncate('stock_count_items');
            $this->db->truncate('printers');
            $this->db->truncate('pages');
            $this->db->truncate('shop_settings');
            $this->db->truncate('api_keys');
            $this->db->truncate('api_limits');
            $this->db->truncate('api_logs');

            $file = file_get_contents('./files/demo.sql');
            mysqli_multi_query($this->db->conn_id, $file);
            // $this->db->conn_id->multi_query($file);
            $this->db->conn_id->close();
            // $this->load->dbutil();
            // $this->dbutil->optimize_database();

            admin_redirect('login');
        } else {
            echo '<!DOCTYPE html>
            <html>
                <head>
                    <title>Stock Manager Advance</title>
                    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
                    <style>
                        html, body { height: 100%; }
                        body { margin: 0; padding: 0; width: 100%; display: table; font-weight: 72; font-family: \'Lato\'; }
                        .container { text-align: center; display: table-cell; vertical-align: middle; }
                        .content { text-align: center; display: inline-block; }
                        .title { font-size: 72px; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="content">
                            <div class="title">Demo is disabled!</div>
                        </div>
                    </div>
                </body>
            </html>
            ';
        }
    }

}
