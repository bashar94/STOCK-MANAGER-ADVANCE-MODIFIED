<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_admin_model extends CI_Model
{

    public function __construct() {
        parent::__construct();
    }

    public function getShopSettings() {
        $q = $this->db->get('shop_settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function updateSlider($data) {
        if ($this->db->update('shop_settings', array('slider' => json_encode($data)), array('shop_id' => 1))) {
            return true;
        }
        return false;
    }

    public function updateShopSettings($data) {
        if ($this->db->update('shop_settings', $data, array('shop_id' => 1))) {
            return true;
        }
        return false;
    }

    public function getPageByID($id) {
        $q = $this->db->get_where('pages', array('id' => $id));
        if( $q->num_rows() > 0 ) {
            return $q->row();
        }
        return FALSE;
    }

    public function getPageBySlug($slug) {
        $q = $this->db->get_where('pages', array('slug' => $slug));
        if( $q->num_rows() > 0 ) {
            return $q->row();
        }
        return FALSE;
    }

    public function addPage($data) {
        if ($this->db->insert('pages', $data)) {
            return true;
        }
        return false;
    }

    public function updatePage($id, $data) {
        if ($this->db->update('pages', $data, array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function getAllPages() {
        $q = $this->db->get('pages');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function deletePage($id) {
        if ($this->db->delete('pages', array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function getAllProducts() {
        $this->db->select('id, LOWER(name) as name, slug');
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllCategories() {
        $this->db->where('parent_id', NULL)->or_where('parent_id', 0)->order_by('name');
        return $this->db->get("categories")->result();
    }

    public function getSubCategories($parent_id) {
        $this->db->where('parent_id', $parent_id)->order_by('name');
        return $this->db->get("categories")->result();
    }

    public function getAllBrands() {
        return $this->db->get("brands")->result();
    }

}
