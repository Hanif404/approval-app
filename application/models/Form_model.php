<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_forms($user_id = null, $submission_date_from = null, $submission_date_to = null, $filter_staff = true, $filter_slip = false) {
        $this->db->select('f.*, u.name as created_by_name');
        $this->db->from('forms f');
        $this->db->join('users u', 'f.created_by = u.id', 'left');
        if ($user_id && $filter_staff) {
            $this->db->where('f.created_by', $user_id);
        }
        if($filter_slip){
            $this->db->where('f.status', 'approved');
        }
        if ($submission_date_from) {
            $this->db->where('f.submission_date >=', $submission_date_from . ' 00:00:00');
        }
        if ($submission_date_to) {
            $this->db->where('f.submission_date <=', $submission_date_to . ' 23:59:59');
        }
        $this->db->order_by('f.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_form($id) {
        $this->db->select('f.*, u.name as created_by_name');
        $this->db->from('forms f');
        $this->db->join('users u', 'f.created_by = u.id', 'left');
        $this->db->where('f.id', $id);
        return $this->db->get()->row();
    }

    public function create_form($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('forms', $data) ? $this->db->insert_id() : false;
    }

    public function update_form($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('forms', $data);
    }

    public function delete_form($id) {
        $this->db->where('id', $id);
        return $this->db->delete('forms');
    }

    public function update_status($id, $status) {
        return $this->update_form($id, array('status' => $status));
    }

    public function get_forms_for_approval_flow($role_ids, $submission_date_from = null, $submission_date_to = null, $status = null) {
        // Subquery: ambil cycle tertinggi per form_id dari approvals yang role-nya sesuai
        $role_ids_escaped = implode(',', array_map(function($r) { return (int)$r; }, $role_ids));

        // approval_status: status dari cycle tertinggi yang non-pending,
        // jika tidak ada (semua masih pending), fallback ke 'rejected'
        $status_subquery = "(
            SELECT COALESCE(
                (SELECT a2.status
                 FROM approvals a2
                 WHERE a2.form_id = f.id
                   AND a2.role_id IN ($role_ids_escaped)
                   AND a2.cycle = mc.cycle_number
                 ORDER BY a2.cycle DESC, a2.created_at DESC
                 LIMIT 1),
                'rejected'
            )
        )";

        $this->db->select("f.*, u.name as created_by_name, $status_subquery AS approval_status", false);
        $this->db->from('forms f');
        $this->db->join('users u', 'f.created_by = u.id', 'left');
        $this->db->join("(SELECT form_id, MAX(cycle) as cycle_number FROM approvals GROUP BY form_id) mc", 'mc.form_id = f.id', 'left');

        // Hanya tampilkan form yang memang punya approval untuk role ini
        $this->db->where("EXISTS (
            SELECT 1 FROM approvals ax
            WHERE ax.form_id = f.id
              AND ax.role_id IN ($role_ids_escaped)
        )", null, false);

        if ($status != null && $status != 'all') {
            $this->db->having('approval_status', $status);
        }
        if ($submission_date_from) {
            $this->db->where('f.submission_date >=', $submission_date_from . ' 00:00:00');
        }
        if ($submission_date_to) {
            $this->db->where('f.submission_date <=', $submission_date_to . ' 23:59:59');
        }
        $this->db->order_by('f.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // public function get_forms_for_approval_flow($role_ids, $submission_date_from = null, $submission_date_to = null, $status = null, $spesific = 0, $user_id) {
    //     $this->db->select('f.*, u.name as created_by_name, a.status as approval_status');
    //     $this->db->from('forms f');
    //     $this->db->join('users u', 'f.created_by = u.id', 'left');

    //     if ($spesific > 0) {
    //         $this->db->join(
    //             'approvals a',
    //             'f.id = a.form_id AND a.user_id = ' . $this->db->escape($user_id),
    //             'left'
    //         );
    //     } else {
    //         $this->db->join(
    //             'approvals a',
    //             'f.id = a.form_id',
    //             'left'
    //         );
    //         $this->db->where('a.user_id', NULL);
    //         $this->db->where_in('a.role_id', $role_ids);
    //     }
        
    //     if ($status != null && $status != 'all') {
    //         $this->db->where('a.status', $status);
    //     }
    //     if ($submission_date_from) {
    //         $this->db->where('f.submission_date >=', $submission_date_from . ' 00:00:00');
    //     }
    //     if ($submission_date_to) {
    //         $this->db->where('f.submission_date <=', $submission_date_to . ' 23:59:59');
    //     }
    //     $this->db->order_by('f.created_at', 'DESC');
    //     return $this->db->get()->result();
    // }

    public function get_form_approval_flow($id, $role_ids) {
        $role_ids_escaped = implode(',', array_map(function($r) { return (int)$r; }, $role_ids));

        // approval_status: status dari cycle tertinggi yang non-pending,
        // jika tidak ada (semua masih pending), fallback ke 'rejected'
        $status_subquery = "(
            SELECT COALESCE(
                (SELECT a2.status
                 FROM approvals a2
                 WHERE a2.form_id = f.id
                   AND a2.role_id IN ($role_ids_escaped)
                   AND a2.cycle = mc.cycle_number
                 ORDER BY a2.cycle DESC, a2.created_at DESC
                 LIMIT 1),
                'rejected'
            )
        )";

        $this->db->select("f.*, u.name as created_by_name, $status_subquery AS approval_status", false);
        $this->db->from('forms f');
        $this->db->join('users u', 'f.created_by = u.id', 'left');
        $this->db->join("(SELECT form_id, MAX(cycle) as cycle_number FROM approvals GROUP BY form_id) mc", 'mc.form_id = f.id', 'left');
        $this->db->where('f.id', $id);
        return $this->db->get()->row();
    }
}