<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_flows extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Approval_flow_model', 'Role_model', 'User_model'));
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
        $data['flows'] = $this->Approval_flow_model->get_all_flows();
        $this->load->view('approval_flows/list', $data);
    }

    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('form_type', 'Form Type', 'required|max_length[50]');
            $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');
            $this->form_validation->set_rules('step_order', 'Step Order', 'required|numeric');

            if ($this->form_validation->run()) {
                $data = array(
                    'form_type' => $this->input->post('form_type'),
                    'role_id' => $this->input->post('role_id'),
                    'step_order' => $this->input->post('step_order')
                );

                if ($this->Approval_flow_model->create_flow($data)) {
                    $this->session->set_flashdata('success', 'Approval flow created successfully');
                    redirect('approval_flows');
                } else {
                    $this->session->set_flashdata('error', 'Failed to create approval flow');
                }
            }
        }
        $data['roles'] = $this->Role_model->get_all_roles();
        $this->load->view('approval_flows/create', $data);
    }

    public function edit($id) {
        $data['flow'] = $this->Approval_flow_model->get_flow($id);
        if (!$data['flow']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('form_type', 'Form Type', 'required|max_length[50]');
            $this->form_validation->set_rules('role_id', 'Role', 'required|numeric');
            $this->form_validation->set_rules('step_order', 'Step Order', 'required|numeric');

            if ($this->form_validation->run()) {
                $update_data = array(
                    'form_type' => $this->input->post('form_type'),
                    'role_id' => $this->input->post('role_id'),
                    'step_order' => $this->input->post('step_order')
                );

                if ($this->Approval_flow_model->update_flow($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Approval flow updated successfully');
                    redirect('approval_flows');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update approval flow');
                }
            }
        }

        $data['roles'] = $this->Role_model->get_all_roles();
        $this->load->view('approval_flows/edit', $data);
    }

    public function delete($id) {
        $flow = $this->Approval_flow_model->get_flow($id);
        if (!$flow) {
            show_404();
        }

        if ($this->Approval_flow_model->delete_flow($id)) {
            $this->session->set_flashdata('success', 'Approval flow deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete approval flow');
        }
        redirect('approval_flows');
    }
}
