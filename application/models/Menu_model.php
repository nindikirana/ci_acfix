<?php

class Menu_model extends CI_Model
{
  private $general_select = "SELECT menu_as.id as menu_id, 
                            menu_as_det.title as menu_title, menu_as_det.slug as menu_slug
                            ";
  private $general_from   = " FROM menu menu_as ";
  private $general_join   = "JOIN menu_lang menu_as_det ON menu_as.id = menu_as_det.menu_id 
                            JOIN acs_lang menu_as_lang ON menu_as_det.acs_lang_id = menu_as_lang.id ";
  private $general_where  = "WHERE 1=1 AND menu_as_lang.status_default = ?
                            AND menu_as_lang.status = ? ";
  private $general_group  = "GROUP BY menu_as.id ";
  private $general_order  = "ORDER BY menu_as.ordering ASC";

  public function get_all_menu()
  {
    $main_sql = '';
    $main_sql .= $this->general_select;
    $main_sql .= ", menu_as.parent as parent_id, 
                    mn_lg.title as parent_title ";
    $main_sql .= $this->general_from;
    $main_sql .= $this->general_join;
    $main_sql .= "LEFT JOIN menu menu_2 ON menu_as.parent = menu_2.id
                  LEFT JOIN menu_lang mn_lg ON menu_2.id = mn_lg.menu_id ";
    $main_sql .= $this->general_where;
    $main_sql .= $this->general_group;
    $main_sql .= $this->general_order;
    $main_sql .= ", menu_as_det.title ASC ";

    $parameter = [1, 1];
    $query = $this->db->query($main_sql, $parameter);
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }

  public function get_menu_by_id($params = null)
  {
    $main_sql = '';
    $main_sql .= $this->general_select;
    $main_sql .= ", menu_as.parent as parent_id, 
                    mn_lg.title as parent_title ";
    $main_sql .= $this->general_from;
    $main_sql .= $this->general_join;
    $main_sql .= "LEFT JOIN menu menu_2 ON menu_as.parent = menu_2.id
                  LEFT JOIN menu_lang mn_lg ON menu_2.id = mn_lg.menu_id ";
    $main_sql .= $this->general_where;
    $main_sql .= " AND menu_as.id = ? ";
    $main_sql .= $this->general_group;
    $main_sql .= $this->general_order;
    $main_sql .= ", menu_as_det.title ASC ";

    $parameter = [1, 1];
    if (!empty($params)) {
      array_push($parameter, $params);
    } else {
      array_push($parameter, 0);
    }

    $query = $this->db->query($main_sql, $parameter);
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }
    
  public function get_menu_by_parent($params = null)
  {
    $main_sql = '';
    $main_sql .= $this->general_select;
    $main_sql .= ", menu_as.parent as parent_id, 
                    mn_lg.title as parent_title ";
    $main_sql .= $this->general_from;
    $main_sql .= $this->general_join;
    $main_sql .= "LEFT JOIN menu menu_2 ON menu_as.parent = menu_2.id
                  LEFT JOIN menu_lang mn_lg ON menu_2.id = mn_lg.menu_id ";
    $main_sql .= $this->general_where;
    $main_sql .= " AND menu_as.parent = ? ";
    $main_sql .= $this->general_group;
    $main_sql .= $this->general_order;
    $main_sql .= ", menu_as_det.title ASC ";

    $parameter = [1, 1];
    if (!empty($params)) {
      array_push($parameter, $params);
    } else {
      array_push($parameter, 0);
    }

    $query = $this->db->query($main_sql, $parameter);
    if ($query->num_rows() > 0) {
      $result = $query->result();
      return $result;
    } else {
      return array();
    }
  }

  public function get_recent_article($params = null)
  {
    $main_sql =
      "";
  }

  public function get_menu_by_menu_slug($params = null)
  {
    $sql   = 'SELECT
                menu_as.id as menu_id, 
                menu_as_det.title as menu_title, menu_as_det.slug as menu_slug
              FROM menu menu_as
              JOIN menu_lang menu_as_det ON menu_as.id = menu_as_det.menu_id
              JOIN acs_lang menu_as_lang ON menu_as_det.acs_lang_id = menu_as_lang.id
              WHERE 1=1
                AND menu_as_lang.status_default = ?
                AND menu_as_lang.status = ?
                AND menu_as_det.slug = ?
              GROUP BY menu_as.id
              ORDER BY menu_as.ordering ASC';

    /* SET PARAMETER ON WHERE */
    $parameter = [1, 1];
    if (!empty($params)) {
      if (is_array($params)) {
        $parameter = array_merge($parameter, $params);
      } else {
        array_push($parameter, $params);
      }
    }
    $query = $this->db->query($sql, $parameter);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      return $result;
    } else {
      return array();
    }
  }

  public function get_menu_and_child_by_menu_slug($params = null)
  {
    $output = [];
    $sql    = "SELECT menu_1.id as level_1_id, menu_1_det.title as level_1_title, menu_1_det.slug as level_1_slug,
                      menu_2.id as level_2_id, menu_2_det.title as level_2_title, menu_2_det.slug as level_2_slug,
                      menu_3.id as level_3_id, menu_3_det.title as level_3_title, menu_3_det.slug as level_3_slug
                    FROM menu menu_1
                    JOIN menu_lang menu_1_det ON menu_1.id = menu_1_det.menu_id
                    JOIN acs_lang menu_1_lang ON menu_1_det.acs_lang_id = menu_1_lang.id
                    
                    LEFT JOIN menu menu_2 ON menu_2.parent = menu_1.id
                        LEFT JOIN menu_lang menu_2_det ON menu_2.id = menu_2_det.menu_id
                        LEFT JOIN acs_lang menu_2_lang ON menu_2_det.acs_lang_id = menu_2_lang.id
                    
                    LEFT JOIN menu menu_3 ON menu_3.parent = menu_2.id
                        LEFT JOIN menu_lang menu_3_det ON menu_3.id = menu_3_det.menu_id
                        LEFT JOIN acs_lang menu_3_lang ON menu_3_det.acs_lang_id = menu_3_lang.id
                        
                    WHERE 1=1
                      AND menu_1_lang.status_default = 1
                      AND (menu_2_lang.status_default = 1 OR menu_2_lang.status_default IS NULL)
                      AND (menu_3_lang.status_default = 1 OR menu_3_lang.status_default IS NULL)
                      AND menu_1_det.slug = ?

                    GROUP BY menu_1.id, menu_2.id, menu_3.id
                    ORDER BY menu_1.ordering ASC, menu_2.ordering ASC, menu_3.ordering ASC";

    $query  = $this->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->result_array();
      $query->free_result();

      foreach ($result as $index => $row) {
        if (!in_array($row['level_1_id'], $output)) {
          $output[] = $row['level_1_id'];
        }
        if (!in_array($row['level_2_id'], $output)) {
          $output[] = $row['level_2_id'];
        }
        if (!in_array($row['level_3_id'], $output)) {
          $output[] = $row['level_3_id'];
        }
      }
      $output = array_filter($output);
      return $output;
    } else {
      return array();
    }
  }
}
