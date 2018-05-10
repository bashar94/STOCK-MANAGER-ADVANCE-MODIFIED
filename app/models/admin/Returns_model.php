<?php defined('BASEPATH') or exit('No direct script access allowed');

class Returns_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductNames($term, $limit = 5)
    {
        $this->db->where("(name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
        $this->db->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getReturnByID($id)
    {
        $q = $this->db->get_where('returns', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getReturnItems($return_id)
    {
        $this->db->select('return_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, products.image, products.details as details, product_variants.name as variant, products.hsn_code as hsn_code, products.second_name as second_name')
            ->join('products', 'products.id=return_items.product_id', 'left')
            ->join('product_variants', 'product_variants.id=return_items.option_id', 'left')
            ->join('tax_rates', 'tax_rates.id=return_items.tax_rate_id', 'left')
            ->where('return_id', $return_id)
            ->group_by('return_items.id')
            ->order_by('id', 'asc');

        $q = $this->db->get('return_items');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function addReturn($data = array(), $items = array())
    {
        if ($this->db->insert('returns', $data)) {
            $return_id = $this->db->insert_id();
            if ($this->site->getReference('re') == $data['reference_no']) {
                $this->site->updateReference('re');
            }
            foreach ($items as $item) {
                $item['return_id'] = $return_id;
                $this->db->insert('return_items', $item);
                if ($item['product_type'] == 'standard') {
                    $clause = ['product_id' => $item['product_id'], 'warehouse_id' => $item['warehouse_id'], 'purchase_id' => null, 'transfer_id' => null, 'option_id' => $item['option_id']];
                    $this->site->setPurchaseItem($clause, $item['quantity']);
                    $this->site->syncQuantity(null, null, null, $item['product_id']);
                } elseif ($item['product_type'] == 'combo') {
                    $combo_items = $this->site->getProductComboItems($item['product_id']);
                    foreach ($combo_items as $combo_item) {
                        $clause = ['product_id' => $combo_item->id, 'purchase_id' => null, 'transfer_id' => null, 'option_id' => null];
                        $this->site->setPurchaseItem($clause, ($combo_item->qty*$item['quantity']));
                        $this->site->syncQuantity(null, null, null, $combo_item->id);
                    }
                }
            }
            return true;
        }

        return false;
    }

    public function updateReturn($id, $data = array(), $items = array())
    {
        $this->resetSaleActions($id);

        if ($this->db->update('returns', $data, array('id' => $id)) && $this->db->delete('return_items', array('return_id' => $id))) {
            // $return_id = $id;
            foreach ($items as $item) {
                // $item['return_id'] = $return_id;
                $this->db->insert('return_items', $item);
                if ($item['product_type'] == 'standard') {
                    $clause = ['product_id' => $item['product_id'], 'purchase_id' => null, 'transfer_id' => null, 'option_id' => $item['option_id']];
                    $this->site->setPurchaseItem($clause, $item['quantity']);
                    $this->site->syncQuantity(null, null, null, $item['product_id']);
                } elseif ($item['product_type'] == 'combo') {
                    $combo_items = $this->site->getProductComboItems($item['product_id']);
                    foreach ($combo_items as $combo_item) {
                        $clause = ['product_id' => $combo_item->id, 'purchase_id' => null, 'transfer_id' => null, 'option_id' => null];
                        $this->site->setPurchaseItem($clause, ($combo_item->qty*$item['quantity']));
                        $this->site->syncQuantity(null, null, null, $combo_item->id);
                    }
                }
            }
            return true;
        }

        return false;
    }

    public function resetSaleActions($id)
    {
        if ($items = $this->getReturnItems($id)) {
            foreach ($items as $item) {
                if ($item->product_type == 'standard') {
                    $clause = ['product_id' => $item->product_id, 'purchase_id' => null, 'transfer_id' => null, 'option_id' => $item->option_id];
                    $this->site->setPurchaseItem($clause, (0-$item->quantity));
                    $this->site->syncQuantity(null, null, null, $item->product_id);
                } elseif ($item->product_type == 'combo') {
                    $combo_items = $this->site->getProductComboItems($item->product_id);
                    foreach ($combo_items as $combo_item) {
                        $clause = ['product_id' => $combo_item->id, 'purchase_id' => null, 'transfer_id' => null, 'option_id' => null];
                        $this->site->setPurchaseItem($clause, (0-($combo_item->qty*$item->quantity)));
                        $this->site->syncQuantity(null, null, null, $combo_item->id);
                    }
                }
            }
        }
    }

    public function deleteReturn($id)
    {
        $this->resetSaleActions($id);
        if ($this->db->delete('return_items', array('return_id' => $id)) && $this->db->delete('returns', array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function getProductOptions($product_id)
    {
        $q = $this->db->get_where('product_variants', array('product_id' => $product_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductOptionByID($id)
    {
        $q = $this->db->get_where('product_variants', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
}
