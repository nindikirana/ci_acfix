<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

	public function __construct()
	{
    parent::__construct();
    $this->load->model("M_daftar");
    $this->load->library('form_validation');
    }

	public function index()
	{
		$data["form_perusahaan"] = $this->M_daftar->getAll();
		$query = $this->db->get("form_perusahaan");
		$data["form_perusahaan"] = $query->result_array();
		$this->load->view("form", $data);
	}

	// public function delete()
    // {
    //     // if (!isset($id_formperusahaan)) show_404();
        
    //     // if ($this->M_daftar->delete($id_formperusahaan)) {
    //     //     redirect(site_url('form'));
	// 	// }
		
	// 	$where = array('id_formperusahaan' => $id_formperusahaan);
	// 	$this->M_daftar->delete($where,'form_perusahaan');
	// 	redirect('form');
	// }

	function delete($id_formperusahaan){
		$where = array('id_formperusahaan' => $id_formperusahaan);
		$this->M_daftar->delete($where,'form_perusahaan');
		redirect('form');
	}
	
	public function edit($id_formperusahaan)
	{
		$id_formperusahaan = $this->uri->segment(3);

		$data = array(
			
			'form_perusahaan' => $this->M_daftar->edit($id_formperusahaan)
		);

		$this->load->view('edit_form', $data);
	}

	public function update($id_formperusahaan)
	{
		$id['id_formperusahaan'] = $this->input->post("id_formperusahaan");
		$data = array(
			'nama_perusahaan' 	=> $this->input->post("nama_perusahaan"),
			'alamat_email' 	=> $this->input->post("alamat_email"),
			'di_butuhkan' 		=> $this->input->post("di_butuhkan"),
			'alamat_perusahaan' 	=> $this->input->post("alamat_perusahaan"),
			'kota' 			=> $this->input->post("kota"),
			'keterangan' 		=> $this->input->post("keterangan"),
		);
		$this->M_daftar->update($data, $id);

		$this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible"> Success! data berhasil diupdate didatabase.
			                                    </div>');

		//redirect
		redirect('form');

	}


	/*public function hapus($form_perusahaan)
	{
		$where = array('form_perusahaan' => $form_perusahaan);
		$this->M_daftar->hapus($where,'form_perusahaan');
		redirect('form');
	}*/

	/*function tampil_daftar()
	{

		$query = $this->db->get("form_perusahaan");
		$data['form_perusahaan'] = $query->result_array();
		$this->load->view('form', $data);
	}*/

}