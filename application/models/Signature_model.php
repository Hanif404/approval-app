<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signature_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        return $this->db->order_by('sort_order', 'ASC')->get('signatures')->result();
    }

    public function get($id) {
        return $this->db->get_where('signatures', ['id' => $id])->row();
    }

    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('signatures', $data);
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('signatures', $data);
    }

    public function delete($id) {
        return $this->db->delete('signatures', ['id' => $id]);
    }
}
