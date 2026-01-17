<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_approvals() {
        $this->db->select('a.id, a.form_id, a.status, a.note, a.approved_at, a.created_at, r.name as role_name, u.name as user_name, u.email');
        $this->db->from('approvals a');
        $this->db->join('roles r', 'a.role_id = r.id', 'left');
        $this->db->join('users u', 'a.user_id = u.id', 'left');
        $this->db->order_by('a.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_approval_by_id($id) {
        $this->db->select('a.*, r.name as role_name, u.name as user_name, u.email');
        $this->db->from('approvals a');
        $this->db->join('roles r', 'a.role_id = r.id', 'left');
        $this->db->join('users u', 'a.user_id = u.id', 'left');
        $this->db->where('a.id', $id);
        
        return $this->db->get()->row();
    }

    public function create_approval($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('approvals', $data);
    }

    public function update_approval($id, $roles, $data) {
        $this->db->where_in('role_id', $roles);
        return $this->db->update('approvals', $data, ['form_id' => $id, 'user_id' => null]);
    }

    public function delete_approval($id) {
        return $this->db->delete('approvals', ['id' => $id]);
    }

}