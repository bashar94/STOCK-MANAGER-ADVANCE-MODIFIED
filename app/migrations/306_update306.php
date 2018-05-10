<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update306 extends CI_Migration {

    public function up() {

        $costing_mod = array(
            'quantity' => array( 'name' => 'quantity', 'type' => 'DECIMAL', 'constraint' => '15,4'),
            'purchase_net_unit_cost' => array( 'name' => 'purchase_net_unit_cost', 'type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE),
            'purchase_unit_cost' => array( 'name' => 'purchase_unit_cost', 'type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE),
            'sale_net_unit_price' => array( 'name' => 'sale_net_unit_price', 'type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE),
            'sale_unit_price' => array( 'name' => 'sale_unit_price', 'type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE),
            'quantity_balance' => array( 'name' => 'quantity_balance', 'type' => 'DECIMAL', 'constraint' => '15,4', 'null' => TRUE),
        );
        $this->dbforge->modify_column('costing', $fields);

        $costing_add = array('option_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE));
        $this->dbforge->add_column('costing', $costing_add);

        $attachment = array('attachment' => array('type' => 'VARCHAR', 'constraint' => '55', 'null' => TRUE));
        $this->dbforge->add_column('sales', $attachment);
        $this->dbforge->add_column('quotes', $attachment);
        $this->dbforge->add_column('purchases', $attachment);
        $this->dbforge->add_column('transfers', $attachment);
        $this->dbforge->add_column('return_sales', $attachment);

    }

    public function down() { }

}
