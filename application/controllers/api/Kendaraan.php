<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Kendaraan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kendaraan_model');

    

    }
    public function index_get()
    {
       $id = $this->get('Id_Kendaraan');
       $delete = $this->get('Delete');
       if($delete === true || $delete === 'true') {
            $this->deleteData($id);
            return;
       }
       
       if ($id === null) {

        $kendaraan = $this->kendaraan_model->getKendaraan();

       } else {
        $kendaraan = $this->kendaraan_model->getKendaraan($id);
        
       }
    
        if ($kendaraan) {
            $this->response([
                'status' => true,
                'data' => $kendaraan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }

    public function deleteData($id){
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->kendaraan_model->deleteKendaraan($id) > 0 ) {
                $this->set_response([
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
    public function index_delete()
    {
        $id = $this->delete('Id_Kendaraan');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->kendaraan_model->deleteKendaraan($id) > 0 ) {

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
        $id = $this->post('Id_Kendaraan');
        if ($id === null) {
        $kendaraan = [
            
            'Id_Kendaraan' => "K".substr(uniqid(), 9),
            'Id_Jenis' => $this->post('Id_Jenis'),
            'Id_Driver' => $this->post('Id_Driver'),
            'Merk' => $this->post('Merk'),
            'Seri' => $this->post('Seri'),
            'Kelas' => $this->post('Kelas'),
            'Seat' => $this->post('Seat'),
            'Plat_Nomor' => $this->post('Plat_Nomor'),
            'Harga' => $this->post('Harga'),
            'Status_Sewa' => $this->post('Status_Sewa'),
            'Status_Kendaraan' => $this->post('Status_Kendaraan')
           
        ];

        if ($this->kendaraan_model->createKendaraan($kendaraan) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'new Kendaraan created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }else {
            $kendaraan= [
                
            'Id_Jenis' => $this->post('Id_Jenis'),
            'Id_Driver' => $this->post('Id_Driver'),
            'Merk' => $this->post('Merk'),
            'Seri' => $this->post('Seri'),
            'Kelas' => $this->post('Kelas'),
            'Seat' => $this->post('Seat'),
            'Plat_Nomor' => $this->post('Plat_Nomor'),
            'Harga' => $this->post('Harga'),
            'Status_Sewa' => $this->post('Status_Sewa'),
            'Status_Kendaraan' => $this->post('Status_Kendaraan')
            
             ];
          
            if ($this->kendaraan_model->updateKendaraan($kendaraan, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'Kendaraan updated.'
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
     
        $id = $this->post('Id_Kendaraan');
        $kendaraan = [
            
            'Id_Jenis' => $this->post('Id_Jenis'),
            'Id_Driver' => $this->post('Id_Driver'),
            'Merk' => $this->post('Merk'),
            'Seri' => $this->post('Seri'),
            'Kelas' => $this->post('Kelas'),
            'Seat' => $this->post('Seat'),
            'Plat_Nomor' => $this->post('Plat_Nomor'),
            'Harga' => $this->post('Harga'),
            'Status_Sewa' => $this->post('Status_Sewa'),
            'Status_Kendaraan' => $this->post('Status_Kendaraan')
           
        ];
    
        if ($this->kendaraan_model->updateKendaraan($kendaraan, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'Kendaraan updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
