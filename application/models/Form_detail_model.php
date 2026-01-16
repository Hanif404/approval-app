<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_detail_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_details($form_id) {
        $this->db->where('form_id', $form_id);
        $this->db->order_by('id', 'ASC');
        return $this->db->get('form_details')->result();
    }

    public function get_detail($id) {
        return $this->db->get_where('form_details', array('id' => $id))->row();
    }

    public function create_detail($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('form_details', $data) ? $this->db->insert_id() : false;
    }

    public function update_detail($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('form_details', $data);
    }

    public function delete_detail($id) {
        return $this->db->delete('form_details', array('id' => $id));
    }

    public function get_total_amount($form_id) {
        $this->db->select_sum('total_amount');
        $this->db->where('form_id', $form_id);
        $result = $this->db->get('form_details')->row();
        return $result->total_amount ? $result->total_amount : 0;
    }
}