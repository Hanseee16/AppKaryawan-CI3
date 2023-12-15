<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_filterdata extends CI_Model {
    
    private $table = 'karyawan';
    private $order = array('id', 'nama', 'nik', 'jenis_kelamin', 'nama_divisi', 'nama_unit', 'foto');
    private $column_order = array('id', 'nama', 'nik', 'jenis_kelamin', 'divisi.nama_divisi', 'unit.nama_unit', 'foto');

    private function _get_data_query($filter_type = null, $filter_value = null)
    {
        $this->db->from($this->table);
        $this->db->join('divisi', 'divisi.id_divisi = karyawan.id_divisi', 'left');
        $this->db->join('unit', 'unit.id_unit = karyawan.id_unit', 'left');

        // Pengecekan apakah terdapat filter divisi atau unit
        if ($filter_type === 'divisi' && !empty($filter_value)) {
            $this->db->where('divisi.id_divisi', $filter_value);
            
        } elseif ($filter_type === 'unit' && !empty($filter_value)) {
            $this->db->where('unit.id_unit', $filter_value);
        }
    }

    public function getDataTable($filter_type = null, $filter_value = null)
    {
        $this->_get_data_query($filter_type, $filter_value);
        return $this->db->get()->result();
    }

    public function count_filter_data() 
    {
        // Mendapatkan nilai filter divisi dan unit dari session
        $filter_divisi = $this->session->userdata('filter_divisi');
        $filter_unit = $this->session->userdata('filter_unit');
        
        // Memanggil fungsi _get_data_query untuk menyiapkan query
        $this->_get_data_query($filter_divisi, $filter_unit);
        
        // Menghitung jumlah data yang sesuai dengan filter
        return $this->db->count_all_results();
    }

    public function count_all_data() 
    {
        // Menghitung jumlah seluruh data tanpa filter
        return $this->db->count_all($this->table);
    }
}