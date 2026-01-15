<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('User_model', 'Role_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
    }

    public function index() {
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('users/list', $data);
    }

    public function create() {
        $data['roles'] = $this->Role_model->get_all_roles();
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[100]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run()) {
                if ($this->User_model->email_exists($this->input->post('email'))) {
                    $this->session->set_flashdata('error', 'Email already exists');
                } else {
                    $user_data = array(
                        'name' => $this->input->post('name'),
                        'email' => $this->input->post('email'),
                        'password' => $this->input->post('password'),
                        'roles' => $this->input->post('roles') ?: array()
                    );
                    
                    if ($this->User_model->create_user($user_data)) {
                        $this->session->set_flashdata('success', 'User created successfully');
                        redirect('users');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to create user');
                    }
                }
            }
        }
        $this->load->view('users/create', $data);
    }

    public function edit($id) {
        $data['user'] = $this->User_model->get_user_with_roles($id);
        $data['roles'] = $this->Role_model->get_all_roles();
        
        if (!$data['user']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[100]');
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');

            if ($this->form_validation->run()) {
                if ($this->User_model->email_exists($this->input->post('email'), $id)) {
                    $this->session->set_flashdata('error', 'Email already exists');
                } else {
                    $update_data = array(
                        'name' => $this->input->post('name'),
                        'email' => $this->input->post('email'),
                        'roles' => $this->input->post('roles') ?: array()
                    );
                    
                    if ($this->input->post('password')) {
                        $update_data['password'] = $this->input->post('password');
                    }
                    
                    if ($this->User_model->update_user($id, $update_data)) {
                        $this->session->set_flashdata('success', 'User updated successfully');
                        redirect('users');
                    } else {
                        $this->session->set_flashdata('error', 'Failed to update user');
                    }
                }
            }
        }
        $this->load->view('users/edit', $data);
    }

    public function delete($id) {
        $user = $this->User_model->get_user($id);
        
        if (!$user) {
            show_404();
        }

        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user');
        }
        
        redirect('users');
    }

    public function view($id) {
        $data['user'] = $this->User_model->get_user_with_roles($id);
        
        if (!$data['user']) {
            show_404();
        }
        
        $this->load->view('users/view', $data);
    }
}