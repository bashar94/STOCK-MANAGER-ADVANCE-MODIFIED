<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update309 extends CI_Migration {

    public function up() {

        $add_usr = array(
            'view_right' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
            'edit_right' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0)
            );
        $this->dbforge->add_column('users', $add_usr);

        $add_pis = array('quantity_received' => array('type' => 'DECIMAL', 'constraint' => '15,4', 'null' => TRUE));
        $this->dbforge->add_column('purchase_items', $add_pis);

        $add_set = array(
            'display_symbol' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE),
            'symbol' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE)
            );
        $this->dbforge->add_column('settings', $add_set);

        $add_pad = array('products-adjustments' => array('type' => 'TINYINT', 'constraint' => '1', 'default' => 0));
        $this->dbforge->add_column('permissions', $add_pad);

    }

    public function down() { }

}
