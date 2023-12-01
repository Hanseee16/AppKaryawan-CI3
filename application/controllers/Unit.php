<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_unit');
       
    }

    // view data unit
    public function index()
    {
        $data['title'] = 'Data Unit';
        $data['user']  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('unit/data_unit', $data);
        $this->load->view('templates/footer');
    }
}