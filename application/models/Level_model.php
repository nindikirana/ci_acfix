<?php

class level_model extends CI_MODEL
{
    public function getLevel_user($id_level = null)
    {

        if( $id_level === null )  {
            return $this->db->get('level_user')->result_array();
        } else {
            return $this->db->get_where('level_user', ['Id_Level' => $id_level])->result_array();
           
        }
   
}
    public function deleteLevel_user($id_level)
    {
        $this->db->delete('level_user', ['Id_Level' => $id_level]);
        return $this->db->affected_rows(); 
    }

    public function createLevel_user($level)
    {
        $this->db->insert('level_user', $level);
        return $this->db->affected_rows();
    }

    public function updateLevel_user($level, $id_level)
    {
       return $this->db->update('level_user', $level , ['Id_Level' => $id_level]);
        return $this->db->affected_rows();
    }
}