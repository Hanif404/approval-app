<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Role_model', 'User_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
        $this->check_admin();
    }

    private function check_admin() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        $user_roles = $this->User_model->get_user_roles($this->session->userdata('user_id'));
        $is_admin = false;
        foreach ($user_roles as $role) {
            if (strtolower($role->name) === 'admin') {
                $is_admin = true;
                break;
            }
        }
        
        if (!$is_admin) {
            $this->session->set_flashdata('error', 'Access denied. Admin role required.');
            redirect('');
        }
    }

    public function index() {
        $data['roles'] = $this->Role_model->get_all_roles();
        $this->load->view('roles/list', $data);
    }

    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');
            $this->form_validation->set_rules('description', 'Description', 'max_length[255]');

            if ($this->form_validation->run()) {
                if ($this->Role_model->role_name_exists($this->input->post('name'))) {
                    $this->session->set_flashdata('error', 'Role name already exists');
                } else {
                    $role_data = array(
                        'name' => $this->input->post('name'),
                        'description' => $this->input->post('description')
                    );
                    
                    if ($this->Role_model->create_role($role_data)) {
                        $this->session->set_flashdata('success', 'Role created successfully');
                        redirect('roles');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to create role');
                    }
                }
            }
        }
        $this->load->view('roles/create');
    }

    public function edit($id) {
        $data['role'] = $this->Role_model->get_role($id);
        
        if (!$data['role']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');
            $this->form_validation->set_rules('description', 'Description', 'max_length[255]');

            if ($this->form_validation->run()) {
                if ($this->Role_model->role_name_exists($this->input->post('name'), $id)) {
                    $this->session->set_flashdata('error', 'Role name already exists');
                } else {
                    $update_data = array(
                        'name' => $this->input->post('name'),
                        'description' => $this->input->post('description')
                    );
                    
                    if ($this->Role_model->update_role($id, $update_data)) {
                        $this->session->set_flashdata('success', 'Role updated successfully');
                        redirect('roles');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to update role');
                    }
                }
            }
        }
        $this->load->view('roles/edit', $data);
    }

    public function delete($id) {
        $role = $this->Role_model->get_role($id);
        
        if (!$role) {
            show_404();
        }

        if ($this->Role_model->delete_role($id)) {
            $this->session->set_flashdata('success', 'Role deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete role');
        }
        
        redirect('roles');
    }
}
