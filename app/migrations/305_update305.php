<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update305 extends CI_Migration {

    public function up() {
        
        $set = array('sac' => array('type' => 'TINYINT', 'constraint' => '1', 'default' => 0));
        $this->dbforge->add_column('settings', $set);

        $rp = array('real_unit_price' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'default' => 0, 'null' => TRUE));
        $this->dbforge->add_column('sale_items', $rp);
        $this->dbforge->add_column('quote_items', $rp);
        $this->dbforge->add_column('return_items', $rp);

        $rc = array(
            'real_unit_cost' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'default' => 0, 'null' => TRUE),
            'unit_cost' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE),
            );
        $this->dbforge->add_column('purchase_items', $rc);

        $trc = array(
            'real_unit_cost' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'default' => 0, 'null' => TRUE),
            'unit_cost' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'null' => TRUE),
            'date' => array('type' => 'DATE', 'null' => TRUE),
            );
        $this->dbforge->add_column('transfer_items', $trc);

        $srp = array('real_unit_price' => array('type' => 'DECIMAL', 'constraint' => '25,4', 'default' => 0, 'null' => TRUE));
        $this->dbforge->add_column('suspended_items', $srp);

    }

}