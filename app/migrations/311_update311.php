<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update311 extends CI_Migration {

    public function up() {

        $add_fields = array(
            'after_sale_page' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
            'item_order' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0),
        );
        $this->dbforge->add_column('pos_settings', $add_fields);

    }

    public function down() { }

}
