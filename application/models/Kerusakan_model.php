<?php

class kerusakan_model extends CI_MODEL
{
        public function getKerusakan($id = null, $nama = null)
    {       
      if ($id === null && $nama === null) {
          $this->db->select('*');
          $this->db->from('kerusakan');
          $query = $this->db->get();
          return $query->result_array();
      }elseif($id != null && $nama === null){
        $this->db->select('*');

        $this->db->from('kerusakan');
        $this->db->where('Id_Kerusakan', $id);
        $query = $this->db->get();
        return $query->result_array();
    }elseif($id === null && $nama != null){
     
       str_replace('"', "'", $nama);
       $this->db->from('kerusakan');
       $this->db->like('Nama_Kerusakan', $nama);
       $query = $this->db->get();
       return $query->result_array();    
       
   }else {
    $this->db->select('*');

    $this->db->from('kerusakan');
    $query = $this->db->get();
    return $query->result_array();
}   


}
    public function deleteKerusakan($id_kerusakan)
    {

     $this->db->where('Id_Kerusakan', $id_kerusakan);
     $delete = $this->db->delete('kerusakan');

     return $this->db->affected_rows(); 
 }

 public function createKerusakan($kerusakan)
 {
    $this->db->insert('kerusakan', $kerusakan);
    return $this->db->affected_rows();
}

public function updateKerusakan($kerusakan, $id_kerusakan)
{
   return $this->db->update('kerusakan', $kerusakan , ['Id_Kerusakan' => $id_kerusakan]);
   return $this->db->affected_rows();
}
}