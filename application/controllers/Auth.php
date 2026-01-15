<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->helper('url');
    }

    public function login() {
        if ($this->session->userdata('user_id')) {
            redirect('');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/login');
            return;
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->Auth_model->authenticate($email, $password);
        if ($user) {
            $this->session->set_userdata(array(
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => isset($user->name) ? $user->name : $user->email,
            ));
            redirect('');
        }

        $data['error'] = 'Invalid email or password';
        $this->load->view('templates/login', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
