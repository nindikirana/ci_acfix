<?php

class user_model extends CI_MODEL
{
    
    function validate_user() {
           $this->db->where('Email', $this->input->post('Email'));
           $this->db->where('Password', md5($this->input->post('password')));

           $query = $this->db->get("user");

           if( $query->num_rows == 1 )  {
              return true;
           }
       }
   
   
    public function getUser($id_user = null)
    {

        if( $id_user === null )  {
            return $this->db->get('user')->result_array();
        } else {
            return $this->db->get_where('user', ['Id_User' => $id_user])->result_array();
           
        }
   
}
    public function deleteUser($id)
    {
        $this->db->delete('user', ['Id_User' => $id]);
        return $this->db->affected_rows(); 
    }

    public function createUser($user)
    {
          $this->db->insert('user', $user);
        return $this->db->affected_rows();
    }

   public function updateUser($user, $id_user)
    {
       return $this->db->update('user', $user , ['Id_User' => $id_user]);
       // return// $this->db//->affected_rows();
    }
 

}