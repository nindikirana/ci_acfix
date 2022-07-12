<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pengetahuan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pengetahuan_model');
    }
    public function index_get()
    {
      
       $id_Kerusakan = $this->get('Id_Kerusakan');
       $id_Gejala = $this->get('Id_Gejala');
      
        $pengetahuan = $this->pengetahuan_model->getPengetahuan($id_Gejala,$id_Kerusakan);
    
    
        if ($pengetahuan) {
            $this->response([
                'status' => true,
                'data' => $pengetahuan
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
        $id = $this->delete('Id_Pengetahuan');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->pengetahuan_model->deletePengetahuan($id) > 0 ) {

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
        $id = $this->post('Id_Pengetahuan');
        
        if ($id === null) {
            $pengetahuan= [
                'Id_Pengetahuan' => $this->post('Id_Pengetahuan'),
                'Id_Kerusakan' => $this->post('Id_Kerusakan'),
                'Id_Gejala' => $this->post('Id_Gejala')         
            ];
    
            if ($this->pengetahuan_model->createPengetahuan($pengetahuan) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'new pengetahuan created.'
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to create new data!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $pengetahuan= [
                'Id_Kerusakan' => "K".substr(uniqid(), 9),
                'Id_Gejala' => "G".substr(uniqid(), 9)
             ];
          
            if ($this->pengetahuan_model->updatePengetahuan($pengetahuan, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'pengetahuan updated.'
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
        $id = $this->put('Id_Pengetahuan');
        $pengetahuan= [
            
              'Id_Kerusakan' => $this->put('Id_Kerusakan'),
              'Id_Gejala' => $this->put('Id_Gejala')
         ];
            
        if ($this->pengetahuan_model->updatePengetahuan($pengetahuan, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'pengetahuan updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}