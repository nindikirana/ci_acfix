<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Deteksi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('deteksi_model');
 

    }
    public function index_get()
    {
       $id = $this->get('Id_Gejala');
       
       if ($id === null) {

        $deteksi = $this->deteksi_model->getDeteksi();

       } else {
        $deteksi = $this->deteksi_model->getDeteksi($id);
        
       }
    
        if ($deteksi) {
            $this->response([
                'status' => true,
                'data' => $deteksi
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
               
                if ($this->deteksi_model->deleteDeteksi($id) > 0 ) {
    
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
        $id = $this->delete('Id_Deteksi');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->deteksi_model->deleteDeteksi($id) > 0 ) {

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
        $id = $this->post('Id_Deteksi');
        
        if ($id === null) {
            $deteksi= [
                
                'Id_Deteksi' => "D".substr(uniqid(), 9),
                'Id_Gejala' => $this->post('Id_Gejala'),
                'Pertanyaan' => $this->post('Pertanyaan'),
                'Ya' => $this->post('Ya'),
                'Tidak' => $this->post('Tidak')
               
            ];
    
            if ($this->deteksi_model->createDeteksi($deteksi) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'new deteksi created.'
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to create new data!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $deteksi= [
                'Id_Gejala' => $this->post('Id_Gejala'),
                'Pertanyaan' => $this->post('Pertanyaan'),
                'Ya' => $this->post('Ya'),
                'Tidak' => $this->post('Tidak')
               
             ];
          
            if ($this->deteksi_model->updateDeteksi($deteksi, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'deteksi updated.'
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
       
        $id = $this->post('Id_Deteksi');
        $deteksi= [
            
                'Id_Gejala' => $this->post('Id_Gejala'),
                'Pertanyaan' => $this->post('Pertanyaan'),
                'Ya' => $this->post('Ya'),
                'Tidak' => $this->post('Tidak')
         ];
         
   
        if ($this->deteksi_model->updateDeteksi($deteksi, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'deteksi updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
