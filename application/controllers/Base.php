<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class REST_Base extends REST_Controller
{
    public $auth_key = 'k5EtniDUSUcnBl8JbOmQUIZ3u0vwywUvaSG1JY4Bi2tVcf9vVIybuaFkjrOp96ZYOzRsjSA2o9EnXOnRsCiqTZ67wu9LzEa4AFL3x4raAAqmxFWYDNmxwB2uojXNKSIHzNwDkkU1f3snXojLjoC28lg1OhugnwB4dNz47jurbvtmg42SpvgvltMwKCHLoRvFADRmsvVx';
    public $user_agent_key = 'cXga8RNKKHxBDtvy5TRWoy5ucWWjtHEmaRIOYchLtjTg2qB37yYSJI9XnnVm0JMGCTN3BR0ziK9HS3vjvkKpBQqliUTDVv8byQIZMBC1aZnUtUpJpDuWveUq4AzVkde0vs4J2UkFWJpuJoTojTwr0yq6BhZPwY4QkITUqyF3s9vGv3arHDgiOBcWGfFzeqMogS98bPFW';
  protected $output_response = array(
    'status' => 'error',
    'message' => '',
    'data' => ''
  );

  public function __construct()
  {
      parent::__construct();
      $key = $this->key_auth();
      if ($key == false) {
          $this->output_response['message'] = 'Service Unvailable for your request';
          $this->response($this->output_response, REST_Controller::HTTP_UNAUTHORIZED);
      }
  }

  public function key_auth()
  {
    $header = $this->input->request_headers();
    if (array_key_exists('Authorization', $header) && !empty($header['Authorization'])) {
//      echo '<pre>';
//      var_dump($header['Authorization']);
//      var_dump($this->auth_key);
//      die();
        if($header['Authorization']==$this->auth_key){
            if (array_key_exists('User-Agent', $header) && !empty($header['User-Agent'])) {
                if($header['User-Agent']==$this->user_agent_key){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
    return false;
  }
    
  public function token_auth()
  {
    $header = $this->input->request_headers();
    if (array_key_exists('x-api-key', $header) && !empty($header['x-api-key'])) {
      $decode = AUTHORIZATION::validateTimestamp($header['x-api-key']);
      if ($decode != false) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }

  public function check_empty($var = null)
  {
    if (empty($var)) {
      return null;
    } else {
      return $var;
    }
  }
}
