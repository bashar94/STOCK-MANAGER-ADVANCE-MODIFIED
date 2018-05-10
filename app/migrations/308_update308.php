<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update308 extends CI_Migration {

    public function up() {

        $add_set = array('display_all_products' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0));
        $this->dbforge->add_column('settings', $add_set);

        $add_tra = array('warehouse_id' => array('type' => 'INT', 'constraint' => '11', 'null' => TRUE));
        $this->dbforge->add_column('transfer_items', $add_tra);

    }

    public function down() { }

}
