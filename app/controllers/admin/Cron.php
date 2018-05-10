<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->admin_model('cron_model');
        $this->Settings = $this->cron_model->getSettings();
    }

    function index() {
        show_404();
    }

    function run() {
        if ($m = $this->cron_model->run_cron()) {
            if($this->input->is_cli_request()) {
                foreach($m as $msg) {
                    echo $msg."\n";
                }
            } else {
                echo '<!doctype html><html><head><title>Cron Job</title><style>p{background:#F5F5F5;border:1px solid #EEE; padding:15px;}</style></head><body>';
                echo '<p>Corn job successfully run.</p>';
                foreach($m as $msg) {
                    echo '<p>'.$msg.'</p>';
                }
                echo '</body></html>';
            }
        }
    }

}
