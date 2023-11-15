<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_serverside_gaji extends CI_Model {
    
    var $table          = 'karyawan';
    var $column_order   = array('id', 'nama', 'nik', 'gaji');
    var $order          = array('id', 'nama', 'nik', 'gaji');

    private function _get_data_query() {
        $this->db->from($this->table);
        
        if (isset($_POST['search']['value'])) {
            $this->db->like('nama', $_POST['search']['value']);
            $this->db->or_like('nik', $_POST['search']['value']);
            $this->db->or_like('gaji', $_POST['search']['value']);
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