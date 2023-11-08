<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_karyawan');
    }

    public function index()
    {
        $data['title']          = 'Dashboard';
        $data['jumlahKaryawan'] = $this->Model_karyawan->getJumlahKaryawan();
        $data['jumlahDivisi']   = $this->Model_karyawan->getJumlahDivisi();
        $data['jumlahUnit']     = $this->Model_karyawan->getJumlahUnit();
        $data['jumlahUser']     = $this->Model_karyawan->getJumlahUser();
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
        $data['title']      = 'Data Karyawan';
        $data['user']       = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['karyawan']   = $this->Model_karyawan->getAllKaryawan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('karyawan/data_karyawan', $data);
        $this->load->view('templates/footer');
    }

    // rules tambah data
    public function rulesTambah()
    {
        // rules validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required'      => '%s belum diisi'
        ]);
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[8]|max_length[8]|is_unique[karyawan.nik]', [
            'required'      => '%s belum diisi',
            'min_length'    => '%s tidak boleh kurang 8 karakter',
            'max_length'    => '%s tidak boleh lebih 8 karakter',
            'is_unique'     => 'Maaf, %s sudah digunakan!'
        ]);
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', [
            'required'      => '%s belum dipilih'
        ]);
        $this->form_validation->set_rules('id_divisi', 'Divisi', 'required', [
            'required'      => '%s belum dipilih'
        ]);
        $this->form_validation->set_rules('id_unit', 'Unit', 'required', [
            'required'      => '%s belum dipilih'
        ]);
    }

    // tambah data karyawan
    public function tambah()
    {
        $data['title']    = 'Tambah Data Karyawan';
        $data['divisi']   = $this->Model_karyawan->getAllDivisi();
        $data['unit']     = $this->Model_karyawan->getAllUnit();
        $data['user']     = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

       $this->rulesTambah();

        // validasi tambah data
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar', $data);
            $this->load->view('karyawan/tambah', $data);
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
                redirect('karyawan/tambah');
                
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
            'required'     => '%x belum diisi!',
            'exact_length' => '%x harus terdiri dari 8 digit!'
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
    public function edit($id)
    {
        $data['title']          = 'Edit Data Karyawan';
        $data['karyawan']       = $this->Model_karyawan->getKaryawanById($id);
        $data['divisi']         = $this->Model_karyawan->getAllDivisi();
        $data['unit']           = $this->Model_karyawan->getAllUnit();
        $data['jenis_kelamin']  = ['Pria', 'Wanita'];
        $data['user']           = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->rulesEdit();

        // Validasi edit data
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('karyawan/edit', $data);
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

    // hapus data karyawan
    public function hapus($id)
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

    // server side
    public function getData() {
        $results = $this->Model_karyawan->getDataTable();
        $data = [];
        $no = $_POST['start'];
        foreach ($results as $result) {
            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = '<div class="text-center">' . $result->nama . '</div>';
            $row[] = '<div class="text-center">' . $result->nik . '</div>';
            $row[] = '<div class="text-center">' . $result->jenis_kelamin . '</div>';
            $row[] = '<div class="text-center">' . $result->nama_divisi . '</div>';
            $row[] = '<div class="text-center">' . $result->nama_unit . '</div>';
            $row[] = '<div class="text-center"><img src="' . base_url('./assets/img/upload/' . $result->foto) . '" width="100"></div>';
            $row[] = '<div class="text-center">
            <a href="'.base_url('karyawan/edit/'.$result->id).'" class="btn btn-warning" onclick="return confirm(\'Apakah Anda yakin untuk mengedit data ini?\')"><i class="bi bi-pencil-square"></i></a>
            <a href="'.base_url('karyawan/hapus/'.$result->id).'" class="btn btn-danger" onclick="return confirm(\'Apakah Anda yakin untuk menghapus data ini?\')"><i class="bi bi-trash3-fill"></i></a>
            </div>';
            
            $data[] = $row;
        }

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->Model_karyawan->count_all_data(),
            "recordsFiltered"   => $this->Model_karyawan->count_filter_data(),
            "data"              => $data,
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
}