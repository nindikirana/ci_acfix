<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Kerusakan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kerusakan_model');
    }
    public function index_get()
    {
       $id = $this->get('Id_Kerusakan');
       $nama = $this->get('Nama_Kerusakan');
       $solusi = $this->get('Solusi');
     
        $kerusakan = $this->kerusakan_model->getKerusakan($id, $nama);
    
        if ($kerusakan) {
            $this->response([
                'status' => true,
                'data' => $kerusakan
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
        $id = $this->delete('Id_Kerusakan');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->kerusakan_model->deleteKerusakan($id) > 0 ) {

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
        $id = $this->post('Id_Kerusakan');
        if ($id === null) {
        $kerusakan = [
            
            'Id_Kerusakan' => "K".substr(uniqid(), 9),
            'Nama_Kerusakan' => $this->post('Nama_Kerusakan'),
            'Solusi' => $this->post('Solusi')
           
        ];

        if ($this->kerusakan_model->createKerusakan($kerusakan) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'new Kerusakan created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }else {
            $kerusakan= [
                
            'Nama_Kerusakan' => $this->post('Nama_Kerusakan'),
            'Solusi' => $this->post('Solusi')
            
             ];
          
            if ($this->kerusakan_model->updateKerusakan($kerusakan, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'Kerusakan updated.'
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
     
        $id = $this->put('Id_Kerusakan');
        $kerusakan = [
            
            'Nama_Kerusakan' => $this->put('Nama_Kerusakan'),
            'Solusi' => $this->put('Solusi')
           
        ];
    
        if ($this->kerusakan_model->updateKerusakan($kerusakan, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'Kerusakan updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
