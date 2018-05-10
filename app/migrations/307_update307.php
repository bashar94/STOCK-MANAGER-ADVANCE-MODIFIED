<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update307 extends CI_Migration {

    public function up() {

        $qty_decimals = array('qty_decimals' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 2));
        $this->dbforge->add_column('settings', $qty_decimals);

    }

    public function down() { }

}
