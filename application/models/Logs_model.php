<?php

class logs_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set("Asia/Jakarta");
  }

  public function set_post_counter_logs($params = null)
  {
    $date_now = date('Y-m-d H:m:s');
    $parameter = [
      'post_id' => $params[0],
      'user_id' => $params[1],
      'log_ip_address' => $params[2],
      'log_client_browser' => $params[3],
      'ctd' => $date_now,
      'mdd' => $date_now
    ];

    $query = $this->db->insert('post_counter_log', $parameter);
    // $query = $this->db->query($sql, $parameter);
    return $query;
  }

  public function get_post_counter_logs_by($params = null)
  {
    $sql =
      "SELECT * 
    FROM post_counter_log
    WHERE 1=1
    AND post_id = ?
    AND user_id = ?
    AND log_ip_address = ? 
    AND mdd = ? ";

    $date = date(" Y - m - d H :i : s");
    array_push($params, $date);
    $query = $this->db->query($sql, $params);

    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }

  public function get_post_counter_by_post_id($params = null)
  {
    $date = date('Y-m-d');
    $sql = "SELECT * FROM post_counter
            WHERE 1=1
            AND post_id = ?
            AND log_date = ?";
    $query = $this->db->query($sql, array($params, $date));

    if ($query->num_rows() > 0) {
      $result = $query->row();
      return $result;
    } else {
      return array();
    }
  }

  public function set_counter_post($params = null)
  {
    $date_time = date('Y-m-d H:m:s');
    $date = date('Y-m-d');
    $parameter = [
      'post_id' => $params,
      'log_date' => $date,
      'counter' => 1,
      'ctd' => $date_time,
      'mdd' => $date_time
    ];

    $query = $this->db->insert('post_counter', $parameter);
    return $query;
  }

  public function update_post_counter($params = null)
  {
    $counter = $params->counter + 1;
    $date = date('Y-m-d H:m:s');
    $parameter = [
      'counter' => $counter,
      'mdd' => $date
    ];

    $this->db->where('post_id', $params->post_id);
    $this->db->where('log_date', $params->log_date);
    $this->db->update('post_counter', $parameter);
  }
}
