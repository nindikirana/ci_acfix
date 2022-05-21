<?php

class kendaraan_model extends CI_MODEL
{
    public function getKendaraan($id_kendaraan = null)
    {

        if( $id_kendaraan === null )  {
            return $this->db->get('kendaraan')->result_array();
        } else {
            return $this->db->get_where('kendaraan', ['Id_Kendaraan' => $id_kendaraan])->result_array();
           
        }
   
}
     public function deleteKendaraan($id_kendaraan)
    {
        $this->db->delete('kendaraan', ['Id_Kendaraan' => $id_kendaraan]);
        return $this->db->affected_rows(); 
    }

    public function createKendaraan($kendaraan)
    {
        $this->db->insert('kendaraan', $kendaraan);
        return $this->db->affected_rows();
    }

    public function updateKendaraan($kendaraan, $id_kendaraan)
    {
       return $this->db->update('kendaraan', $kendaraan , ['Id_Kendaraan' => $id_kendaraan]);
      return $this->db->affected_rows();
    }
}