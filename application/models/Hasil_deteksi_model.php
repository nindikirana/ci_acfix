<?php

class hasil_deteksi_model extends CI_MODEL
{
     
    public function getDeteksi($Id_User = null)
    {

        if( $Id_User != null )  {
          $this->db->select('kerusakan.Nama_Kerusakan, kerusakan.solusi, deteksi.Nama_Gejala');
          $this->db->from('deteksi');
          $this->db->join('user','deteksi.Id_User = user.Id_User','LEFT');      
          $this->db->join('kerusakan','deteksi.Id_Kerusakan = kerusakan.Id_Kerusakan','LEFT');
          $this->db->join('gejala','deteksi.Nama_Gejala = gejala.Nama_Gejala','LEFT');
          $this->db->where('deteksi.Id_User', $Id_User);
          $query = $this->db->get();
          return $query->result_array();
            
        // } else if($Id_Kerusakan != null){
        //   $this->db->select('kerusakan.Nama_Kerusakan, kerusakan.solusi, gejala.Nama_Gejala');
        //   $this->db->from('deteksi');
        //   $this->db->join('gejala','deteksi.Nama_Gejala = deteksi.Nama_Gejala','LEFT');      
        //   $this->db->join('kerusakan','deteksi.Id_Kerusakan = kerusakan.Id_Kerusakan','LEFT');
        //   $this->db->where('deteksi.Id_Kerusakan', $Id_Kerusakan);
        //   $query = $this->db->get();
        //   return $query->result_array();

        // } else if($Nama_Gejala != null){
        //   $this->db->select('kerusakan.Nama_Kerusakan, kerusakan.solusi, gejala.Nama_Gejala');
        //   $this->db->from('deteksi');
        //   $this->db->join('gejala','deteksi.Nama_Gejala = deteksi.Nama_Gejala','LEFT');      
        //   $this->db->join('kerusakan','deteksi.Id_Kerusakan = kerusakan.Id_Kerusakan','LEFT');
        //   $this->db->where('deteksi.Nama_Gejala', $Nama_Gejala);
        //   $query = $this->db->get();
        //   return $query->result_array();

        }else{            
           return $this->db->get('deteksi')->result_array();
        }   
   
}
    public function deleteDeteksi($id_deteksi)
    {
        $this->db->where('Id_Deteksi', $id_deteksi);
        $delete = $this->db->delete('deteksi');

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
}