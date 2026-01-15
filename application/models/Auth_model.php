<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function authenticate($email, $password) {
        $query = $this->db->get_where('users', array('email' => $email));
        $user = $query->row();
        if ($user && isset($user->password) && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
}
