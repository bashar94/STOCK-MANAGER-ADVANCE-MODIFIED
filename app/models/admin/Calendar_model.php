<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    public function getEvents($start, $end) {

        $this->db->select('id, title, start, end, description, color');
        $this->db->where('start >=', $start)->where('start <=', $end);
        if ($this->Settings->restrict_calendar) {
            $this->db->where('user_id', $this->session->userdata('user_id'));
        }

        $q = $this->db->get('calendar');

        if ($q->num_rows() > 0) {
            foreach (($q->result_array()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;

    }

    public function getEventByID($id)
    {
        $q = $this->db->get_where('calendar', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addEvent($data = array()) {
        if ($this->db->insert('calendar', $data)) {
            return true;
        }
        return false;
    }

    public function updateEvent($id, $data = array()) {
        if ($this->db->update('calendar', $data, array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function deleteEvent($id) {
        if ($this->db->delete('calendar', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

}
