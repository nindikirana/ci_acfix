<?php

class detailtransaksi_model extends CI_MODEL
{
    public function getDetail_transaksi($id_detail_transaksi = null)
    {

        if( $id_detail_transaksi === null )  {
            return $this->db->get('detail_trans')->result_array();
        } else {
            return $this->db->get_where('detail_trans', ['Id_Detail_Transaksi' => $id_detail_transaksi])->result_array();
           
        }
   
}
    public function deleteDetail_transaksi($id_detail_transaksi)
    {
        $this->db->delete('detail_trans', ['Id_Detail_transaksi' => $id_detail_transaksi]);
        return $this->db->affected_rows(); 
    }

    public function createDetail_transaksi($detailtransaksi)
    {
        $this->db->insert('detail_trans', $detailtransaksi);
        return $this->db->affected_rows();
    }

    public function updateDetail_transaksi($transaksi, $id_detail_transaksi)
    {
       return $this->db->update('detail_trans', $transaksi , ['Id_Detail_Transaksi' => $id_detail_transaksi]);
       return $this->db->affected_rows();
    }
}