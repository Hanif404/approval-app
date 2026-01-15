<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_users() {
        $this->db->select('u.*, GROUP_CONCAT(r.name) as roles');
        $this->db->from('users u');
        $this->db->join('user_roles ur', 'u.id = ur.user_id', 'left');
        $this->db->join('roles r', 'ur.role_id = r.id', 'left');
        $this->db->group_by('u.id');
        return $this->db->get()->result();
    }

    public function get_user($id) {
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    public function get_user_with_roles($id) {
        $user = $this->get_user($id);
        if ($user) {
            $user->roles = $this->get_user_roles($id);
        }
        return $user;
    }

    public function get_user_roles($user_id) {
        $this->db->select('r.*');
        $this->db->from('roles r');
        $this->db->join('user_roles ur', 'r.id = ur.role_id');
        $this->db->where('ur.user_id', $user_id);
        return $this->db->get()->result();
    }

    public function create_user($data) {
        $roles = isset($data['roles']) ? $data['roles'] : array();
        unset($data['roles']);
        
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        
        if ($this->db->insert('users', $data)) {
            $user_id = $this->db->insert_id();
            $this->assign_user_roles($user_id, $roles);
            return true;
        }
        return false;
    }

    public function update_user($id, $data) {
        $roles = isset($data['roles']) ? $data['roles'] : array();
        unset($data['roles']);
        
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        
        if ($this->db->update('users', $data)) {
            $this->assign_user_roles($id, $roles);
            return true;
        }
        return false;
    }

    public function delete_user($id) {
        return $this->db->delete('users', array('id' => $id));
    }

    public function email_exists($email, $exclude_id = null) {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get('users')->num_rows() > 0;
    }

    public function assign_user_roles($user_id, $role_ids) {
        // Remove existing roles
        $this->db->delete('user_roles', array('user_id' => $user_id));
        
        // Add new roles
        if (!empty($role_ids)) {
            foreach ($role_ids as $role_id) {
                $this->db->insert('user_roles', array(
                    'user_id' => $user_id,
                    'role_id' => $role_id
                ));
            }
        }
    }
}