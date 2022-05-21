<?php

class pengetahuan_model extends CI_MODEL
{
    public function getPengetahuan($Id_Gejala = null, $Id_Kerusakan = null)
    {

        if( $Id_Gejala != null )  {
          $this->db->select('*');
          $this->db->from('pengetahuan');
          $this->db->join('gejala','pengetahuan.Id_Gejala = gejala.Id_Gejala','LEFT');      
          $this->db->join('kerusakan','pengetahuan.Id_Kerusakan = kerusakan.Id_Kerusakan','LEFT');
          $this->db->where('pengetahuan.Id_Gejala', $Id_Gejala);
          $query = $this->db->get();
          return $query->result_array();
            
        } else if($Id_Kerusakan != null){
          $this->db->select('*');
          $this->db->from('pengetahuan');
          $this->db->join('gejala','pengetahuan.Id_Gejala = gejala.Id_Gejala','LEFT');      
          $this->db->join('kerusakan','pengetahuan.Id_Kerusakan = kerusakan.Id_Kerusakan','LEFT');
          $this->db->where('pengetahuan.Id_Kerusakan', $Id_Kerusakan);
          $query = $this->db->get();
          return $query->result_array();

        }else{            
           return $this->db->get('pengetahuan')->result_array();
        }   
   
}
    public function deletePengetahuan($id_pengetahuan)
    {
        $this->db->where('Id_Pengetahuan', $id_pengetahuan);
        $delete = $this->db->delete('pengetahuan');

            return $this->db->affected_rows(); 
    }

    public function createPengetahuan($pengetahuan)
    {
        $this->db->insert('pengetahuan', $pengetahuan);
        return $this->db->affected_rows();
    }

    public function updatePengetahuan($pengetahuan, $id_pengetahuan)
    {
       return $this->db->update('pengetahuan', $pengetahuan , ['Id_Pengetahuan' => $id_pengetahuan]);
        return $this->db->affected_rows();
    }
}