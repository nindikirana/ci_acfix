<?php

class depetik_model extends CI_MODEL
{
    public function getDetail_pemesanan_tiket($id_detail_pemesanan = null)
    {

        if( $id_detail_pemesanan === null )  {
            return $this->db->get('detail_pemesanan_tiket')->result_array();
        } else {
            return $this->db->get_where('detail_pemesanan_tiket', ['Id_Detail_Pemesanan' => $id_detail_pemesanan])->result_array();
           
        }
   
}
    public function deleteDetail_pemesanan_tiket($id_detail_pemesanan)
    {
        $this->db->delete('detail_pemesanan_tiket', ['Id_Detail_Pemesanan' => $id_detail_pemesanan]);
        return $this->db->affected_rows(); 
    }

    public function createDetail_pemesanan_tiket($petik)
    {
        $this->db->insert('detail_pemesanan_tiket', $petik);
        return $this->db->affected_rows();
    }

    public function updateDetail_pemesanan_tiket($petik, $id_detail_pemesanan)
    {
       return $this->db->update('detail_pemesanan_tiket', $petik , ['Id_Detail_Pemesanan' => $id_detail_pemesanan]);
       // return// $this->db//->affected_rows();
    }
}