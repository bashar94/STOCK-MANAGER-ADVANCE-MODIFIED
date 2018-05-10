<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update312 extends CI_Migration {

    public function up() {

        $fields = array(
            'id' => array( 'type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE ),
            'company_id' => array( 'type' =>'INT', 'constraint' => '11' ),
            'amount' => array( 'type' => 'DECIMAL', 'constraint' => '25,4' ),
            'paid_by' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE ),
            'note' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE ),
            'created_by' => array( 'type' => 'INT' ),
            'updated_by' => array( 'type' => 'INT', 'null' => TRUE ),
            'updated_at' => array( 'type' => 'DATETIME', 'null' => TRUE ),
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_field("date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->dbforge->add_key('id', TRUE);
        $attributes = array('ENGINE' => 'InnoDB', 'AUTO_INCREMENT' => 1);
        $this->dbforge->create_table('deposits', TRUE, $attributes);

        $products = array(
            'promotion' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
            'promo_price' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE, 'default' => NULL),
            'start_date' => array('type' => 'DATE', 'null' => TRUE),
            'end_date' => array('type' => 'DATE', 'null' => TRUE),
            'supplier1_part_no' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
            'supplier2_part_no' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
            'supplier3_part_no' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
            'supplier4_part_no' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
            'supplier5_part_no' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
        );
        $this->dbforge->add_column('products', $products);

        $purchases = array(
            'payment_term' => array('type' => 'TINYINT', 'null' => TRUE),
            'due_date' => array('type' => 'DATE', 'null' => TRUE),
        );
        $this->dbforge->add_column('purchases', $purchases);

        $purchase_items = array(
            'supplier_part_no' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE),
        );
        $this->dbforge->add_column('purchase_items', $purchase_items);

        $settings = array(
            'barcode_separator' => array('type' => 'VARCHAR', 'constraint' => '2', 'default' => '_'),
        );
        $this->dbforge->add_column('settings', $settings);

        $permissions = array(
            'bulk_actions' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
            'customers-deposits' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
            'customers-delete_deposit' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
        );
        $this->dbforge->add_column('permissions', $permissions);

        $companies = array(
            'deposit_amount' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE),
        );
        $this->dbforge->add_column('companies', $companies);

    }

    public function down() { }

}
