<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_serverside_karyawan extends CI_Model {
    
    var $table        = 'karyawan';
    var $order        = array('id', 'nama', 'nik', 'jenis_kelamin', 'divisi.nama_divisi', 'unit.nama_unit', 'foto');
    var $column_order = array('id', 'nama', 'nik', 'jenis_kelamin', 'divisi.nama_divisi', 'unit.nama_unit', 'foto');

    private function _get_data_query() {
        $this->db->from($this->table);
        $this->db->join('divisi', 'divisi.id_divisi = karyawan.id_divisi', 'left');
        $this->db->join('unit', 'unit.id_unit = karyawan.id_unit', 'left');
    
         // Tambahkan kondisi untuk filter divisi dan unit
         if (isset($_POST['search']['value'])) {
            $this->db->group_start();
            $this->db->like('nama', $_POST['search']['value']);
            $this->db->or_like('nik', $_POST['search']['value']);
            $this->db->or_like('jenis_kelamin', $_POST['search']['value']);
            $this->db->or_like('divisi.nama_divisi', $_POST['search']['value']);
            $this->db->or_like('unit.nama_unit', $_POST['search']['value']);
            $this->db->or_like('foto', $_POST['search']['value']);
            $this->db->group_end();
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
        } else {
            $this->db->order_by('nama', 'ASC');
        }
    }

    public function getDataTable() {
        $this->_get_data_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function count_filter_data() {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}