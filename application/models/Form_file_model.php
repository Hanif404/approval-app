<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_file_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_files($form_id) {
        $this->db->select('ff.*, u.name as uploaded_by_name');
        $this->db->from('form_files ff');
        $this->db->join('users u', 'ff.uploaded_by = u.id', 'left');
        $this->db->where('ff.form_id', $form_id);
        $this->db->order_by('ff.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_file($id) {
        $this->db->select('ff.*, u.name as uploaded_by_name');
        $this->db->from('form_files ff');
        $this->db->join('users u', 'ff.uploaded_by = u.id', 'left');
        $this->db->where('ff.id', $id);
        return $this->db->get()->row();
    }

    public function upload_file($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('form_files', $data) ? $this->db->insert_id() : false;
    }

    public function delete_file($id) {
        $file = $this->get_file($id);
        if ($file && file_exists($file->file_path)) {
            unlink($file->file_path);
        }
        return $this->db->delete('form_files', array('id' => $id));
    }
}