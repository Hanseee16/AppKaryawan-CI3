<?php
class Model_karyawan extends CI_Model
{
    // menampilkan seluruh data karyawan
    public function getAllKaryawan()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('divisi', 'divisi.id_divisi = karyawan.id_divisi', 'left');
        $this->db->join('unit', 'unit.id_unit = karyawan.id_unit', 'left');

        // menampilkan data yang nilainya null saja
        $this->db->where('Gaji IS NULL');

        return $this->db->get()->result_array();
    }

    // menampilkan seluruh data divisi
    public function getAllDivisi()
    {
        return $this->db->get('divisi')->result_array();
    }

    // menampilkan seluruh data unit
    public function getAllUnit()
    {
        return $this->db->get('unit')->result_array();
    }

    // jumlah karyawan
    public function getJumlahKaryawan()
    {
        return $this->db->get('karyawan')->num_rows();
    }

    // jumlah divisi
    public function getJumlahDivisi()
    {
        return $this->db->get('divisi')->num_rows();
    }

    // jumlah unit
    public function getJumlahUnit()
    {
        return $this->db->get('unit')->num_rows();
    }

    // jumlah user
    public function getJumlahUser()
    {
        return $this->db->get('user')->num_rows();
    }

    // jumlah data gaji karyawan
    public function getJumlahDataGaji()
    {
        $this->db->where('gaji IS NOT NULL');
        return $this->db->get('karyawan')->num_rows();
    }

    // get data berdasarkan id
    public function getKaryawanById($id)
    {
        return $this->db->get_where('karyawan', ['id' => $id])->row_array();
    }   
    
    // get data berdasarkan nik
    public function getKaryawanByNik($nik)
    {
        return $this->db->get_where('karyawan', ['nik' => $nik])->row_array();
    }

    // hapus data karyawan
    public function hapusDataKaryawan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('karyawan');
    }
    
    // untuk mendapatkan nama file foto berdasarkan ID karyawan
    public function getFotoById($id)
    {
        $this->db->select('foto');
        $this->db->from('karyawan');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row();

        return $result ? $result->foto : null;
    }

    // tambah data karyawan
    public function tambahDataKaryawan()
    {
        $config['upload_path']   = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|JPG';
        $config['max_size']      = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            $error =  $this->upload->display_errors();
            return false;
            // Handle error, misalnya menampilkan pesan error atau mengembalikan pengguna ke halaman sebelumnya.
        } else {
            $data = [
                "nama"          => htmlspecialchars($this->input->post('nama', true)),
                "nik"           => preg_replace('/[^a-zA-Z0-9]/', '', $this->input->post('nik')),
                "jenis_kelamin" => htmlspecialchars($this->input->post('jenis_kelamin', true)),
                "id_divisi"     => htmlspecialchars($this->input->post('id_divisi', true)),
                "id_unit"       => htmlspecialchars($this->input->post('id_unit', true)),
                "foto"          => $this->upload->data('file_name'),
            ];

            $this->db->insert('karyawan', $data);
            return true;
        }
    }

    // tambah data gaji karyawan
    public function tambahDataGaji($id, $gaji)
    {    
        $data = [
            'id'    => $id,
            "gaji"  => $gaji,
        ];
    
        $this->db->where('id', $id);
        $this->db->update('karyawan', $data);
    }

    // cek nilai gaji berdasarkan ID
    public function getGajiById($id)
    {
        $this->db->select('gaji');
        $this->db->where('id', $id);
        $query = $this->db->get('karyawan');

        // Mengembalikan nilai gaji jika data ditemukan, atau null jika tidak ditemukan
        return $query->row() ? $query->row()->gaji : null;
    }

    // edit data karyawan
    public function editDataKaryawan($id)
    {
        $config['upload_path']   = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|JPG';
        $config['max_size']      = 2048;
    
        $this->load->library('upload', $config);
    
        $data = [
            'id'            => $id,
            "nama"          => htmlspecialchars($this->input->post('nama', true)),
            "nik"           => preg_replace('/[^a-zA-Z0-9]/', '', $this->input->post('nik')),
            "jenis_kelamin" => htmlspecialchars($this->input->post('jenis_kelamin', true)),
            "id_divisi"     => htmlspecialchars($this->input->post('id_divisi', true)),
            "id_unit"       => htmlspecialchars($this->input->post('id_unit', true)),
        ];
    
        // Periksa apakah ada file foto yang diunggah
        if (!empty($_FILES['foto']['name'])) {
            if ($this->upload->do_upload('foto')) {
                
                // Jika foto telah diunggah, proses data
                $upload_data = $this->upload->data();
                $data['foto'] = $upload_data['file_name'];
            
                // Hapus foto lama jika ada
                $karyawan = $this->Model_karyawan->getKaryawanById($id);
                if ($karyawan && !empty($karyawan['foto'])) {
                    $file_path = './assets/img/upload/' . $karyawan['foto'];
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
            } else {
                // Handle error jika gagal mengunggah foto baru
                $error = ['error' => $this->upload->display_errors()];
            }
        }
    
        // Update data karyawan
        $this->db->where('id', $id);
        $this->db->update('karyawan', $data);
    }
    
    // edit data gaji karyawan
    public function editDataGaji($nik, $gaji)
    {
        $data = [
            'nik'   => $nik,
            "gaji"  => str_replace('.', '', $this->input->post('gaji')),
        ];
        
        $this->db->where('nik', $nik);
        $this->db->update('karyawan', $data);
    }
}