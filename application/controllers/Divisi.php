<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Divisi extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_divisi');
    }

    // view data divisi
    public function index()
    {
        $data['title']  = 'Data Divisi';
        $data['divisi'] = $this->Model_divisi->getAllDivisi();
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('divisi/data_divisi', $data);
        $this->load->view('templates/footer');
    }

    // tambah data divisi
    public function tambah_divisi()
    {
        $data['title'] = 'Tambah Divisi';
        $data['user']  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
        $this->rulesDivisi();
    
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('divisi/tambah_divisi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Model_divisi->tambahDataDivisi($data);
            $this->session->set_flashdata('flash',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data divisi <strong>berhasil</strong> ditambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('divisi');
        }
    }

    // edit data divisi
    public function editData($id_divisi)
    {
        $data['title']  = 'Edit Data Divisi';
        $data['divisi'] = $this->Model_divisi->getDivisiById($id_divisi);
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->rulesDivisi();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('divisi/edit_divisi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Model_divisi->editDataDivisi($id_divisi);
            $this->session->set_flashdata('flash', 
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data divisi <strong>berhasil</strong> diubah
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('divisi');
        }
    }

    // kondisi data baru dan data lama
    private function cekData($data_lama, $data_baru)
    {
        return $data_lama['nama_divisi'] != $data_baru['nama_divisi'];    
    }

    // hapus data divisi
    public function hapusData($id_divisi)
    {
        $this->Model_divisi->hapusDataDivisi($id_divisi);
        $this->session->set_flashdata('flash', 
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data divisi <strong>berhasil</strong> dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('divisi');
    }

    // export data
    public function exportData()
    {
        $data['title']  = 'Data Divisi';
        $data['divisi'] = $this->Model_divisi->exportDataDivisi();
        $this->load->view('excel/data_divisi', $data);
    }

    // import data
    public function importData()
    {
        $config['upload_path']   = './import_excel/divisi/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name']     = 'doc' . time();
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('importexcel')) {
            $this->session->set_flashdata('flash',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Import data <strong>gagal,</strong> tidak ada file yang pilih
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('divisi');
        }
    
        $file   = $this->upload->data();
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open('./import_excel/divisi/' . $file['file_name']);
    
        foreach ($reader->getSheetIterator() as $sheet) {
            $numRow = 1;
        
            foreach ($sheet->getRowIterator() as $row) {
                if ($numRow > 1) {
                
                    $nama_divisi = $row->getCellAtIndex(0)->getValue();
                    $cekDuplikat = $this->Model_divisi->cekDuplikat($nama_divisi);
                
                    if ($cekDuplikat) {
                        $this->session->set_flashdata('flash',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Import data <strong>gagal,</strong> terdapat data yang duplikat
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>');
                        redirect('divisi');
                    }
                
                    $data = array(
                        'nama_divisi' => htmlspecialchars($row->getCellAtIndex(0)),
                    );
                
                    $this->Model_divisi->importDataExcel($data);
                }
                $numRow++;
            }
        
            $reader->close();
            unlink('./import_excel/divisi/' . $file['file_name']);
        
            // jika data valid
            $this->session->set_flashdata('flash',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Import data <strong>berhasil</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('divisi');
        }
    }

    // download template
    public function downloadFile()
    {
        $file_path = 'template_excel/template_divisi.xlsx';
        $file_name = 'template_divisi.xlsx';        
        force_download($file_path, NULL);
    }

     // rules tambah data
     public function rulesDivisi()
     {
         $this->form_validation->set_rules('nama_divisi', 'Nama Divisi', 'required|is_unique[divisi.nama_divisi]', [
             'required'   => '%s belum diisi',
             'is_unique'  => '%s sudah sudah ada'
         ]);
     }
}