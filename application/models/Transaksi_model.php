<?php

class transaksi_model extends CI_MODEL
{
    public function getTransaksi($id_transaksi = null)
    {

        if( $id_transaksi === null )  {
            return $this->db->get('transaksi')->result_array();
        } else {
            return $this->db->get_where('transaksi', ['Id_Transaksi' => $id_transaksi])->result_array();
           
        }
   
}
    public function deleteTransaksi($id_transaksi)
    {
        $this->db->delete('transaksi', ['Id_Transaksi' => $id_transaksi]);
        return $this->db->affected_rows(); 
    }

    public function createTransaksi($transaksi)
    {
        $this->db->insert('transaksi', $transaksi);
        return $this->db->affected_rows();
    }

    public function updateTransaksi($transaksi, $id_transaksi)
    {
        return $this->db->update('transaksi', $transaksi, ['Id_Transaksi' => $id_transaksi]);
    }
}