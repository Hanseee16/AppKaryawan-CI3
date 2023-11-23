<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Karyawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
        $this->load->model('Model_karyawan');
        $this->load->model('Model_serverside_karyawan');
        $this->load->model('Model_serverside_gaji');
    }

    // view halaman index atau dashboard
    public function index()
    {
        $data['title']          = 'Dashboard';
        $data['jumlahKaryawan'] = $this->Model_karyawan->getJumlahKaryawan();
        $data['jumlahGaji']     = $this->Model_karyawan->getJumlahDataGaji();
        $data['jumlahDivisi']   = $this->Model_karyawan->getJumlahDivisi();
        $data['jumlahUnit']     = $this->Model_karyawan->getJumlahUnit();
        $data['user']           = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('karyawan/dashboard', $data);
        $this->load->view('templates/footer');
    }

    // view data karyawan
    public function data_karyawan()
    {
        $data['title'] = 'Data Karyawan';
        $data['user']  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('karyawan/data_karyawan', $data);
        $this->load->view('templates/footer');
    }

    // view data gaji karyawan
    public function data_gaji()
    {
        $data['title'] = 'Data Gaji Karyawan';
        $data['user']  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('karyawan/data_gaji', $data);
        $this->load->view('templates/footer');
    }

    // rules tambah data
    public function rulesTambahKaryawan()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required'   => '%s belum diisi'
        ]);
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[8]|max_length[8]|is_unique[karyawan.nik]', [
            'required'   => '%s belum diisi',
            'min_length' => '%s tidak boleh kurang 8 karakter',
            'max_length' => '%s tidak boleh lebih 8 karakter',
            'is_unique'  => 'Maaf, %s sudah digunakan!'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', [
            'required'   => '%s belum dipilih'
        ]);
        $this->form_validation->set_rules('id_divisi', 'Divisi', 'required', [
            'required'   => '%s belum dipilih'
        ]);
        $this->form_validation->set_rules('id_unit', 'Unit', 'required', [
            'required'   => '%s belum dipilih'
        ]);
    }

    // tambah data karyawan
    public function tambah_karyawan()
    {
        $data['title']  = 'Tambah Data Karyawan';
        $data['divisi'] = $this->Model_karyawan->getAllDivisi();
        $data['unit']   = $this->Model_karyawan->getAllUnit();
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

       $this->rulesTambahKaryawan();

        // validasi tambah data
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar', $data);
            $this->load->view('karyawan/tambah_karyawan', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->Model_karyawan->tambahDataKaryawan() == true) {
                $this->session->set_flashdata('flash', 
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
				Data karyawan <strong>Berhasil</strong> ditambahkan
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;
						</span>
					</button>
				</div>');
                redirect('karyawan/data_karyawan');

            } else {
                $this->session->set_flashdata('flash', 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Terjadi kesalahan saat mengunggah foto. Pastikan itu adalah file JPG dengan ukuran kurang dari 2 MB.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;
						</span>
					</button>
				</div>');
                redirect('karyawan/tambah_karyawan');
                
            }
        }
    }

    // rules tambah gaji
    public function rulesGaji()
    {
        $this->form_validation->set_rules('gaji', 'Gaji', 'required', [
            'required' => '%s belum diisi'
        ]);       
    }

    // tambah data gaji karyawan
    public function tambah_gaji()
    {
        $data['title']    = 'Tambah Data Gaji';
        $data['karyawan'] = $this->Model_karyawan->getAllKaryawan();
        $data['user']     = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
        $this->rulesGaji();
    
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('karyawan/tambah_gaji', $data);
            $this->load->view('templates/footer');
        } else {
            $id   = $this->input->post('nama');
            $gaji = str_replace('.', '', $this->input->post('gaji'));
        
            // Tambahan kondisi untuk mengecek apakah gaji null atau tidak
            $cekNilaiGaji = $this->Model_karyawan->getGajiById($id);
        
            if ($cekNilaiGaji === null) {
                
                // Jika gaji null, tambahkan data
                $this->Model_karyawan->tambahDataGaji($id, $gaji);
                $this->session->set_flashdata('flash',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Gaji karyawan <strong>Berhasil</strong> ditambahkan
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
            
                redirect('karyawan/data_gaji');
                
            } else {
                
                // Jika gaji tidak null atau sudah ditambahkan
                $this->session->set_flashdata('flash',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong>  gaji karyawan sudah pernah ditambahkan
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
            
                redirect('karyawan/tambah_gaji');
            }
        }
    }

    // Rules validasi edit data
    public function rulesEdit()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required'     => '%s belum diisi!'
        ]);
        $this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[8]', [
            'required'     => '%s belum diisi!',
            'exact_length' => '%s harus terdiri dari 8 digit!'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', [
            'required'     => '%s belum dipilih'
        ]);
        $this->form_validation->set_rules('id_divisi', 'Divisi', 'required', [
            'required'     => '%s belum dipilih'
        ]);
        $this->form_validation->set_rules('id_unit', 'Unit', 'required', [
            'required'     => '%s belum dipilih'
        ]);
    }

    // edit data karyawan
    public function edit_karyawan($id)
    {
        $data['title']         = 'Edit Data Karyawan';
        $data['karyawan']      = $this->Model_karyawan->getKaryawanById($id);
        $data['divisi']        = $this->Model_karyawan->getAllDivisi();
        $data['unit']          = $this->Model_karyawan->getAllUnit();
        $data['jenis_kelamin'] = ['Pria', 'Wanita'];
        $data['user']          = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->rulesEdit();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('karyawan/edit_karyawan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Model_karyawan->editDataKaryawan($id);
            $this->session->set_flashdata('flash', 
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data karyawan <strong>Berhasil</strong> diubah
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('karyawan/data_karyawan');
        }
    }
    
    // edit data gaji karyawan
    public function edit_gaji($nik)
    {   
        $data['title']    = 'Edit Data Gaji Karyawan';
        $data['karyawan'] = $this->Model_karyawan->getKaryawanByNik($nik);
        $data['user']     = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->rulesGaji();
    
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('karyawan/edit_gaji', $data);
            $this->load->view('templates/footer');
        } else {  
            $this->Model_karyawan->editDataGaji($nik, $gaji);
            $this->session->set_flashdata('flash', 
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Gaji karyawan <strong>Berhasil</strong> diubah
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            
            redirect('karyawan/data_gaji');
        }
    }

    // hapus data karyawan
    public function hapus_karyawan($id)
    {
        // Dapatkan nama file foto sebelum menghapus data karyawan
        $foto = $this->Model_karyawan->getFotoById($id);

        // Hapus data karyawan
        $this->Model_karyawan->hapusDataKaryawan($id);

        // Hapus file foto dari penyimpanan
        if (!empty($foto)) {
            $pathToFile = './assets/img/upload/' . $foto;
            if (file_exists($pathToFile)) {
                
                // Hapus file dari penyimpanan
                unlink($pathToFile); 
            }
        }

        $this->session->set_flashdata('flash', 
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data karyawan <strong>Berhasil</strong> dihapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        redirect('karyawan/data_karyawan');
    }

    // server side data karyawan
    public function getDataKaryawan() {
        $results = $this->Model_serverside_karyawan->getDataTable();
        $data    = [];
        $no      = $_POST['start'];
        foreach ($results as $result) {
            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '.</div>';
            $row[] = '<div class="text-center">' . $result->nama . '</div>';
            $row[] = '<div class="text-center">' . $result->nik . '</div>';
            $row[] = '<div class="text-center">' . $result->jenis_kelamin . '</div>';
            $row[] = '<div class="text-center">' . $result->nama_divisi . '</div>';
            $row[] = '<div class="text-center">' . $result->nama_unit . '</div>';
            $row[] = '<div class="text-center"><img src="' . base_url('./assets/img/upload/' . $result->foto) . '" width="100"></div>';
            $row[] = '<div class="text-center">
            <a href="'.base_url('karyawan/edit_karyawan/'.$result->id).'" class="btn btn-warning" onclick="return confirm(\'Apakah Anda yakin untuk mengedit data ini?\')"><i class="bi bi-pencil-square"></i></a>
            <a href="'.base_url('karyawan/hapus_karyawan/'.$result->id).'" class="btn btn-danger" onclick="return confirm(\'Apakah Anda yakin untuk menghapus data ini?\')"><i class="bi bi-trash3-fill"></i></a>
            </div>';
            
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Model_serverside_karyawan->count_all_data(),
            "recordsFiltered" => $this->Model_serverside_karyawan->count_filter_data(),
            "data"            => $data,
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    // server side data gaji karyawan
    public function getDataGaji() {
        $results          = $this->Model_serverside_gaji->getDataTable();
        $data             = [];
        $no               = $_POST['start'];
        $countGajiNotNull = 0;
    
        foreach ($results as $result) {
    
            // kondisi untuk memeriksa nilai gaji, jika ada ditampilkan jika tidak ada tidak ditampilkan
            if ($result->gaji !== null) {
                
                $countGajiNotNull++; 
    
                $row = array();
                $row[] = '<div class="text-center">' . ++$no . '.</div>';
                $row[] = '<div class="text-center">' . $result->nama . '</div>';
                $row[] = '<div class="text-center">' . $result->nik . '</div>';
                $row[] = '<div class="text-center">Rp. ' . number_format($result->gaji, 0, ',', '.') . ',-</div>';
                $row[] = '<div class="text-center">
                    <a href="'.base_url('karyawan/edit_gaji/'.$result->nik).'" class="btn btn-warning" onclick="return confirm(\'Apakah Anda yakin untuk mengedit data ini?\')"><i class="bi bi-pencil-square"></i></a>';
                
                $data[] = $row;
            }
        }
    
        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $countGajiNotNull,
            "recordsFiltered" => $countGajiNotNull,
            "data"            => $data,
        );
    
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    // download file
    public function downloadFile()
    {
        $file_path = 'template_excel/template_karyawan.xlsx';
        $file_name = 'template_karyawan.xlsx';        
        force_download($file_path, NULL);
    }

    // import data excel
    public function import_data()
    {
        $config['upload_path']   = './import_excel/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name']     = 'doc' . time();
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('importexcel')) {
            
            // jika tidak ada file yang pilih
            $this->session->set_flashdata('flash',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Import data <strong>Gagal,</strong> tidak ada file yang pilih
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
            redirect('karyawan/data_karyawan');
        }
    
        $file   = $this->upload->data();
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open('./import_excel/' . $file['file_name']);
    
        foreach ($reader->getSheetIterator() as $sheet) {
            $numRow = 1;
        
            foreach ($sheet->getRowIterator() as $row) {
                if ($numRow > 1) {
                
                    $nik  = $row->getCellAtIndex(0)->getValue();
                    $nama = $row->getCellAtIndex(1)->getValue();
                    $jk   = $row->getCellAtIndex(2)->getValue();
                
                    // jika field ada yang kosong
                    if (empty($nik) || empty($nama) || empty($jk)) {
                        $this->session->set_flashdata('flash',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Import data <strong>Gagal,</strong> terdapat field yang kosong
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>');
                        redirect('karyawan/data_karyawan');
                    }
                
                    // jika ada data yang duplikat
                    $is_duplicate = $this->Model_karyawan->is_duplicate($nik, $nama);
                
                    if ($is_duplicate) {
                        $this->session->set_flashdata('flash',
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Import data <strong>Gagal,</strong> terdapat data yang duplikat
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>');
                        redirect('karyawan/data_karyawan');
                    }
                
                    $data = array(
                        'nik'           => $nik,
                        'nama'          => $nama,
                        'jenis_kelamin' => $row->getCellAtIndex(2),
                    );
                
                    $this->Model_karyawan->importDataExcel($data);
                }
                $numRow++;
            }
        
            $reader->close();
            unlink('./import_excel/' . $file['file_name']);
        
            // jika data valid
            $this->session->set_flashdata('flash',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Import data <strong>Berhasil</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
            redirect('karyawan/data_karyawan');
        }
    }    
}