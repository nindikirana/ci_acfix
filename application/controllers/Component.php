<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Component extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('component_model');
    }
    public function city_get()
    {
        $result = $this->component_model->get_all_city();
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
    public function spot_get()
    {
        $result = $this->component_model->get_all_spot();
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
    public function country_get()
    {
        $result = $this->component_model->get_all_country();
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
    public function province_get()
    {
        $result = $this->component_model->get_all_province();
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
    public function districts_get()
    {
        $result = $this->component_model->get_all_districts();
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
    public function tags_get()
    {
        $result = $this->component_model->get_all_tags();
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
}
