<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update310 extends CI_Migration {

    public function up() {

        $add_usr = array(
            'allow_discount' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0)
        );
        $this->dbforge->add_column('users', $add_usr);

        $add_set = array(
            'remove_expired' => array('type' => 'TINYINT', 'constraint' => '1', 'null' => TRUE, 'default' => 0)
        );
        $this->dbforge->add_column('settings', $add_set);

    }

    public function down() { }

}
