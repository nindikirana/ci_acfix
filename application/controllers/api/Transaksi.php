<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Transaksi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model');

    

    }
    public function index_get()
    {
      $id = $this->get('Id_Transaksi');
       $delete = $this->get('Delete');
       if($delete === true || $delete === 'true') {
            $this->deleteData($id);
            return;
       }
       
       if ($id === null) {

        $transaksi = $this->transaksi_model->getTransaksi();

       } else {
        $transaksi = $this->transaksi_model->getTransaksi($id);
        
       }
    
        if ($transaksi) {
            $this->response([
                'status' => true,
                'data' => $transaksi
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
               
                if ($this->transaksi_model->deleteTransaksi($id) > 0 ) {
    
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
        $id = $this->delete('Id_Transaksi');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->transaksi_model->deleteTransaksi($id) > 0 ) {

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
        $id = $this->post('Id_Transaksi');
        
        if ($id === null) {
        $transaksi = [
            
            'Id_Transaksi' => "T".substr(uniqid(), 9),
            'Id_User' => $this->post('Id_User'),
            'Tgl_Booking' => $this->post('Tgl_Booking'),
            'Total_Pembayaran' => $this->post('Total_Pembayaran'),
            'Tgl_Pembayaran' => $this->post('Tgl_Pembayaran'),
            'Bukti_Pembayaran' => $this->post('Bukti_Pembayaran'),
            'Status_Pembayaran' => $this->post('Status_Pembayaran'),
            'Status_Transaksi' => $this->post('Status_Transaksi')
          
        ];

        if ($this->transaksi_model->createTransaksi($transaksi) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'new Transaksi created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }else {
            $transaksi = [
            
            'Id_User' => $this->post('Id_User'),
            'Tgl_Booking' => $this->post('Tgl_Booking'),
            'Total_Pembayaran' => $this->post('Total_Pembayaran'),
            'Tgl_Pembayaran' => $this->post('Tgl_Pembayaran'),
            'Bukti_Pembayaran' => $this->post('Bukti_Pembayaran'),
            'Status_Pembayaran' => $this->post('Status_Pembayaran'),
            'Status_Transaksi' => $this->post('Status_Transaksi')
          
        ];
          
            if ($this->transaksi_model->updateTransaksi($transaksi, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'Transaksi updated.'
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
        $id = $this->post('Id_Transaksi');
        $transaksi = [
            
            'Id_User' => $this->post('Id_User'),
            'Tgl_Booking' => $this->post('Tgl_Booking'),
            'Total_Pembayaran' => $this->post('Total_Pembayaran'),
            'Tgl_Pembayaran' => $this->post('Tgl_Pembayaran'),
            'Bukti_Pembayaran' => $this->post('Bukti_Pembayaran'),
            'Status_Pembayaran' => $this->post('Status_Pembayaran'),
            'Status_Transaksi' => $this->post('Status_Transaksi')
          
        ];
    
        if ($this->transaksi_model->updateTransaksi($transaksi, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => ' updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
