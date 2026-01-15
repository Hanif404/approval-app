<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_roles() {
        return $this->db->get('roles')->result();
    }

    public function get_role($id) {
        return $this->db->get_where('roles', array('id' => $id))->row();
    }

    public function create_role($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('roles', $data);
    }

    public function update_role($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('roles', $data);
    }

    public function delete_role($id) {
        return $this->db->delete('roles', array('id' => $id));
    }

    public function role_name_exists($name, $exclude_id = null) {
        $this->db->where('name', $name);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get('roles')->num_rows() > 0;
    }
}