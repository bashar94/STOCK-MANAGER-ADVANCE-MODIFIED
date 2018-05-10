<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update314 extends CI_Migration {

    public function up() {

        $fields = array(
            'id' => array( 'type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE ),
            'code' => array('type' => 'VARCHAR', 'constraint' => '55' ),
            'name' => array('type' => 'VARCHAR', 'constraint' => '55' ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $attributes = array('ENGINE' => 'InnoDB', 'AUTO_INCREMENT' => 1);
        $this->dbforge->create_table('expense_categories', TRUE, $attributes);

        $expenses = array(
            'category_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE),
        );
        $this->dbforge->add_column('expenses', $expenses);

        $rp_fields = array(
            'id' => array( 'type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE ),
            'purchase_id' => array( 'type' =>'INT', 'constraint' => '11' ),
            'reference_no' => array( 'type' =>'VARCHAR', 'constraint' => '55' ),
            'supplier_id' => array( 'type' =>'INT', 'constraint' => '11' ),
            'supplier' => array( 'type' =>'VARCHAR', 'constraint' => '55' ),
            'warehouse_id' => array( 'type' =>'INT', 'constraint' => '11', 'null' => TRUE ),
            'note' => array('type' => 'VARCHAR', 'constraint' => '1000', 'null' => TRUE ),
            'total' => array( 'type' => 'DECIMAL', 'constraint' => '25,4' ),
            'product_discount' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'default' => '0.00' ),
            'order_discount_id' => array('type' => 'VARCHAR', 'constraint' => '20', 'null' => TRUE ),
            'total_discount' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'default' => '0.00' ),
            'order_discount' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'default' => '0.00' ),
            'product_tax' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'default' => '0.00' ),
            'order_tax_id' => array( 'type' =>'INT', 'constraint' => '11', 'null' => TRUE ),
            'order_tax' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'default' => '0.00' ),
            'total_tax' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'default' => '0.00' ),
            'surcharge' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'default' => '0.00' ),
            'grand_total' => array( 'type' => 'DECIMAL', 'constraint' => '25,4' ),           
            'created_by' => array( 'type' => 'INT' ),
            'updated_by' => array( 'type' => 'INT', 'null' => TRUE ),
            'updated_at' => array( 'type' => 'DATETIME', 'null' => TRUE ),
            'attachment' => array('type' => 'VARCHAR', 'constraint' => '55', 'null' => TRUE ),
        );
        $this->dbforge->add_field($rp_fields);
        $this->dbforge->add_field("date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_key('id', TRUE);
        $attributes = array('ENGINE' => 'InnoDB', 'AUTO_INCREMENT' => 1);
        $this->dbforge->create_table('return_purchases', TRUE, $attributes);

        $rpi_fields = array(
            'id' => array( 'type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE ),
            'purchase_id' => array( 'type' =>'INT', 'constraint' => '11' ),
            'return_id' => array( 'type' =>'INT', 'constraint' => '11' ),
            'purchase_item_id' => array( 'type' =>'INT', 'constraint' => '11' ),
            'product_id' => array( 'type' =>'INT', 'constraint' => '11' ),
            'product_code' => array( 'type' =>'VARCHAR', 'constraint' => '55' ),
            'product_name' => array( 'type' =>'VARCHAR', 'constraint' => '255' ),
            'product_type' => array( 'type' =>'VARCHAR', 'constraint' => '20', 'null' => TRUE ),
            'option_id' => array( 'type' =>'INT', 'constraint' => '11', 'null' => TRUE ),
            'net_unit_cost' => array( 'type' => 'DECIMAL', 'constraint' => '25,4' ),
            'quantity' => array( 'type' => 'DECIMAL', 'constraint' => '15,4' ),
            'warehouse_id' => array( 'type' =>'INT', 'constraint' => '11', 'null' => TRUE ),
            'item_tax' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE ),
            'tax_rate_id' => array( 'type' => 'INT', 'constraint' => '11', 'null' => TRUE ),
            'tax' => array('type' => 'VARCHAR', 'constraint' => '55', 'null' => TRUE ),
            'discount' => array('type' => 'VARCHAR', 'constraint' => '55', 'null' => TRUE ),
            'item_discount' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE ),
            'subtotal' => array( 'type' => 'DECIMAL', 'constraint' => '25,4' ),
            'real_unit_cost' => array( 'type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE ),
        );
        $this->dbforge->add_field($rpi_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('product_id');
        $this->dbforge->add_key('purchase_id');
        $attributes = array('ENGINE' => 'InnoDB', 'AUTO_INCREMENT' => 1);
        $this->dbforge->create_table('return_purchase_items', TRUE, $attributes);

        $order_ref = array(
            'rep' => array('type' => 'INT', 'constraint' => '11', 'default' => 1),
        );
        $this->dbforge->add_column('order_ref', $order_ref);

        $quotes = array(
            'supplier_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE),
            'supplier' => array('type' => 'VARCHAR', 'constraint' => '55', 'null' => TRUE),
        );
        $this->dbforge->add_column('quotes', $quotes);

        $purchases = array(
            'return_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE),
            'surcharge' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'default' => '0.00'),
        );
        $this->dbforge->add_column('purchases', $purchases);

        $pos_settings = array(
            'authorize' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
        );
        $this->dbforge->add_column('pos_settings', $pos_settings);

        $payments = array(
            'approval_code' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
        );
        $this->dbforge->add_column('payments', $payments);

        $settings = array(
            'returnp_prefix' => array('type' => 'VARCHAR', 'constraint' => '20', 'null' => TRUE),
        );
        $this->dbforge->add_column('settings', $settings);

        $permissions = array(
            'purchases-return_purchases' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
            'reports-expenses' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
        );
        $this->dbforge->add_column('permissions', $permissions);

        $permissions2 = array(
            'products-barcode' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
        );
        $this->dbforge->add_column('permissions', $permissions2);

    }

    public function down() { }

}
