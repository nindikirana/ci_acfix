<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		
	}

    function Getuser($where) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($where);
        $data=$this->db->get();
        return $data;
    }
}