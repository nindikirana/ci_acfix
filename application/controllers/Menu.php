<?php
require "Base.php";

class Menu extends REST_Base
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('menu_model');
    $token = $this->token_auth();
      if ($token == false) {
          $this->output_response['message'] = 'Unauthorized';
          $this->response($this->output_response, 401);
      }
  }

  public function index_get()
  {
    if (!empty($this->get('menu_id')) && empty($this->get('parent_id'))) {
      $menu_id = $this->get('menu_id');
      $result = $this->menu_model->get_menu_by_id($menu_id);
    } else if (!empty($this->get('parent_id')) && empty($this->get('menu_id'))) {
      $parent_id = $this->get('parent_id');
      $temp_result = $this->menu_model->get_menu_by_parent($parent_id);
      $result=[];
      foreach($temp_result as $index => $row){
          $temp=$this->menu_model->get_menu_by_parent($row->menu_id);
          foreach($temp as $idx=>$rw){
              $result[]=$rw;
          }
      }
    } else {
      $result = $this->menu_model->get_all_menu();
    }

    $this->output_response['status'] = 'success';
    $this->output_response['message'] = 'success';
    $this->output_response['data'] = $result;
    $this->response($this->output_response, 200);
  }
}
