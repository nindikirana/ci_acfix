<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Gejala extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('gejala_model');
    }
    public function index_get()
    {
       $id = $this->get('Id_Gejala');
       $nama = $this->get('Nama_Gejala');
     
        $gejala = $this->gejala_model->getGejala($id, $nama);
       
    
        if ($gejala) {
            $this->response([
                'status' => true,
                'data' => $gejala
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('Id_Gejala');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->gejala_model->deleteGejala($id) > 0 ) {

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

    public function index_post()
    {
        $id = $this->post('Id_Gejala');
        
        if ($id === null) {
            $gejala= [
                
                'Id_Gejala' => "G".substr(uniqid(), 9),
                'Nama_Gejala' => $this->post('Nama_Gejala')
               
            ];
    
            if ($this->gejala_model->createGejala($gejala) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'new gejala created.'
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to create new data!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $gejala= [
                 'Nama_Gejala' => $this->post('Nama_Gejala')
             ];
          
            if ($this->gejala_model->updateGejala($gejala, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'gejala updated.'
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
        $id = $this->put('Id_Gejala');
        $gejala= [
            
             'Nama_Gejala' => $this->put('Nama_Gejala')
         ];
            
        if ($this->gejala_model->updateGejala($gejala, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'gejala updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
