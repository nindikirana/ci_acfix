<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Jenis_kendaraan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jeniskendaraan_model');

    }
    public function index_get()
    {
       $id = $this->get('Id_Jenis');
       $delete = $this->get('Delete');
       if($delete === true || $delete === 'true') {
            $this->deleteData($id);
            return;
       }
       
       if ($id === null) {

        $jenis = $this->jeniskendaraan_model->getJenis_kendaraan();

       } else {
        $jenis = $this->jeniskendaraan_model->getJenis_kendaraan($id);
        
       }
    
        if ($jenis) {
            $this->response([
                'status' => true,
                'data' => $jenis
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
               
                if ($this->jeniskendaraan_model->deleteJenis_kendaraan($id) > 0 ) {
    
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
        $id = $this->delete('Id_Jenis');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->jeniskendaraan_model->deleteJenis_kendaraan($id) > 0 ) {

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
        $id = $this->post('Id_Jenis');
        
        if ($id === null) {
        $jenis = [
            
           'Id_Jenis' => "J".substr(uniqid(), 9),
            'Jenis' => $this->post('Jenis')
          
           
        ];

        if ($this->jeniskendaraan_model->createJenis_kendaraan($jenis) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'new Jenis kendaraan created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }else {
             $jenis = [
                 
            'Jenis' => $this->post('Jenis')
        ];

          
            if ($this->jeniskendaraan_model->updateJenis_kendaraan($jenis, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'Jenis Kendaraan updated.'
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
        $id = $this->post('Id_Jenis');
        $jenis = [
            'Id_Jenis' => $this->post('Id_Jenis'),
            'Jenis' => $this->post('Jenis')
           
        ];
    
        if ($this->jeniskendaraan_model->updateJenis_kendaraan($jenis, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'Jenis kendaraan updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
