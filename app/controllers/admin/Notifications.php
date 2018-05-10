<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        if (!$this->Owner && !$this->Admin) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->lang->admin_load('notifications', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->admin_model('cmt_model');

    }

    function index()
    {
        if (!$this->Owner && !$this->Admin) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('notifications')));
        $meta = array('page_title' => lang('notifications'), 'bc' => $bc);
        $this->page_construct('notifications/index', $meta, $this->data);
    }

    function getNotifications()
    {

        $this->load->library('datatables');
        $this->datatables
            ->select("id, comment, date, from_date, till_date")
            ->from("notifications")
            //->where('notification', 1)
            ->add_column("Actions", "<div class=\"text-center\"><a href='" . admin_url('notifications/edit/$1') . "' data-toggle='modal' data-target='#myModal' class='tip' title='" . lang("edit_notification") . "'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . $this->lang->line("delete_notification") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . admin_url('notifications/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div>", "id");
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }

    function add()
    {

        $this->form_validation->set_rules('comment', lang("comment"), 'required|min_length[3]');

        if ($this->form_validation->run() == true) {
            $data = array(
                'comment' => $this->input->post('comment'),
                'from_date' => $this->input->post('from_date') ? $this->sma->fld($this->input->post('from_date')) : NULL,
                'till_date' => $this->input->post('to_date') ? $this->sma->fld($this->input->post('to_date')) : NULL,
                'scope' => $this->input->post('scope'),
            );
        } elseif ($this->input->post('submit')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("notifications");
        }

        if ($this->form_validation->run() == true && $this->cmt_model->addNotification($data)) {
            $this->session->set_flashdata('message', lang("notification_added"));
            admin_redirect("notifications");
        } else {

            $this->data['comment'] = array('name' => 'comment',
                'id' => 'comment',
                'type' => 'textarea',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('comment'),
            );

            $this->data['error'] = validation_errors();
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'notifications/add', $this->data);

        }
    }

    function edit($id = NULL)
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        }

        $this->form_validation->set_rules('comment', lang("notifications"), 'required|min_length[3]');

        if ($this->form_validation->run() == true) {
            $data = array(
                'comment' => $this->input->post('comment'),
                'from_date' => $this->input->post('from_date') ? $this->sma->fld($this->input->post('from_date')) : NULL,
                'till_date' => $this->input->post('to_date') ? $this->sma->fld($this->input->post('to_date')) : NULL,
                'scope' => $this->input->post('scope'),
            );
        } elseif ($this->input->post('submit')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect("notifications");
        }

        if ($this->form_validation->run() == true && $this->cmt_model->updateNotification($id, $data)) {

            $this->session->set_flashdata('message', lang("notification_updated"));
            admin_redirect("notifications");

        } else {

            $comment = $this->cmt_model->getCommentByID($id);

            $this->data['comment'] = array('name' => 'comment',
                'id' => 'comment',
                'type' => 'textarea',
                'class' => 'form-control',
                'required' => 'required',
                'value' => $this->form_validation->set_value('comment', $comment->comment),
            );


            $this->data['notification'] = $comment;
            $this->data['id'] = $id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['error'] = validation_errors();
            $this->load->view($this->theme . 'notifications/edit', $this->data);

        }
    }

    function delete($id = NULL)
    {
        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        if ($this->cmt_model->deleteComment($id)) {
            $this->sma->send_json(array('error' => 0, 'msg' => lang("notifications_deleted")));
        }
    }

}
