<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_divisi extends CI_Model {
    // menampilkan seluruh data divisi
    public function getAllDivisi()
    {
        return $this->db->get('divisi')->result_array();
    }

    // jumlah divisi
    public function getJumlahDivisi()
    {
        return $this->db->get('divisi')->num_rows();
    }

    // tambah data divisi
    public function tambahDataDivisi()
    {
        $data = [
            "nama_divisi" => htmlspecialchars($this->input->post('nama_divisi', true)),
        ];
    
        $this->db->insert('divisi', $data);
    }

    // get data berdasarkan id
    public function getDivisiById($id_divisi)
    {
        return $this->db->get_where('divisi', ['id_divisi' => $id_divisi])->row_array();
    }

    // edit data divisi
    public function editDataDivisi($id_divisi)
    {    
        $data = [
            'id_divisi'   => $id_divisi,
            "nama_divisi" => htmlspecialchars($this->input->post('nama_divisi', true)),
        ];
    
        $this->db->where('id_divisi', $id_divisi);
        $this->db->update('divisi', $data);
    }

    // hapus data divisi berdasarkan ID
    public function hapusDataDivisi($id_divisi)
    {
        $this->db->query("SET foreign_key_checks = 0");
        $this->db->where('id_divisi', $id_divisi);
        $this->db->update('karyawan', array('id_divisi' => NULL));
        $this->db->query("SET foreign_key_checks = 1");
        $this->db->where('id_divisi', $id_divisi);
        $this->db->delete('divisi');
    }

    // export data karyawan
    public function exportDataDivisi()
    {
        $this->db->select('*');
        $this->db->from('divisi');

        return $this->db->get()->result_array();
    }

    // cek duplikat pada import data
    public function cek_duplikat($nama_divisi)
    {
        $this->db->where('nama_divisi', $nama_divisi);
        $query = $this->db->get('divisi');
        
        if($query->num_rows() > 0) {
            return true;
        }
        
        return false;
    }

    // import data excel
    public function importDataExcel($data)
    {
        // Pengecekan duplikat
        $existingData = $this->db->get_where('divisi', array('nama_divisi' => $data['nama_divisi']))->row_array();

        if (!$existingData) {
            
            // Jika data belum ada, masukkan ke database
            $this->db->insert('divisi', $data);
        }
    }
}