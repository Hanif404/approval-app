<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_flow_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_flows() {
        $this->db->select('af.*, r.name as role_name');
        $this->db->from('approval_flows af');
        $this->db->join('roles r', 'af.role_id = r.id', 'left');
        $this->db->order_by('af.form_type, af.step_order');
        return $this->db->get()->result();
    }

    public function get_flow($id) {
        $this->db->select('af.*, r.name as role_name');
        $this->db->from('approval_flows af');
        $this->db->join('roles r', 'af.role_id = r.id', 'left');
        $this->db->where('af.id', $id);
        return $this->db->get()->row();
    }

    public function get_flows_by_type($form_type) {
        $this->db->select('af.*, r.name as role_name');
        $this->db->from('approval_flows af');
        $this->db->join('roles r', 'af.role_id = r.id', 'left');
        $this->db->where('af.form_type', $form_type);
        $this->db->order_by('af.step_order');
        return $this->db->get()->result();
    }

    public function get_flows_by_role($form_type, $role_ids) {
        $this->db->select('af.*, r.name as role_name');
        $this->db->from('approval_flows af');
        $this->db->join('roles r', 'af.role_id = r.id', 'left');
        $this->db->where('af.form_type', $form_type);
        $this->db->where_in('af.role_id', $role_ids);
        $this->db->order_by('af.step_order');
        return $this->db->get()->result();
    }

    public function create_flow($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('approval_flows', $data) ? $this->db->insert_id() : false;
    }

    public function update_flow($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('approval_flows', $data);
    }

    public function delete_flow($id) {
        return $this->db->delete('approval_flows', array('id' => $id));
    }
}
