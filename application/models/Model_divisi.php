<?php
class Model_divisi extends CI_Model
{
    // menampilkan seluruh data karyawan
    public function all_data()
    {
        $this->db->select('*');
        $this->db->from('divisi');
        return $this->db->get()->result_array();
    }
}
