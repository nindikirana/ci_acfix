<?php

class gejala_model extends CI_MODEL
{
    public function getGejala($id = null, $nama = null)
    {       
      if ($id === null && $nama === null) {
          $this->db->select('*');
          $this->db->from('gejala');
          $query = $this->db->get();
          return $query->result_array();
      }elseif($id != null && $nama === null){
        $this->db->select('*');

        $this->db->from('gejala');
        $this->db->where('Id_Gejala', $id);
        $query = $this->db->get();
        return $query->result_array();
    }elseif($id === null && $nama != null){
     
       str_replace('"', "'", $nama);
       $this->db->from('gejala');
       $this->db->like('Nama_Gejala', $nama);
       $query = $this->db->get();
       return $query->result_array();    
       
   }else {
    $this->db->select('*');

    $this->db->from('gejala');
    $query = $this->db->get();
    return $query->result_array();
}   


}
public function deleteGejala($id_gejala)
{
    $this->db->where('Id_Gejala', $id_gejala);
    $delete = $this->db->delete('gejala');

    return $this->db->affected_rows(); 
}

public function createGejala($gejala)
{
    $this->db->insert('gejala', $gejala);
    return $this->db->affected_rows();
}

public function updateGejala($gejala, $id_gejala)
{
 return $this->db->update('gejala', $gejala , ['Id_Gejala' => $id_gejala]);
 return $this->db->affected_rows();
}
}