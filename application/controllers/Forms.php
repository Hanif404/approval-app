<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }

        $this->load->model(array('Form_model', 'Form_detail_model', 'Form_file_model'));
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library(array('form_validation', 'session', 'upload'));
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['forms'] = $this->Form_model->get_all_forms($user_id);
        $this->load->view('forms/list', $data);
    }

    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|max_length[150]');
            $this->form_validation->set_rules('submission_date', 'Submission Date', 'required');
            $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'required|max_length[150]');

            if ($this->form_validation->run()) {
                $data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'submission_date' => $this->input->post('submission_date'),
                    'applicant_name' => $this->input->post('applicant_name'),
                    'cao_number' => $this->input->post('cao_number'),
                    'project_name' => $this->input->post('project_name'),
                    'payment_receiver_name' => $this->input->post('payment_receiver_name'),
                    'bank_account_number' => $this->input->post('bank_account_number'),
                    'bank_name' => $this->input->post('bank_name'),
                    'transaction_type' => $this->input->post('transaction_type'),
                    'created_by' => $this->session->userdata('user_id'),
                    'status' => 'draft'
                );

                $form_id = $this->Form_model->create_form($data);
                if ($form_id) {
                    $this->session->set_flashdata('success', 'Form created successfully');
                    redirect('forms/edit/' . $form_id);
                } else {
                    $this->session->set_flashdata('error', 'Failed to create form');
                }
            }
        }
        $this->load->view('forms/create');
    }

    public function edit($id) {
        $data['form'] = $this->Form_model->get_form($id);
        if (!$data['form']) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'required|max_length[150]');
            $this->form_validation->set_rules('submission_date', 'Submission Date', 'required');
            $this->form_validation->set_rules('applicant_name', 'Applicant Name', 'required|max_length[150]');

            if ($this->form_validation->run()) {
                $update_data = array(
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'submission_date' => $this->input->post('submission_date'),
                    'applicant_name' => $this->input->post('applicant_name'),
                    'cao_number' => $this->input->post('cao_number'),
                    'project_name' => $this->input->post('project_name'),
                    'payment_receiver_name' => $this->input->post('payment_receiver_name'),
                    'bank_account_number' => $this->input->post('bank_account_number'),
                    'bank_name' => $this->input->post('bank_name'),
                    'transaction_type' => $this->input->post('transaction_type')
                );

                if ($this->Form_model->update_form($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Form updated successfully');
                    redirect('forms/edit/' . $id);
                } else {
                    $this->session->set_flashdata('error', 'Failed to update form');
                }
            }
        }

        $data['details'] = $this->Form_detail_model->get_details($id);
        $data['files'] = $this->Form_file_model->get_files($id);
        $data['total_amount'] = $this->Form_detail_model->get_total_amount($id);
        $this->load->view('forms/edit', $data);
    }

    public function view($id) {
        $data['form'] = $this->Form_model->get_form($id);
        if (!$data['form']) {
            show_404();
        }

        $data['details'] = $this->Form_detail_model->get_details($id);
        $data['files'] = $this->Form_file_model->get_files($id);
        $data['total_amount'] = $this->Form_detail_model->get_total_amount($id);
        $this->load->view('forms/view', $data);
    }

    public function delete($id) {
        $form = $this->Form_model->get_form($id);
        if (!$form) {
            show_404();
        }

        if ($this->Form_model->delete_form($id)) {
            $this->session->set_flashdata('success', 'Form deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete form');
        }
        redirect('forms');
    }

    public function add_detail($form_id) {
        $form = $this->Form_model->get_form($form_id);
        if (!$form) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
            $this->form_validation->set_rules('unit_price', 'Unit Price', 'required|numeric');

            if ($this->form_validation->run()) {
                $quantity = (int)$this->input->post('quantity');
                $unit_price = (int)$this->input->post('unit_price');
                $total_amount = $quantity * $unit_price;

                $data = array(
                    'form_id' => $form_id,
                    'description' => $this->input->post('description'),
                    'work_area' => $this->input->post('work_area'),
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'total_amount' => $total_amount
                );

                if ($this->Form_detail_model->create_detail($data)) {
                    $this->session->set_flashdata('success', 'Detail added successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add detail');
                }
            }
        }
        redirect('forms/edit/' . $form_id);
    }

    public function edit_detail($detail_id, $form_id) {
        $detail = $this->Form_detail_model->get_detail($detail_id);
        if (!$detail) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required|numeric');
            $this->form_validation->set_rules('unit_price', 'Unit Price', 'required|numeric');

            if ($this->form_validation->run()) {
                $quantity = (int)$this->input->post('quantity');
                $unit_price = (int)$this->input->post('unit_price');
                $total_amount = $quantity * $unit_price;

                $data = array(
                    'description' => $this->input->post('description'),
                    'work_area' => $this->input->post('work_area'),
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'total_amount' => $total_amount
                );

                if ($this->Form_detail_model->update_detail($detail_id, $data)) {
                    $this->session->set_flashdata('success', 'Detail updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to update detail');
                }
            }
        }
        redirect('forms/edit/' . $form_id);
    }

    public function delete_detail($detail_id, $form_id) {
        $detail = $this->Form_detail_model->get_detail($detail_id);
        if (!$detail) {
            show_404();
        }

        if ($this->Form_detail_model->delete_detail($detail_id)) {
            $this->session->set_flashdata('success', 'Detail deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete detail');
        }
        redirect('forms/edit/' . $form_id);
    }

    public function upload_file($form_id) {
        $form = $this->Form_model->get_form($form_id);
        if (!$form) {
            show_404();
        }

        $config['upload_path'] = './uploads/forms/';
        $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|jpeg|png';
        $config['max_size'] = 5120;
        $config['encrypt_name'] = true;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        } else {
            $upload_data = $this->upload->data();
            $file_data = array(
                'form_id' => $form_id,
                'file_name' => $upload_data['orig_name'],
                'file_path' => $config['upload_path'] . $upload_data['file_name'],
                'uploaded_by' => $this->session->userdata('user_id')
            );

            if ($this->Form_file_model->upload_file($file_data)) {
                $this->session->set_flashdata('success', 'File uploaded successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to save file record');
            }
        }
        redirect('forms/edit/' . $form_id);
    }

    public function delete_file($file_id, $form_id) {
        $file = $this->Form_file_model->get_file($file_id);
        if (!$file) {
            show_404();
        }

        if ($this->Form_file_model->delete_file($file_id)) {
            $this->session->set_flashdata('success', 'File deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete file');
        }
        redirect('forms/edit/' . $form_id);
    }

    public function download_file($file_id) {
        $file = $this->Form_file_model->get_file($file_id);
        if (!$file || !file_exists($file->file_path)) {
            show_404();
        }

        $this->load->helper('download');
        force_download($file->file_path, null);
    }

    public function submit($id) {
        $form = $this->Form_model->get_form($id);
        if (!$form) {
            show_404();
        }

        $this->Form_model->update_form($id, array(
            'status' => 'submitted'
        ));
        $this->session->set_flashdata('success', 'Form updated successfully');
        redirect('forms');
    }
}