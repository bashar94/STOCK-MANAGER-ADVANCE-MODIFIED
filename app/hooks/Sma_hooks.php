<?php

class Sma_hooks {
    protected $CI;
    public function __construct() {
        $this->CI =& get_instance();
    }
    public function check() {
        if(! ($this->CI->db->conn_id)) {
            header("Location: install/index.php");
            die();
        }
    }

}
