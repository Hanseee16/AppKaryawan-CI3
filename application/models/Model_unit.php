<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_unit extends CI_Model {
    // menampilkan seluruh data unit
    public function getAllUnit()
    {
        return $this->db->get('unit')->result_array();
    }
    
    // jumlah unit
    public function getJumlahUnit()
    {
        return $this->db->get('unit')->num_rows();
    }

    // tambah data
    public function tambahDataUnit()
    {
        $data = [
            "nama_unit" => htmlspecialchars($this->input->post('nama_unit', true)),
        ];
    
        $this->db->insert('unit', $data);
    }

    // ambil data berdasrkan ID
    public function getUnitById($id_unit)
    {
        return $this->db->get_where('unit', ['id_unit' => $id_unit])->row_array();
    }

    // edit data
    public function editDataUnit($id_unit)
    {    
        $data = [
            'id_unit'   => $id_unit,
            "nama_unit" => htmlspecialchars($this->input->post('nama_unit', true)),
        ];
    
        $this->db->where('id_unit', $id_unit);
        $this->db->update('unit', $data);
    }

    // hapus data
    public function hapusDataUnit($id_unit)
    {
        $this->db->query("SET foreign_key_checks = 0");
        $this->db->where('id_unit', $id_unit);
        $this->db->update('karyawan', array('id_unit' => NULL));
        $this->db->query("SET foreign_key_checks = 1");
        $this->db->where('id_unit', $id_unit);
        $this->db->delete('unit');
    }

    // export data
    public function exportDataUnit()
    {
        $this->db->select('*');
        $this->db->from('unit');
        return $this->db->get()->result_array();
    }

    // import data
    public function importDataExcel($data)
    {
        // Pengecekan duplikat
        $existingData = $this->db->get_where('unit', array('nama_unit' => $data['nama_unit']))->row_array();
        
        if (!$existingData) {            
            $this->db->insert('unit', $data);
        }
    }

    // cek duplikat import data
    public function cekDuplikat($nama_unit)
    {
        $this->db->where('nama_unit', $nama_unit);
        $query = $this->db->get('unit');
        
        if($query->num_rows() > 0) {
            return true;
        }
        
        return false;
    }

}