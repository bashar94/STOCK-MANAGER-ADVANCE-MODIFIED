<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update316 extends CI_Migration {

    public function up() {

        if (file_exists(APPPATH.'controllers'.DIRECTORY_SEPARATOR.'shop'.DIRECTORY_SEPARATOR.'Shop.php')) {
            $cart_mod = array('id' => array( 'name' => 'id', 'type' => 'VARCHAR', 'constraint' => '40'));
            $this->dbforge->modify_column('cart', $cart_mod);
        }

        $products = array(
            'origin' => array('type' => 'VARCHAR', 'constraint' => '200', 'null' => TRUE),
            'avg_size_pack' => array('type' => 'DOUBLE', 'default' => 0),
            'damage_unit' => array('type' => 'INT', 'constraint' => '11', 'default' => 0),
        );
        $this->dbforge->add_column('products', $products);

    }

    public function down() { }

}
