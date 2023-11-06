<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_karyawan');
        $this->load->model('Model_divisi');
        $this->load->model('Model_unit');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title']  = 'Data Karyawan';
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['karyawan'] = $this->Model_karyawan->getAllKaryawan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('karyawan/data_karyawan', $data);
        $this->load->view('templates/footer');
    }

    // hapus data karyawan
    public function hapus($id)
    {
        $this->Model_karyawan->hapusDataKaryawan($id);
        $this->session->set_flashdata('flash', 
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
		Data karyawan <strong>Berhasil</strong> dihapus
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;
				</span>
			</button>
		</div>');
        redirect('karyawan');
    }

    // tambah data karyawan
    public function tambah()
    {
        $data['title']    = 'Tambah Data Karyawan';
        $data['divisi']   = $this->Model_karyawan->getAllDivisi();
        $data['unit']     = $this->Model_karyawan->getAllUnit();
        $data['user']     = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // rules validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required' => '%s belum diisi!'
        ]);
        $this->form_validation->set_rules('nik', 'NIK', 'required|min_length[8]|max_length[8]|is_unique[karyawan.nik]', [
            'required'   => '%s belum diisi!',
            'min_length' => '%s tidak boleh kurang 8 karakter!',
            'max_length' => '%s tidak boleh lebih 8 karakter!',
            'is_unique'  => 'Maaf, %s sudah digunakan!'
        ]);

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
                redirect('karyawan');

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

    // edit data karyawan
    public function edit($id)
    {
        $data['title']          = 'Edit Data Karyawan';
        $data['karyawan']       = $this->Model_karyawan->getKaryawanById($id);
        $data['divisi']         = $this->Model_karyawan->getAllDivisi();
        $data['unit']           = $this->Model_karyawan->getAllUnit();
        $data['jenis_kelamin']  = ['Pria', 'Wanita'];
        $data['user']           = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Rules validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required'     => 'Nama belum diisi!'
        ]);
        $this->form_validation->set_rules('nik', 'NIK', 'required|exact_length[8]', [
            'required'     => '%x belum diisi!',
            'exact_length' => '%x harus terdiri dari 8 digit!'
        ]);

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
            redirect('karyawan');
        }
    }
}