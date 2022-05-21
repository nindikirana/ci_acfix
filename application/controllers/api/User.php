<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class user extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    public function index_get()
    {
       $id = $this->get('Id_User');
       $delete = $this->get('Delete');
       if($delete === true || $delete === 'true') {
            $this->deleteData($id);
            return;
       }
       if ($id === null) {

        $user = $this->user_model->getUser();

       } else {
        $user = $this->user_model->getUser($id);
        
       }
    
        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }
    private function deleteData($id) {
          if ($id === null) {
                $this->response([
                    'status' => false,
                    'message' => 'provide an id!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
               
                if ($this->user_model->deleteUser($id) > 0 ) {
    
                    $this->set_response([
                        'status' => true,
                        'id' => $id,
                        'message' => 'deleted.'
                    ], REST_Controller::HTTP_OK);
    
                } else {
    
                    $this->response([
                        'status' => false,
                        'message' => 'not found!'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        
                }
            }
    }

    public function index_delete()
    {
        $id = $this->delete('Id_User');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->user_model->deleteUser($id) > 0 ) {

                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted.'
                ], REST_Controller::HTTP_OK);

            } else {

                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
    
            }
        }

    }

    public function index_post()
    {
        $id = $this->post('Id_User');
        
        if ($id === null) {
        $user = [
            
            'Id_User' => "U".substr(uniqid(), 9),
            'Username' => $this->post('Username'),
            'Email' => $this->post('Email'),
            'Password' => md5($this->input->post('Password')),
            'No_Telp' => $this->post('No_Telp'),
            'Id_Level' => $this->post('Id_Level')
           
        ];
        

        if ($this->user_model->createUser($user) > 0) {
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

    }else {
            $user = [
            
                'Username' => $this->post('Username'),
                'Email' => $this->post('Email'),
                'Password' => md5($this->input->post('Password')),
                'No_Telp' => $this->post('No_Telp'),
                'Id_Level' => $this->post('Id_Level')
            ];
          
            if ($this->user_model->updateUser($user, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'user updated.'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to updated data!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_put()
    {
        $id = $this->post('Id_User');
        $user = [
            'Id_user' => $this->post('Id_User'),
            'Username' => $this->post('Username'),
            'Email' => $this->post('Email'),
            'Password' => $this->post('Password'),
            'No_Telp' => $this->post('No_Telp'),
            'Id_Level' => $this->post('Id_Level')
           
        ];
    
        if ($this->user_model->updateUser($user, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'user updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
