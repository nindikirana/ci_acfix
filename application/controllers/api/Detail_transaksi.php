<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Detail_transaksi extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('detailtransaksi_model');

    

    }
    public function index_get()
    {
       $id = $this->get('Id_Detail_Transaksi');
       $delete = $this->get('Delete');
       if($delete === true || $delete === 'true') {
            $this->deleteData($id);
            return;
       }
       if ($id === null) {

        $detailtransaksi = $this->detailtransaksi_model->getDetail_transaksi();

       } else {
        $detailtransaksi = $this->detailtransaksi_model->getDetail_transaksi($id);
        
       }
    
        if ($detailtransaksi) {
            $this->response([
                'status' => true,
                'data' => $detailtransaksi
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
               
                if ($this->detailtransaksi_model->deleteDetail_transaksi($id) > 0 ) {
    
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
        $id = $this->delete('Id_Detail_Transaksi');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
           
            if ($this->detailtransaksi_model->deleteDetail_transaksi($id) > 0 ) {

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
         $id = $this->post('Id_Detail_Transaksi');
        
        if ($id === null) {
        $detailtransaksi = [
            
            'Id_Detail_Transaksi' => "G".substr(uniqid(), 9),
            'Id_Transaksi' => $this->post('Id_Transaksi'),
            'Id_Kendaraan' => $this->post('Id_Kendaraan'),
            'Tgl_Sewa' => $this->post('Tgl_Sewa'),
            'Tgl_Akhir_Penyewaan' => $this->post('Tgl_Akhir_Penyewaan'),
            'Tgl_Pengembalian' => $this->post('Tgl_Pengembalian'),
            'Harga' => $this->post('Harga'),
            'Total' => $this->post('Total'),
            'Status_Kendaraan' => $this->post('Status_Kendaraan'),
            'Status' => $this->post('Status')
        ];

        if ($this->detailtransaksi_model->createDetail_transaksi($detailtransaksi) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'new detail transaksi created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

    }else {
            $detailtransaksi= [
           
            'Id_Transaksi' => $this->post('Id_Transaksi'),
            'Id_Kendaraan' => $this->post('Id_Kendaraan'),
            'Tgl_Sewa' => $this->post('Tgl_Sewa'),
            'Tgl_Akhir_Penyewaan' => $this->post('Tgl_Akhir_Penyewaan'),
            'Tgl_Pengembalian' => $this->post('Tgl_Pengembalian'),
            'Harga' => $this->post('Harga'),
            'Total' => $this->post('Total'),
            'Status_Kendaraan' => $this->post('Status_Kendaraan'),
            'Status' => $this->post('Status')
        ];
          
            if ($this->detailtransaksi_model->updateDetail_transaksi($detailtransaksi, $id) > 0) {
                $this->response([
                    'status' =>true,
                    'message' => 'Detail Transaksi updated.'
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
        $id = $this->post('Id_Detail_Transaksi');
        $detailtransaksi= [
            
        
            'Id_Transaksi' => $this->post('Id_Transaksi'),
            'Id_Kendaraan' => $this->post('Id_Kendaraan'),
            'Tgl_Sewa' => $this->post('Tgl_Sewa'),
            'Tgl_Akhir_Penyewaan' => $this->post('Tgl_Akhir_Penyewaan'),
            'Tgl_Pengembalian' => $this->post('Tgl_Pengembalian'),
            'Harga' => $this->post('Harga'),
            'Total' => $this->post('Total'),
            'Status_Kendaraan' => $this->post('Status_Kendaraan'),
            'Status' => $this->post('Status')
            
         ];
    
        if ($this->detailtransaksi_model->updateDetail_transaksi($detailtransaksi, $id) > 0) {
            $this->response([
                'status' =>true,
                'message' => 'detail transaksi updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to updated data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
