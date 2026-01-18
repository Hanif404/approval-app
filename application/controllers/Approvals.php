<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvals extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array(
            'Form_model', 'Role_model', 
            'User_model','Form_detail_model',
            'Form_file_model', 'Approval_model','Approval_flow_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
    }

    public function get_user_role() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            return null;
        }
        $roleUser = $this->User_model->get_user_with_roles($user_id);
        $roleArr = [];
        if (is_array($roleUser->roles) && count($roleUser->roles) > 0) {
            foreach ($roleUser->roles as $role) {
                $roleArr[] = $role->id;
            }
        }
        return $roleArr;
    }

    public function index() {
        $role = $this->get_user_role();
        $submission_date_from = $this->input->get('submission_date_from');
        $submission_date_to = $this->input->get('submission_date_to');
        
        $data['forms'] = $this->Form_model->get_forms_for_approval_flow($role, $submission_date_from, $submission_date_to);
        $data['submission_date_from'] = $submission_date_from;
        $data['submission_date_to'] = $submission_date_to;
        $this->load->view('approvals/list', $data);
    }

    public function view($id) {
        $role = $this->get_user_role();
        $data['form'] = $this->Form_model->get_form_approval_flow($id, $role);
        if (!$data['form']) {
            show_404();
        }

        $data['details'] = $this->Form_detail_model->get_details($id);
        $data['files'] = $this->Form_file_model->get_files($id);
        $data['total_amount'] = $this->Form_detail_model->get_total_amount($id);
        $this->load->view('approvals/view', $data);
    }

    public function approve($id) {
        $role = $this->get_user_role();
        $this->Approval_model->update_approval($id, $role, array(
            'status' => 'approved', 
            'user_id' => $this->session->userdata('user_id'), 
            'approved_at' => date('Y-m-d H:i:s')
        ));
        //create next approval flow
        $current_step = $this->check_user_role_step_order();
        $approval_flow = $this->Approval_flow_model->get_flows_by_type('general');
        if (count($approval_flow) > 0) {
            $isNext = false;
            foreach ($approval_flow as $flow) {
                $next_step = $current_step + 1;
                if ($flow->step_order == $next_step) {
                    $isNext = true;
                    $approvalData = array(
                        'form_id' => $id,
                        'role_id' => $flow->role_id,
                        'user_id' => null,
                        'status' => 'pending'
                    );
                    $this->Approval_model->create_approval($approvalData);
                    break;
                }
            }

            if (!$isNext) {
                //all steps completed, mark form as approved
                $this->Form_model->update_status($id, 'approved');
            }
        }
        $this->session->set_flashdata('success', 'Form approved successfully.');
        redirect('approvals/view/' . $id);
    }

    public function reject($id) {
        $role = $this->get_user_role();
        $rejection_reason = $this->input->post('rejection_reason');
        
        $this->Approval_model->update_approval($id, $role, array(
            'status' => 'rejected', 
            'user_id' => $this->session->userdata('user_id'), 
            'approved_at' => date('Y-m-d H:i:s'),
            'note' => $rejection_reason
        ));
        
        // Mark form as rejected
        $this->Form_model->update_status($id, 'rejected');
        
        $this->session->set_flashdata('success', 'Form rejected successfully.');
        redirect('approvals/view/' . $id);
    }

    public function check_user_role_step_order() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            return null;
        }
        
        $role = $this->get_user_role();
        $approval_flow = $this->Approval_flow_model->get_flows_by_role('general', $role);
        if (count($approval_flow) > 0) {
            return $approval_flow[0]->step_order;
        }
        
        return 0;
    }

    public function logs($id) {
        $data['approvals'] = $this->Approval_model->get_approval_by_form_id($id);
        $data['id'] = $id;
        $this->load->view('approvals/log', $data);
    }
}