<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update301 extends CI_Migration {

    public function up() {
        $mod = array(
            'version' => array( 'name' => 'version', 'type' => 'varchar', 'constraint' => '10' )
        );
        $this->dbforge->modify_column('settings', $mod);
        $add = array(
                'update' => array('type' => 'tinyint', 'constraint' => '1', 'null' => TRUE, 'default' => '0')
        );
        $this->dbforge->add_column('settings', $add);
    }

}