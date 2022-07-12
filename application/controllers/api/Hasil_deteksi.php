<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Hasil_deteksi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('hasil_deteksi_model');
    }
    public function index_get()
    {
       $id = $this->get('Id_User');
       
       if ($id === null) {

        $deteksi = $this->hasil_deteksi_model->getDeteksi();

       } else {
        $deteksi = $this->hasil_deteksi_model->getDeteksi($id);
        
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
               
                if ($this->hasil_deteksi_model->deleteDeteksi($id) > 0 ) {
    
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
           
            if ($this->hasil_deteksi_model->deleteDeteksi($id) > 0 ) {

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
        $id = $this->post('Id_Deteksi');
        
        if ($id === null) {
        $deteksi = [
            
            'Id_Deteksi' => "D".substr(uniqid(), 9),
            'Id_User' => $this->post('Id_User'),
            'Id_Kerusakan' => $this->post('Id_Kerusakan'),
            //'Id_Gejala' => $this->post('Id_Gejala'),
            'Nama_Gejala' => $this->post('Nama_Gejala')
           
        ];
        

        if ($this->hasil_deteksi_model->createDeteksi($deteksi) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'Deteksi Berhasil ditambahkan.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }else {
            $deteksi = [
            
                'Id_User' => $this->post('Id_User'),
                'Id_Kerusakan' => $this->post('Id_Kerusakan'),
               // 'Id_Gejala' => $this->post('Id_Gejala'),
                'Nama_Gejala' => $this->post('Nama_Gejala')
            ];
          
            if ($this->hasil_deteksi_model->updateDeteksi($deteksi, $id) > 0) {
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
        $id = $this->put('Id_Deteksi');
        $deteksi = [
            'Id_User' => $this->put('Id_User'),
            'Id_Kerusakan' => $this->put('Id_Kerusakan'),
            //'Id_Gejala' => $this->put('Id_Gejala'),
            'Nama_Gejala' => $this->put('Nama_Gejala')
           
        ];
    
        if ($this->hasil_deteksi_model->updateDeteksi($deteksi, $id) > 0) {
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