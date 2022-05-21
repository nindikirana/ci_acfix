<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Driver extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('driver_model');


    }
    public function index_get()
    {
       $id = $this->get('Id_Driver');
       $delete = $this->get('Delete');
       if($delete === true || $delete === 'true') {
            $this->deleteData($id);
            return;
       }
       
       if ($id === null) {

        $driver = $this->driver_model->getDriver();

       } else {
        $driver = $this->driver_model->getDriver($id);
        
       }
    
        if ($driver) {
            $this->response([
                'status' => true,
                'data' => $driver
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
               
                if ($this->driver_model->deleteDriver($id) > 0 ) {
    
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
        $id = $this->delete('Id_Driver');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->driver_model->deleteDriver($id) > 0 ) {

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
        $id = $this->post('Id_Driver');
        
        if ($id === null) {
            $driver= [
                
                'Id_Driver' => "D".substr(uniqid(), 9),
                'Nama' => $this->post('Nama'),
                'No_KTP' => $this->post('No_KTP'),
                'Alamat' => $this->post('Alamat'),
                'No_Telp' => $this->post('No_Telp'),
                'Jenis_SIM' => $this->post('Jenis_SIM'),
                'No_SIM' => $this->post('No_SIM')
               
            ];
    
            if ($this->driver_model->createDriver($driver) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'new driver created.'
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to create new data!',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $driver= [
                 'Nama' => $this->post('Nama'),
                 'No_KTP' => $this->post('No_KTP'),
                 'Alamat' => $this->post('Alamat'),
                 'No_Telp' => $this->post('No_Telp'),
                 'Jenis_SIM' => $this->post('Jenis_SIM'),
                 'No_SIM' => $this->post('No_SIM')
             ];
          
            if ($this->driver_model->updateDriver($driver, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'driver updated.'
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
       // $id = $this->put('Id_Driver');
        $id = $this->post('Id_Driver');
        $driver= [
            
             'Nama' => $this->post('Nama'),
             'No_KTP' => $this->post('No_KTP'),
             'Alamat' => $this->post('ALamat'),
             'No_Telp' => $this->post('No_Telp'),
             'Jenis_SIM' => $this->post('Jenis_SIM'),
             'No_SIM' => $this->post('No_SIM')
         ];
         
        // print_r($driver);
        // exit();
        
     /*   if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else { */
            
        if ($this->driver_model->updateDriver($driver, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'driver updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
