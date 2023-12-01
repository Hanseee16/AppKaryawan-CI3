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

}