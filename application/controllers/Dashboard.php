<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Karyawan');
    }
    
    public function index()
    {
        $data['title']          = 'Dashboard';
        $data['jumlahKaryawan'] = $this->Model_Karyawan->getJumlahKaryawan();
        $data['jumlahDivisi']   = $this->Model_Karyawan->getJumlahDivisi();
        $data['jumlahUnit']     = $this->Model_Karyawan->getJumlahUnit();
        $data['jumlahUser']     = $this->Model_Karyawan->getJumlahUser();
        $data['user']           = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('karyawan/dashboard', $data);
        $this->load->view('templates/footer');
    }
}