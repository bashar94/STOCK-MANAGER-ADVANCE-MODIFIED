<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update303 extends CI_Migration {

    public function up() {
        $add = array(
                'total_cash_submitted' => array('type' => 'decimal', 'constraint' => '25,5'),
                'total_cheques_submitted' => array('type' => 'int', 'constraint' => '11'),
                'total_cc_slips_submitted' => array('type' => 'int', 'constraint' => '11')
        );
        $this->dbforge->add_column('pos_register', $add);
    }

}