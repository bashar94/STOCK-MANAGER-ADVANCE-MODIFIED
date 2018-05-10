<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notify extends CI_Controller
{

    function __construct() {
        parent::__construct();
        $this->lang->admin_load('sma');
    }

    function error_404() {
        $this->session->set_flashdata('error', lang('error_404_message').site_url($this->uri->uri_string()));
        redirect('/');
    }

    function csrf($msg = NULL) {
        $data['page_title'] = lang('csrf_error');
        if (!$msg) { $msg = lang('cesr_error_msg'); }
        $this->session->set_flashdata('error', $msg);
        redirect('/', 'location');
    }

    function offline($msg = NULL) {
        $data['page_title'] = lang('site_offline');
        $data['msg'] = $msg;
        $this->load->view('default/notify', $data);
    }

    function payment_success($msg = NULL) {
        $data['page_title'] = lang('payment');
        $data['msg'] = $msg ? $msg : lang('thank_you');
        $data['msg1'] = lang('payment_added');
        $this->load->view('default/notify', $data);
    }

    function payment_failed($msg = NULL) {
        $data['page_title'] = lang('payment');
        $data['msg'] = $msg ? $msg : lang('error');
        $data['msg1'] = lang('payment_failed');
        $this->load->view('default/notify', $data);
    }

    function payment() {
        $data['page_title'] = lang('payment');
        $data['msg'] = lang('info');
        $data['msg1'] = lang('payment_processing');
        $this->load->view('default/notify', $data);
    }

}
