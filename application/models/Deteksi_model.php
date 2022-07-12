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


    public function rules_query($values,$kerusakan){
      $this->db->where_in('Id_Gejala', $values);
      $this->db->where('Id_Kerusakan', $kerusakan);
      $data=$this->db->get('pengetahuan')->result_array();

        $this->db->where('Id_Kerusakan',$kerusakan);
        $data2 = $this ->db->get('pengetahuan')->result_array();
        $size_query2 = count($data2);
        $size_query= count($data);
        $size_values = count($values);
        if($size_query==$size_values && $size_query==$size_query2){
            return True;
        }else{
            return False;
        }
}
    public function getHasil($idKerusakan){
     $this->db->select('*');
        $this->db->from('kerusakan');
        $this->db->where('Id_Kerusakan', $idKerusakan);
        $query = $this->db->get();
        return $query->result_array();
}

    public function rules($values){
       
        if ($this->rules_query($values,'K0001')===True) {
            return  $this->getHasil('K0001');
        }else if ($this->rules_query($values,'K0002')===True) {
            return $this->getHasil('K0002');}
        else if($this->rules_query($values,'K0003')===True){
             return $this->getHasil('K0003');
        }else if($this->rules_query($values,'K0004')===True){
            return $this->getHasil('K0004');
        }else if($this->rules_query($values,'K0005')===True){   
             return $this->getHasil('K0005');
        }else if($this->rules_query($values,'K0006')===True){
            return $this->getHasil('K0006');
        }else if($this->rules_query($values,'K0007')===True){
             return $this->getHasil('K0007');
        }else if($this->rules_query($values,'K0008')===True){
            return $this->getHasil('K0008');
        }else if($this->rules_query($values,'K0009')===True){
            return $this->getHasil('K0009');
               }
               else{
                return null;
               }

   }

}