<?php 


class Daftar extends CI_Controller{

	public function __construct(){
        parent::__construct();
        $this->load->model("M_daftar");
        $this->load->library('form_validation');
    }

	public function index()
	{
		$form_perusahaan = $this->M_daftar;
        $validation = $this->form_validation;
        $validation->set_rules($form_perusahaan->rules());

        if ($validation->run())
        {
            $form_perusahaan->save();
            $this->session->set_flashdata('success', 'Berhasil di simpan');
        }

        $this->load->view("daftar");
	}

	public function add(){
        $query = $this->db->get("form_perusahaan");
        $data['form_perusahaan'] = $query->result_array();
        $inputan = $this->input->post();
        if($inputan){
            $this->db->insert("form_perusahaan", $inputan);
            redirect("form", "refresh");
        }

        $this->load->view('form', $data);
    }

	// function form()
	// {
	// 	$query = $this->db->get("form_perusahaan");
	// 	$data['form_perusahaan'] = $query->result_array();
	// 	$inputan = $this->input->post();
	// 	if($inputan){
	// 		$this->db->insert("form_perusahaan", $inputan);
	// 		redirect("form", "refresh");
	// 	}
	// 	$this->load->view('daftar', $data);
	// }

}