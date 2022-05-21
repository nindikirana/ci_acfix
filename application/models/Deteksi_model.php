<?php

class deteksi_model extends CI_MODEL
{
    public function getDeteksi($id_gejala = null)
    {

        if( $id_gejala === null )  {
            return $this->db->get('deteksi')->result_array();
        } else {
            return $this->db->get_where('deteksi', ['Id_Gejala' => $id_gejala])->result_array();
           
        }
   
}
    public function deleteDeteksi($id_deteksi)
    {
        $this->db->delete('deteksi', ['Id_Deteksi' => $id_deteksi]);
        return $this->db->affected_rows(); 
    }

    public function createDeteksi($deteksi)
    {
        $this->db->insert('deteksi', $deteksi);
        return $this->db->affected_rows();
    }

    public function updateDeteksi($deteksi, $id_deteksi)
    {
       return $this->db->update('deteksi', $deteksi , ['Id_Deteksi' => $id_deteksi]);
        return $this->db->affected_rows();
    }


    public function rules_k1(){
    $where = array('a.id_gejala'=>'G0001', 'a.id_gejala'=>'G0002');
    $this->db->select('*')
             ->from('pengetahuan a')
             ->where($where);
    $query = $this->db->get();
    return $query->result();
}
}