<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Login extends CI_Controller {

public function __construct()
{
    parent::__construct();
    $this->load->model('Login_model');
    
}
	

	public function proses() {
	
		$response = new stdClass();
		$email=$this->input->post('Email');
		$password=md5($this->input->post('Password'));

		if ((empty($email)) || (empty($password))) { 
		
		$response->success = 0;
		$response->message = "Lengkapi email dan password"; 
		die(json_encode($response));
		}
		$cek = $this->Login_model->Getuser(array('Email' => $email, 'Password' => $password));
		$hasil = $cek->result_array();
		
		if ($cek->num_rows() > 0) {
		 
				$response->success = 1;
				$response->message = "Selamat datang ".$hasil[0]['Username'];
				$response->id = $hasil[0]['Id_User'];
					$response->Username = $hasil[0]['Username'];
				$response->Email = $hasil[0]['Email'];
					$response->Password = $hasil[0]['Password'];
						$response->No_Telp = $hasil[0]['No_Telp'];
							$response->Id_Level = $hasil[0]['Id_Level'];
				die(json_encode($response));
			
		}
		else {
				$response->success = 0;
				$response->message = "Email atau password salah woi";
				die(json_encode($response));
		}
	}
}