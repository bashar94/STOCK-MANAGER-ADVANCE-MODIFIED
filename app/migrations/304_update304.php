<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update304 extends CI_Migration {

    public function up() {
        $add = array('type' => array('type' => 'VARCHAR', 'constraint' => '20'));
        $this->dbforge->add_column('damage_products', $add);
        $mod = array('user' => array('name' => 'created_by', 'type' => 'INT', 'null' => TRUE));
        $this->dbforge->modify_column('damage_products', $mod);
        $this->dbforge->rename_table('damage_products', 'adjustments');
    }

}