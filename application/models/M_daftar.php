<?php 

class M_daftar extends CI_Model{
	private $_table = "form_perusahaan";

    public $id_formperusahaan;
    public $nama_perusahaan;
    public $alamat_email;
    public $di_butuhkan;
    public $alamat_perusahaan;
    public $kota;
	public $keterangan;
	
	public function rules()
    {
        return [
            ['field' => 'id_formperusahaan','label' => 'id_formperusahaan','rules' => 'required'],
            ['field' => 'nama_perusahaan','label' => 'nama_perusahaan','rules' => 'required'],
            ['field' => 'alamat_email','label' => 'alamat_email','rules' => 'required'],
            ['field' => 'di_butuhkan','label' => 'di_butuhkan','rules' => 'required'],
            ['field' => 'alamat_perusahaan','label' => 'alamat_perusahaan','rules' => 'required'],
            ['field' => 'kota','label' => 'kota','rules' => 'required'],
            ['field' => 'keterangan','label' => 'keterangan','rules' => 'required']
        ];
    }

	public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }

    public function getById($id)
    {
         return $this->db->get_where($this->_table, ["id_formperusahaan" => $id])->row();
    }
    public function save()
    {
        $post = $this->input->post();
        $this->id_formperusahaan = uniqid();
        $this->nama_perusahaan = $post["nama_perusahaan"];
        $this->alamat_email = $post["alamat_email"];
        $this->di_butuhkan = $post["di_butuhkan"];
        $this->alamat_perusahaan = $post["alamat_perusahaan"];
        $this->kota = $post["kota"];
        $this->keterangan = $post["keterangan"];
        $this->db->insert($this->_table, $this);
	}
	
	function tampil_perusahaan()
	{
		$query = $this->db->get("form_perusahaan");
		$data_array = $query->result_array();
		return $data_array;
	}

	

	function update_form($id_formperusahaan,$data)
    {
        $this->db->where('id_formperusahaan',$id_formperusahaan);
        return $this->db->update('form_perusahaan',$data);
    }

	function detail_daftar($id_formperusahaan)
	{
		$this->db->where('form_perusahaan.id_formperusahaan', $id_formperusahaan);
		$query = $this->db->get('form_perusahaan');
		$data_array = $query->row_array();
		return $data_array;
	}

    public function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function edit($id_formperusahaan)
	{

		$query = $this->db->where("id_formperusahaan", $id_formperusahaan)->get("form_perusahaan");
		if($query){

			return $query->row();

		}else{

			return false;

		}
    }
    
    public function update($data, $id)
	{
        $query = $this->db->update("form_perusahaan", $data, $id);

		if($query){
			return true;
		}else{
			return false;
		}
	}
    
    function tampil_data()

	{

		return $this->db->get('form_perusahaan');  

	}
}
