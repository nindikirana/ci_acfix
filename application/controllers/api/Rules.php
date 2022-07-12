<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Rules extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('deteksi_model');
 

    }
  
    public function index_post(){
        $values = json_decode(file_get_contents('php://input'),true); 
        $sp = $this->deteksi_model->rules($values);
        if($sp){
             $this->response([
                'status' => true,
                'data' => $sp
            ], REST_Controller::HTTP_OK);
        }else{
             $this->response([
                'status' => false,
                'data' => $sp
            ], REST_Controller::HTTP_NOT_FOUND);
        }
}
}
