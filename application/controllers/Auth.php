<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Auth extends CI_Controller {
  
     public function __construct()
        {
         parent::__construct();
         $this->load->model('Form_model');
             $this->load->library(array('form_validation','session'));
                 $this->load->helper(array('url','html','form'));
                 $this->user_id = $this->session->userdata('Id_User');
        }
  
  
    public function index()
    {
     $this->load->view('login');
    }
    public function post_login()
        {
 
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
 
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', 'Enter %s');
 
        if ($this->form_validation->run() === FALSE)
        {  
            $this->load->view('login');
        }
        else
        {   
            $data = array(
               'email' => $this->input->post('Email'),
               'password' => md5($this->input->post('Password')),
 
             );
   
            $check = $this->Form_model->auth_check($data);
            
            if($check != false){
 
                 $user = array(
                 'Username' => $check->username,
                 'Email' => $check->email,
                 'Password' => $check->password,
                 'No_Telp' => $check->no_telp
                );
  
            $this->session->set_userdata($user);
 
             redirect( base_url('auth/dashboard') ); 
            }
 
           $this->load->view('login');
        }
         
    }   
    public function post_register()
    {/*
 
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('last_name', 'Email', 'required');
        $this->form_validation->set_rules('contact_no', 'Password', 'required');
        $this->form_validation->set_rules('email', 'No_Telp', 'required');
 
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_message('required', 'Enter %s');
 
        if ($this->form_validation->run() === FALSE)
        {  
            $this->load->view('register');
        }
        else
        {  */
            $data = array(
               'username' => $this->input->post('Username'),
               'email' => $this->input->post('Email'),
               'password' => $this->input->post('Password'),
               'no_telp' => $this->input->post('No_Telp'),
               'level' => $this->input->post('Level'),
 
             );
   
         $check = $this->Form_model->insert_user($data);
         // if($this->Form_model->insert_user($data)>0){
 
      if($check != false){
           $this->response([
                'status' =>true,
                'message' => 'new user created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
 
               /* $user = array(
                 'Id_User' => $check,
                 'email' => $this->input->post('Email'),
                 'password' => $this->input->post('Password'),
                 'no_telp' => $this->input->post('No_Telp'),
                 'level' => $this->input->post('Level'),
                ); */
                
             
             
              
  
           //  $this->session->set_userdata($user);
 
           //  redirect( base_url('auth/post_login') ); 
            }
 
         
    
    public function logout(){
    $this->session->sess_destroy();
    redirect(base_url('auth'));
   }    
   public function dashboard(){
       if(empty($this->user_id)){
        redirect(base_url('auth'));
      }
       $this->load->view('dashboard');
    }
}