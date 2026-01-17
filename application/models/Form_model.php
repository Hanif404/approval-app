<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_forms($user_id = null) {
        $this->db->select('f.*, u.name as created_by_name');
        $this->db->from('forms f');
        $this->db->join('users u', 'f.created_by = u.id', 'left');
        if ($user_id) {
            $this->db->where('f.created_by', $user_id);
        }
        $this->db->order_by('f.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_form($id) {
        $this->db->select('f.*, u.name as created_by_name');
        $this->db->from('forms f');
        $this->db->join('users u', 'f.created_by = u.id', 'left');
        $this->db->where('f.id', $id);
        return $this->db->get()->row();
    }

    public function create_form($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('forms', $data) ? $this->db->insert_id() : false;
    }

    public function update_form($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('forms', $data);
    }

    public function delete_form($id) {
        $this->db->where('id', $id);
        return $this->db->delete('forms');
    }

    public function update_status($id, $status) {
        return $this->update_form($id, array('status' => $status));
    }

    public function get_forms_for_approval_flow($role_ids) {
        $this->db->select('f.*, u.name as created_by_name, a.status as approval_status');
        $this->db->from('forms f');
        $this->db->join('users u', 'f.created_by = u.id', 'left');
        $this->db->join('approvals a', 'f.id = a.form_id', 'left');
        $this->db->where('a.status', 'pending');
        $this->db->where_in('a.role_id', $role_ids);
        $this->db->order_by('f.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_form_approval_flow($id, $role_ids) {
        $this->db->select('f.*, u.name as created_by_name, a.status as approval_status');
        $this->db->from('forms f');
        $this->db->join('users u', 'f.created_by = u.id', 'left');
        $this->db->join('approvals a', 'f.id = a.form_id', 'left');
        $this->db->where_in('a.role_id', $role_ids);
        $this->db->where('f.id', $id);
        return $this->db->get()->row();
    }
}