<?php

class Component_model extends CI_Model
{
  public function get_all_city()
  {
    $query = $this->db->get('location_city');
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }
  public function get_all_country()
  {
    $query = $this->db->get('location_country');
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }
  public function get_all_province()
  {
    $query = $this->db->get('location_province');
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }
  public function get_all_spot()
  {
    $query = $this->db->get('location_spot');
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }
  public function get_all_districts()
  {
    $query = $this->db->get('location_districts');
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }

  public function get_all_tags()
  {
    $sql = "SELECT tags.id as tags_id, tags.title as slug_title ,
            tags.slug as tags_slug, tags_kt_lang.slug as tags_kt_slug
            From tags 
            JOIN tags_kt ON tags.tags_kt_id = tags_kt.id
            JOIN tags_kt_lang ON tags_kt_lang.tags_kt_id = tags_kt.id
            JOIN acs_lang ON acs_lang.id = tags_kt_lang.acs_lang_id
            WHERE 1=1
            AND acs_lang.status = 1
            AND acs_lang.status_default = 1";
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }
}
