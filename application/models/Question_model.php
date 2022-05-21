<?php

class Question_model extends CI_Model
{
    private $general_table = "post_comment";
    private $general_select = " SELECT first_name,last_name,post_comment.parent,post_comment.id,post_comment.subject,post_comment.message";
    private $general_select_post = " ,post_lang.title as post_title,post_lang.post_id,post.menu_id";
    private $general_from = " FROM post_comment ";
    private $general_join = " Join acs_users on post_comment.user_id=acs_users.id";
    private $general_join_post = " Join post on post.id=post_comment.post_id";
    private $general_join_post_lang = " Join post_lang on post.id=post_lang.post_id";
    private $general_where = " where post_id = ? and post_comment.status='1' ";
    private $general_where_parent = " where parent = ? and post_comment.status='1' ";
    private $general_where_user_id = " where user_id = ? and post_comment.status ='1' ";
    private $general_where_parent_null = " and parent is NULL ";
    private $general_limit = " limit ?,? ";
    private $general_group_by = " group by post_comment.id ";


    public function get_comment_by_post_id($params = null)
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
                $result[$index]->reply=$this->get_comment_reply($row->id);
            }
            return $result;
        } else {
            return array();
        }
    }
    public function get_comment_by_user_id($params = null)
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
    public function get_comment_reply($params = null)
    {
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where_parent;
        $query = $this->db->query($main_sql,$params);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }
    
}
