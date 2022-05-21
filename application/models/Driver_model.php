<?php

class driver_model extends CI_MODEL
{
    public function getDriver($id_driver = null)
    {

        if( $id_driver === null )  {
            return $this->db->get('driver')->result_array();
        } else {
            return $this->db->get_where('driver', ['Id_Driver' => $id_driver])->result_array();
           
        }
   
}
    public function deleteDriver($id_driver)
    {
        $this->db->delete('driver', ['Id_Driver' => $id_driver]);
        return $this->db->affected_rows(); 
    }

    public function createDriver($driver)
    {
        $this->db->insert('driver', $driver);
        return $this->db->affected_rows();
    }

    public function updateDriver($driver, $id_driver)
    {
       return $this->db->update('driver', $driver , ['Id_Driver' => $id_driver]);
        return $this->db->affected_rows();
    }
}