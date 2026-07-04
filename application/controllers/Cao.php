<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cao extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
        $this->load->model(array('Cao_model', 'User_model', 'Signature_model'));
        $this->load->helper(array('form', 'url', 'download'));
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
            if (strtolower($role->name) != "pengaju") {
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
        $date_from = $this->input->get('date_from') ? $this->input->get('date_from') : date('Y-m-01');
        $date_to = $this->input->get('date_to') ? $this->input->get('date_to') : date('Y-m-t');
        
        $data['cao_forms'] = $this->Cao_model->get_all_cao($date_from, $date_to);
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
        $this->load->view('cao_reports/list', $data);
    }

    public function export_pdf() {
        $date_from = $this->input->get('date_from') ?: date('Y-m-01');
        $date_to   = $this->input->get('date_to')   ?: date('Y-m-t');

        $cao_forms  = $this->Cao_model->get_all_cao($date_from, $date_to);
        $signatures = $this->Signature_model->get_all();

        $this->load->library('Cao_report_pdf');
        $this->cao_report_pdf->generate($cao_forms, $signatures, $date_from, $date_to);
    }

    public function export_csv() {
        $date_from = $this->input->get('date_from') ? $this->input->get('date_from') : date('Y-m-01');
        $date_to = $this->input->get('date_to') ? $this->input->get('date_to') : date('Y-m-t');
        
        $cao_forms = $this->Cao_model->get_all_cao($date_from, $date_to);

        $filename = 'DATABASE_CAO_' . date('Ymd') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, array('DATABASE CAO', '', '', '', '', '', ''));
        fputcsv($output, array('PERIODE MULAI TANGGAL ' . $date_from . ' S/D ' . $date_to, '', '', '', '', '', ''));
        fputcsv($output, array('NO CAO', 'TANGGAL', 'NAMA PENERIMA', 'NO REKENING PENERIMA', 'JENIS TRANSAKSI', 'CAO PENGAJUAN', 'CAO TRANSAKSI'));
        
        foreach ($cao_forms as $cao) {
            fputcsv($output, array(
                $cao->cao_number,
                $cao->submission_date,
                $cao->payment_receiver_name,
                $cao->bank_account_number,
                $cao->transaction_type,
                $cao->created_by_name,
                $cao->total_amount,
            ));
        }
        
        fclose($output);
        exit;
    }
}
