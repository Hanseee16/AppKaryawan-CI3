<?php
class Model_unit extends CI_Model
{
    // menampilkan seluruh data karyawan
    public function all_data()
    {
        $this->db->select('*');
        $this->db->from('unit');
        return $this->db->get()->result_array();
    }
}
