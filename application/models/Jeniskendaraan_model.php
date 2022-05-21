<?php

class jeniskendaraan_model extends CI_MODEL
{
    public function getJenis_kendaraan($id_jenis = null)
    {

        if( $id_jenis === null )  {
            return $this->db->get('jenis_kendaraan')->result_array();
        } else {
            return $this->db->get_where('jenis_kendaraan', ['Id_Jenis' => $id_jenis])->result_array();
           
        }
   
}
    public function deleteJenis_kendaraan($id_jenis)
    {
        $this->db->delete('jenis_kendaraan', ['Id_Jenis' => $id_jenis]);
        return $this->db->affected_rows(); 
    }

    public function createJenis_kendaraan($jenis)
    {
        $this->db->insert('jenis_kendaraan', $jenis);
        return $this->db->affected_rows();
    }

    public function updateJenis_kendaraan($jenis, $id_jenis)
    {
       return $this->db->update('jenis_kendaraan', $jenis , ['Id_Jenis' => $id_jenis]);
        return $this->db->affected_rows();
    }
}