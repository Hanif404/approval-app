<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_cao($date_from = null, $date_to = null) {
        $this->db->select('c.*, u.name as created_by_name, (SELECT SUM(fd.total_amount) FROM form_details fd WHERE fd.form_id = c.id) as total_amount');
        $this->db->from('forms c');
        $this->db->join('users u', 'c.created_by = u.id', 'left');
        if ($date_from) {
            $this->db->where('c.submission_date >=', $date_from);
        }
        if ($date_to) {
            $this->db->where('c.submission_date <=', $date_to);
        }
        $this->db->order_by('c.submission_date', 'DESC');
        return $this->db->get()->result();
    }
}
