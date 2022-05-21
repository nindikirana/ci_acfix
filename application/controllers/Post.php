<?php
require "Base.php";

class Post extends REST_Base
{
    private $general_model = "post_model";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->model('logs_model');
        $token = $this->token_auth();
        if ($token == false) {
          $this->output_response['message'] = 'Unauthorized';
          $this->response($this->output_response, 401);
        }
    }

    public function index_get()
    {
        $menu_id = $this->get('menu_id');
        if (empty($menu_id)) {
            $this->output_response['message'] = "Bad request, menu id not found";
            $this->response($this->output_response, 400);
        }

        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($menu_id, $start, $limit);

        $result = $this->{$this->general_model}->get_article_by_menu_id($params);

        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function all_post_get()
    {
        $menu_id = $this->get('menu_id');

        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($menu_id, $start, $limit);

        $result = $this->{$this->general_model}->get_article_all_by_menu_id($params);

        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
    

    public function detail_get()
    {
        $post_id = $this->get('post_id');
        $menu_id = $this->get('menu_id');
        if (empty($menu_id) and empty($post_id)) {
            $this->output_response['message'] = "Bad request, params menu id and post id not found";
            $this->response($this->output_response, 400);
        } else if (empty($menu_id)) {
            $this->output_response['message'] = "Bad request, menu id not found";
            $this->response($this->output_response, 400);
        } else if (empty($post_id)) {
            $this->output_response['message'] = "Bad request, post id not found";
            $this->response($this->output_response, 400);
        }

        $params = [$post_id, $menu_id];
        $result = $this->{$this->general_model}->get_article_by_post_id($params);
        $content = $this->{$this->general_model}->get_content_by_post_id($post_id);
        $result->post_content = $content;
        $user_id = null;

        if (!empty($result)) {
            $this->post_counter_logs($post_id, $user_id);
        }

        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function content_get()
    {
        $post_id = $this->get('post_id');
        if (empty($post_id)) {
            $this->output_response['message'] = "Bad request, post id not found";
            $this->response($this->output_response, 400);
        }

        $result = $this->{$this->general_model}->get_content_by_post_id($post_id);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    private function post_counter_logs($post_id = null, $user_id = null)
    {
        $this->load->library('user_agent');

        $browser_client = $this->agent->browser() . ' ' . $this->agent->version();
        $ip_client = $this->input->ip_address();

        $params = [$post_id, $user_id, $ip_client, $browser_client];
        $data_post = [$post_id, $user_id, $ip_client];

        $post_counter_logs = $this->logs_model->get_post_counter_logs_by($data_post);
        if (empty($post_counter_logs)) {
            $this->logs_model->set_post_counter_logs($params); //insert post_counter_log
            $post_counter = $this->logs_model->get_post_counter_by_post_id($post_id);
            if (empty($post_counter)) {
                $this->logs_model->set_counter_post($post_id);
            } else {
                $this->logs_model->update_post_counter($post_counter);
            }
        }
    }

    public function featured_get()
    {
        $menu_id = $this->check_empty($this->get('menu_id'));

        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($start, $limit);

        $result = $this->{$this->general_model}->get_article_featured_by_menu_id($menu_id, $params);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function recomended_get()
    {
        $menu_id = $this->check_empty($this->get('menu_id'));

        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($start, $limit);

        $result = $this->{$this->general_model}->get_article_recomended_by_menu_id($menu_id, $params);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function related_get()
    {
        $menu_id = $this->get('menu_id');
        $post_id = $this->get('self_post_id');
        if (empty($menu_id) and empty($post_id)) {
            $this->output_response['message'] = "Bad request, params menu id and post id not found";
            $this->response($this->output_response, 400);
        } else if (empty($menu_id)) {
            $this->output_response['message'] = "Bad request, menu id not found";
            $this->response($this->output_response, 400);
        } else if (empty($post_id)) {
            $this->output_response['message'] = "Bad request, post id not found";
            $this->response($this->output_response, 400);
        }

        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($menu_id, $post_id, $start, $limit);

        $result = $this->{$this->general_model}->get_related_article_by_menu_id($params);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function top_get()
    {
        $menu_id = $this->check_empty($this->get('menu_id'));

        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($start, $limit);

        $result = $this->{$this->general_model}->get_top_article_by_menu_id($menu_id, $params);
        if($this->get('menu_id')=='1908125D5126DDE8F48'){
            foreach($result as $index => $row){
                $return[$index]=$row;
                $return[$index]->post_description=strip_tags($row->post_description);
                $return[$index]->post_shortdesc=strip_tags($row->post_shortdesc);
                
            }
        }else{
            $return=$result;
        }
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function image_get()
    {
        $post_id = $this->get('post_id');
        if (empty($post_id)) {
            $this->output_response['message'] = 'Bad request, post id not found';
            $this->response($this->output_response);
        }

        $result = $this->{$this->general_model}->get_post_image_by_post_id($post_id);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function recent_get()
    {
        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = [$start, $limit];

        $result = $this->{$this->general_model}->get_recent_article($params);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function filter_post()
    {
        $menu = $this->check_empty($this->post('menu'));
        $city = $this->check_empty($this->post('city'));
        $spot = $this->check_empty($this->post('spot'));
        $tags = $this->check_empty($this->post('tags'));
        $sorts = $this->check_empty($this->post('sort'));
        $keywords = $this->check_empty($this->post('keyword'));
        $filter_populars = $this->check_empty($this->post('filter_popular'));
        $rating = $this->check_empty($this->post('rating'));
//        echo '<pre>';
//        var_dump($filter_populars);
//        die();

        $limit = (empty($this->post('limit'))) ? 10 : (int) $this->post('limit');
        $page = (empty($this->post('page'))) ? 1 : (int) $this->post('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($start, $limit);

        $result = $this->{$this->general_model}->get_article_by_filter($menu, $city, $tags, $params, $sorts,$keywords,$filter_populars,$spot,$rating);

        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
    public function popular_tags_get()
    {
        $menu = $this->check_empty($this->get('menu_id'));
        $data=[$menu];
        $result = $this->{$this->general_model}->get_tags_article($data);

        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function tags_get()
    {
        $menu_id = $this->check_empty($this->input->get('menu_id'));

        $limit = (empty($this->get('limit'))) ? 10 : (int) $this->get('limit');
        $page = (empty($this->get('page'))) ? 1 : (int) $this->get('page');
        $params = array($page, $limit);
        $result = $this->{$this->general_model}->get_tags_by_menu_id($menu_id, $params);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function image_member_get()
    {
        $post_id = $this->check_empty($this->get('post_id'));
        if (empty($post_id)) {
            $this->output_response['message'] = 'Bad request, post id not found';
            $this->response($this->output_response);
        }
        $limit = (empty($this->post('limit'))) ? 10 : (int) $this->post('limit');
        $page = (empty($this->post('page'))) ? 1 : (int) $this->post('page');
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($start, $limit);
        $result = $this->{$this->general_model}->get_image_member_by_post_id($post_id);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }

    public function search_post()
    {
        $search = $this->check_empty($this->input->post('search'));
        if (empty($search)) {
            $this->output_response['message'] = 'Bad Request, key not found';
            $this->response($this->output_response);
        }
        $limit = (empty($this->input->post('limit'))) ? 10 : (int) $this->input->post('limit');
        $page = (empty($this->input->post('page'))) ? 1 : (int) $this->input->post('page');

        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        $params = array($start, $limit);
        $result = $this->{$this->general_model}->get_article_by_search($search, $params);
        $this->output_response['status'] = 'success';
        $this->output_response['message'] = 'success';
        $this->output_response['data'] = $result;
        $this->response($this->output_response, 200);
    }
}
