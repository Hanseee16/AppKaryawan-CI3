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
            // Periksa keberadaan nama divisi sebelum menambahkannya
            $nama_divisi = $this->input->post('nama_divisi');
            $is_duplicate = $this->Model_divisi->cekNamaDivisiDuplikat($nama_divisi);
        
            if ($is_duplicate) {
                $this->session->set_flashdata('flash',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Nama divisi sudah ada, silakan pilih nama divisi lain
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('divisi/tambah_divisi');
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
            
            $divisi_lama = $this->Model_divisi->getDivisiById($id_divisi);

            if ($this->cekData($divisi_lama, $this->input->post())) {
                $this->Model_divisi->editDataDivisi($id_divisi);
                $this->session->set_flashdata('flash', 
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data divisi <strong>berhasil</strong> diubah
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('divisi');
            } else {
                $this->session->set_flashdata('flash', 
                    '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Tidak ada perubahan yang dilakukan
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
                redirect('divisi');
            }
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
    
    // rules tambah data
    public function rulesDivisi()
    {
        $this->form_validation->set_rules('nama_divisi', 'Nama Divisi', 'required', [
            'required'   => '%s belum diisi'
        ]);
    }

    // export data karyawan
    public function exportData()
    {
        $data['title'] = 'Data Divisi';
        $data['divisi'] = $this->Model_divisi->exportDataDivisi();
        $this->load->view('excel/data_divisi', $data);
    }

    // import data divisi
    public function importData()
    {
        $config['upload_path']   = './import_excel/divisi/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name']     = 'doc' . time();
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('importexcel')) {
            
            // jika tidak ada file yang pilih
            $this->session->set_flashdata('flash',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Import data <strong>gagal,</strong> tidak ada file yang pilih
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
            redirect('karyawan/data_karyawan');
        }
    
        $file   = $this->upload->data();
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open('./import_excel/divisi/' . $file['file_name']);
    
        foreach ($reader->getSheetIterator() as $sheet) {
            $numRow = 1;
        
            foreach ($sheet->getRowIterator() as $row) {
                if ($numRow > 1) {
                
                    $nama_divisi  = $row->getCellAtIndex(0)->getValue();
                
                    // jika terdapat data yang duplikat
                    $cek_duplikat = $this->Model_divisi->cek_duplikat($nama_divisi);
                
                    if ($cek_duplikat) {
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
                        'nama_divisi' => $row->getCellAtIndex(0),
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
}