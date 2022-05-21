<?php

class Review_model extends CI_Model
{
    private $general_select = " SELECT first_name,last_name,post_review.parent,post_review.id,post_review.rating_star,post_review.subject,post_review.message";
    private $general_select_post = " ,post_lang.title as post_title,post_lang.post_id,post.menu_id";
    private $general_from = " FROM post_review ";
    private $general_where = " where post_id = ? and post_review.status ='1' ";
    private $general_join = " Join acs_users on post_review.user_id=acs_users.id";
    private $general_join_post = " Join post on post.id=post_review.post_id";
    private $general_join_post_lang = " Join post_lang on post.id=post_lang.post_id";
    private $general_where_parent = " where parent = ? and post_review.status ='1' ";
    private $general_where_user_id = " where user_id = ? and post_review.status ='1' ";
    private $general_where_parent_null = " and parent is NULL ";
    private $general_limit = " limit ?,? ";
    private $general_group_by = " group by post_review.id ";
    
    
    

    public function get_review_by_post_id($params = null)
    {
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        $main_sql .= $this->general_where_parent_null;
        $main_sql .= $this->general_limit;
        $query = $this->db->query($main_sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach($result as $index => $row){
                $result[$index]->reply=$this->get_review_reply($row->id);
            }
            return $result;
        } else {
            return array();
        }
    }
    public function get_review_reply($params = null)
    {
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where_parent;
        $query = $this->db->query($main_sql,[$params]);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }
    public function get_review_by_user_id($params = null)
    {
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_select_post;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_join_post;
        $main_sql .= $this->general_join_post_lang;
        $main_sql .= $this->general_where_user_id;
        $main_sql .= $this->general_group_by;
        $main_sql .= $this->general_limit;
        $query = $this->db->query($main_sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }
}
