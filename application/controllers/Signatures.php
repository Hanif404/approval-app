<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signatures extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('User_model', 'Signature_model'));
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation', 'session']);
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

    private function check_auth() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    private function json($data, $code = 200) {
        $this->output->set_status_header($code)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    // ── Web CRUD ──────────────────────────────────────────────

    public function index() {
        $this->check_auth();
        $data['signatures'] = $this->Signature_model->get_all();
        $title = 'Signatures'; $page_title = 'Tanda Tangan';
        ob_start();
        $this->load->view('signatures/list', $data);
        $content = ob_get_clean();
        $this->load->view('templates/layout', compact('title', 'page_title', 'content'));
    }

    public function create() {
        $this->check_auth();
        if ($this->input->post()) {
            $this->form_validation->set_rules('label', 'Label', 'required|max_length[100]');
            $this->form_validation->set_rules('name', 'Nama', 'required|max_length[150]');
            if ($this->form_validation->run()) {
                $image_path = $this->_upload_image();
                $this->Signature_model->create([
                    'label'      => $this->input->post('label'),
                    'name'       => $this->input->post('name'),
                    // 'position'   => $this->input->post('position'),
                    // 'image_path' => $image_path,
                    'sort_order' => (int)$this->input->post('sort_order'),
                ]);
                $this->session->set_flashdata('success', 'Tanda tangan berhasil ditambahkan');
                redirect('signatures');
            }
        }
        $title = 'Tambah Tanda Tangan'; $page_title = 'Tambah Tanda Tangan';
        ob_start();
        $this->load->view('signatures/form', ['signature' => null]);
        $content = ob_get_clean();
        $this->load->view('templates/layout', compact('title', 'page_title', 'content'));
    }

    public function edit($id) {
        $this->check_auth();
        $data['signature'] = $this->Signature_model->get($id);
        if (!$data['signature']) show_404();

        if ($this->input->post()) {
            $this->form_validation->set_rules('label', 'Label', 'required|max_length[100]');
            $this->form_validation->set_rules('name', 'Nama', 'required|max_length[150]');
            if ($this->form_validation->run()) {
                $update = [
                    'label'      => $this->input->post('label'),
                    'name'       => $this->input->post('name'),
                    // 'position'   => $this->input->post('position'),
                    'sort_order' => (int)$this->input->post('sort_order'),
                ];
                // $image_path = $this->_upload_image();
                // if ($image_path) {
                //     // delete old image
                //     if ($data['signature']->image_path && file_exists(FCPATH . 'uploads/signatures/' . $data['signature']->image_path)) {
                //         unlink(FCPATH . 'uploads/signatures/' . $data['signature']->image_path);
                //     }
                //     $update['image_path'] = $image_path;
                // }
                $this->Signature_model->update($id, $update);
                $this->session->set_flashdata('success', 'Tanda tangan berhasil diperbarui');
                redirect('signatures');
            }
        }
        $title = 'Edit Tanda Tangan'; $page_title = 'Edit Tanda Tangan';
        ob_start();
        $this->load->view('signatures/form', $data);
        $content = ob_get_clean();
        $this->load->view('templates/layout', compact('title', 'page_title', 'content'));
    }

    public function delete($id) {
        $this->check_auth();
        $sig = $this->Signature_model->get($id);
        if ($sig && $sig->image_path && file_exists(FCPATH . 'uploads/signatures/' . $sig->image_path)) {
            unlink(FCPATH . 'uploads/signatures/' . $sig->image_path);
        }
        $this->Signature_model->delete($id);
        $this->session->set_flashdata('success', 'Tanda tangan berhasil dihapus');
        redirect('signatures');
    }

    // ── Helper ────────────────────────────────────────────────

    private function _upload_image() {
        if (empty($_FILES['image']['name'])) return null;
        $upload_path = FCPATH . 'uploads/signatures/';
        if (!is_dir($upload_path)) mkdir($upload_path, 0755, true);
        $this->load->library('upload', [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size'      => 2048,
            'file_name'     => md5(uniqid()),
        ]);
        if ($this->upload->do_upload('image')) {
            return $this->upload->data('file_name');
        }
        return null;
    }
}
