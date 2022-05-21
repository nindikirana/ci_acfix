<?php
require "Base.php";

class Question extends REST_Base
{
    private $general_model = "question_model";

    public function __construct()
    {
        parent::__construct();
        $this->load->model($this->general_model);
        $this->load->model('logs_model');
        $token = $this->token_auth();
        if ($token == false) {
          $this->output_response['message'] = 'Unauthorized';
          $this->response($this->output_response, 401);
        }
    }

    public function index_get()
    {
        
        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        if(!empty($this->get('user_id'))){
            $user_id=$this->check_empty($this->get('user_id'));
            $params = array($user_id, $start, $limit);
            $result = $this->{$this->general_model}->get_comment_by_user_id($params);
            $this->output_response['status'] = 'success';
            $this->output_response['message'] = 'success';
            $this->output_response['data'] = $result;
            $this->response($this->output_response, 200);
        }else if(!empty($this->get('id'))){
            $article_id=$this->check_empty($this->get('id'));
            $params = array($article_id, $start, $limit);
            $result = $this->{$this->general_model}->get_comment_by_post_id($params);
            $this->output_response['status'] = 'success';
            $this->output_response['message'] = 'success';
            $this->output_response['data'] = $result;
            $this->response($this->output_response, 200);
        }else{
            $this->output_response['status'] = 'error';
            $this->output_response['message'] = 'Bad request';
            $this->output_response['data'] = [];
            $this->response($this->output_response, 400);
        }
    }
    
    public function add_post(){
        $data['id']             =strtoupper(date('ymd') . uniqid());
        $data['user_id']        =$this->input->post('user_id');
        $data['post_id']        =$this->input->post('post_id');
        if(!empty($this->input->post('parent'))){
            $data['parent']         =$this->input->post('parent');       
        }
        $data['subject']        =$this->input->post('subject');
        $data['message']        =$this->input->post('message');
        $data['ctb']            ='0';
        $data['ctd']            =date('Y-m-d H:i:s');
        $data['mdb']            ='0';
        $data['mdd']            =date('Y-m-d H:i:s');
        $result=$this->db->insert('post_comment',$data);
        if($result){
            $this->output_response['status'] = 'success';
            $this->output_response['message'] = 'success';
            $this->output_response['data'] = $result;
            $this->response($this->output_response, 200);
        }
    }
}
