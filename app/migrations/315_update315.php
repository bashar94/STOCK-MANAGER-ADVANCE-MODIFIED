<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update315 extends CI_Migration {

    public function up() {

        $settings = array(
            'set_focus' => array('type' => 'TINYINT', 'constraint' => '1', 'default' => 0),
        );
        $this->dbforge->add_column('settings', $settings);

        $wp = array(
            'avg_cost' => array('type' => 'DECIMAL', 'constraint' => '25,4'),
        );
        $this->dbforge->add_column('warehouses_products', $wp);

        $permissions = array(
            'reports-daily_purchases' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
            'reports-monthly_purchases' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
        );
        $this->dbforge->add_column('permissions', $permissions);

        $expenses = array(
            'warehouse_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE),
        );
        $this->dbforge->add_column('expenses', $expenses);

        $sales = array(
            'return_sale_ref' => array('type' => 'VARCHAR', 'constraint' => '55', 'null' => TRUE),
            'sale_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE),
            'return_sale_total' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE, 'default' => 0),
        );
        $this->dbforge->add_column('sales', $sales);

        $sale_items = array(
            'sale_item_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE),
        );
        $this->dbforge->add_column('sale_items', $sale_items);

        $purchases = array(
            'return_purchase_ref' => array('type' => 'VARCHAR', 'constraint' => '55', 'null' => TRUE),
            'purchase_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE),
            'return_purchase_total' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE, 'default' => 0),
        );
        $this->dbforge->add_column('purchases', $purchases);

        $purchase_items = array(
            'purchase_item_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE),
        );
        $this->dbforge->add_column('purchase_items', $purchase_items);

        $this->dbforge->drop_table('calendar',TRUE);
        $calendar_fields = array(
            'id' => array( 'type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE ),
            'title' => array( 'type' =>'VARCHAR', 'constraint' => '55' ),
            'description' => array( 'type' =>'VARCHAR', 'constraint' => '255', 'null' => TRUE, 'default' => NULL  ),
            'start' => array( 'type' => 'DATETIME'),
            'end' => array( 'type' => 'DATETIME', 'null' => TRUE ),
            'color' => array( 'type' => 'VARCHAR', 'constraint' => '7' ),
            'user_id' => array( 'type' => 'INT', 'constraint' => 11, 'null' => TRUE ),
        );
        $this->dbforge->add_field($calendar_fields);
        $this->dbforge->add_key('id');
        $attributes = array('ENGINE' => 'InnoDB', 'AUTO_INCREMENT' => 1);
        $this->dbforge->create_table('calendar', TRUE, $attributes);

    }

    public function down() { }

}
