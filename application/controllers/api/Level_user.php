<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Level_user extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('level_model');
    }
    public function index_get()
    {
       $id = $this->get('Id_Level');
        $delete = $this->get('Delete');
       if($delete === true || $delete === 'true') {
            $this->deleteData($id);
            return;
       }
       if ($id === null) {

        $level = $this->level_model->getLevel_user();

       } else {
        $level = $this->level_model->getLevel_user($id);
        
       }
    
        if ($level) {
            $this->response([
                'status' => true,
                'data' => $level
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
               
                if ($this->level_model->deleteLevel_user($id) > 0 ) {
    
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
        $id = $this->delete('Id_Level');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->level_model->deleteLevel_user($id) > 0 ) {

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
        $id = $this->post('Id_Level');
        
        if ($id === null) {
        $level = [
            
            'Id_Level' => "L".substr(uniqid(), 9),
            'Level' => $this->post('Level')
           
           
        ];

        if ($this->level_model->createLevel_user($level) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'new level user created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }else {
             $level = [
            
           
            'Level' => $this->post('Level')
            
             ];
          
            if ($this->level_model->updatelevel_user($level, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'level updated.'
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
        $id = $this->post('Id_Level');
        $level = [
          
            'Level' => $this->post('Level')
           
        ];
    
        if ($this->level_model->updatelevel_user($level, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'level user updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
