<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

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
        $data['unit']  = $this->Model_unit->getAllUnit();
        $data['user']  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('unit/data_unit', $data);
        $this->load->view('templates/footer');
    }

    public function tambahData()
    {
        $data['title'] = 'Tambah Unit';
        $data['user']  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
        $this->rulesUnit();
    
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('unit/tambahData', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Model_unit->tambahDataUnit($data);
            $this->session->set_flashdata('flash',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data unit <strong>berhasil</strong> ditambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('unit');
        }
    }

    // edit data
    public function editData($id_unit)
    {
        $data['title']  = 'Edit Data Unit';
        $data['unit']   = $this->Model_unit->getUnitById($id_unit);
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->rulesUnit();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('unit/editData', $data);
            $this->load->view('templates/footer');
        } else {
            $unit_lama = $this->Model_unit->getUnitById($id_unit);

            if ($this->cekData($unit_lama, $this->input->post())) {
                $this->Model_unit->editDataUnit($id_unit);
                $this->session->set_flashdata('flash', 
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data unit <strong>berhasil</strong> diubah
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('unit');
            } else {
                $this->session->set_flashdata('flash', 
                    '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Tidak ada perubahan yang dilakukan
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('unit');
            }
        }
    }

    // cek jika ada atau tidak nya perubahan pada data
    private function cekData($data_lama, $data_baru)
    {
        return $data_lama['nama_unit'] != $data_baru['nama_unit'];    
    }

    // hapus data
    public function hapusData($id_unit)
    {
        $this->Model_unit->hapusDataUnit($id_unit);
        $this->session->set_flashdata('flash', 
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data unit <strong>berhasil</strong> dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('unit');
    }

    // export data
    public function exportData()
    {
        $data['title']  = 'Data Unit';
        $data['unit']   = $this->Model_unit->exportDataUnit();
        $this->load->view('excel/data_unit', $data);
    }

     // rules
     public function rulesUnit()
     {
         $this->form_validation->set_rules('nama_unit', 'Nama Unit', 'required|is_unique[unit.nama_unit]', [
             'required'   => '%s belum diisi',
             'is_unique'  => '%s sudah sudah ada'
         ]);
     }
}