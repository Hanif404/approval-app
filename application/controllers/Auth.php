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

    public function forgot_password() {
        if ($this->session->userdata('user_id')) {
            redirect('');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/forgot_password');
            return;
        }

        $email = $this->input->post('email');
        $this->load->model('User_model');
        $user = $this->User_model->get_user_by_email($email);

        if (!$user) {
            $data['error'] = 'Email not found';
            $this->load->view('templates/forgot_password', $data);
            return;
        }

        $new_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        $this->User_model->update_password($user->id, $new_password);

        $this->load->library('email');
        $this->email->from('noreply@approvalapp.com', 'Approval App');
        $this->email->to($email);
        $this->email->subject('Password Reset');
        $this->email->message('Your new password is: ' . $new_password);

        if ($this->email->send()) {
            $data['success'] = 'New password sent to your email';
        } else {
            $data['error'] = 'Failed to send email. Please contact administrator.';
        }

        $this->load->view('templates/forgot_password', $data);
    }
}
