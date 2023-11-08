<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
            'required'      => '%s belum diisi',
            'valid_email'   => '%s tidak valid'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', [
            'required'      => '%s belum diisi'
        ]);

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Login Page';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login');
        } else {

            // validasi sukses
            $this->_login();
        }
    }

    private function _login()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');
        $user       = $this->db->get_where('user', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {

            // verifikasi password
            if (password_verify($password, $user['password'])) {
                $data = [
                    'email' => $user['email']
                ];

                $this->session->set_userdata($data);
                redirect('karyawan');
            } else {

                // tidak password salah
                $this->session->set_flashdata('message', 
                '<div class="alert alert-danger" role="alert">
                    <strong>Maaf,</strong> password salah.
                </div>');
                redirect('auth');
            }
        } else {

            // tidak ada user dengan email itu
            $this->session->set_flashdata('message', 
            '<div class="alert alert-danger" role="alert">
                <strong>Maaf!</strong> Email belum terdaftar.
            </div>');
            redirect('auth');
        }
    }

    public function register()
    {
        // rules
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required'      => '%s belum diisi'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'required'      => '%s belum diisi',
            'valid_email'   => '%s tidak valid',
            'is_unique'     => 'Maaf, %s sudah terdaftar'
        ]);
        $this->form_validation->set_rules('password1', 'password', 'required|trim|min_length[5]|matches[password2]', [
            'matches'       => 'Maaf, %s tidak sesuai',
            'min_length'    => '%s minimal 5 karakter',
            'required'      => '%s belum diisi'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');


        if ($this->form_validation->run() == false) {

            $data['title'] = 'Registration Page';

            $this->load->view('templates/header', $data);
            $this->load->view('auth/register');
            
        } else {
            $data = [
                'nama'      => htmlspecialchars($this->input->post('nama', true)),
                'email'     => htmlspecialchars($this->input->post('email', true)),
                'password'  => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', 
            '<div class="alert alert-success" role="alert">
                Registrasi akun <strong>Berhasil</strong>. Silahkan login!
            </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->set_flashdata('message', 
        '<div class="alert alert-danger" role="alert">
            <strong>Berhasil keluar!</strong>
        </div>');
        redirect('auth');
    }
}