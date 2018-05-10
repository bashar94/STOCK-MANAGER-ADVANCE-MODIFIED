<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update302 extends CI_Migration {

    public function up() {
        $add = array(
                'unit_price' => array('type' => 'decimal', 'constraint' => '25,5', 'null' => TRUE)
        );
        $this->dbforge->add_column('combo_items', $add);
        $add = array(
            'expense_prefix' => array('type' => 'varchar', 'constraint' => '20', 'null' => TRUE)
        );
        $this->dbforge->add_column('settings', $add);
        $add = array(
            'ex' => array('type' => 'int', 'constraint' => '11', 'default' => 1)
        );
        $this->dbforge->add_column('order_ref', $add);
    }

}