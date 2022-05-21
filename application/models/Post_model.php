<?php

class Post_model extends CI_Model
{
    private $general_select = "SELECT post.menu_id, menu_lang.slug as menu_slug , 
            menu_lang.title as menu_title, post.id as post_id, post_lang.title as post_title, 
            post_lang.slug as post_slug, post_lang.short_description as post_shortdesc , 
            post_lang.description as post_description , 
            DATE_FORMAT(post.published , ' %d-%m-%Y ') AS post_published,
            post_image.file_location as post_image_location , 
            post_image.file_thumb as post_image_thumbnail, post_image.file_original as post_image_original,
            post.status as post_status , post.ordering as post_ordering , 
            (CASE
            WHEN DATE_FORMAT(event_start,'%d %M %Y') = DATE_FORMAT(event_end,'%d %M %Y') THEN DATE_FORMAT(event_start, '%d %M %Y')
            ELSE concat(DATE_FORMAT(post.event_start,'%d %M %Y'),' - ',DATE_FORMAT(post.event_end,'%d %M %Y'))
            END) as date_display,
            DATE_FORMAT(post.event_start, '%d %M %Y %H:%i:%s') as event_start , DATE_FORMAT(post.event_end, '%d %M %Y %H:%i:%s') as event_end,
            a_location_spot.title as locate_spot_title, a_location_spot.slug as locate_spot_slug, a_location_spot.spot_id as locate_spot_id,
            a_location_city.title as locate_city_title, a_location_city.slug as locate_city_slug, a_location_city.city_id as locate_city_id,
            a_tags.title as tags_title, a_tags.slug as tags_slug, 
            a_price.title as price_title, a_price.slug as price_slug, 
            a_age.title as age_title, a_age.slug as age_slug, 
            ('http://178.128.211.27/') as base_url,rating_avg,counter ";

    private $general_from = "FROM post ";
    private $general_join = "JOIN post_lang ON post.id = post_lang.post_id 
                            JOIN acs_lang as post_lang_conf ON post_lang.acs_lang_id = post_lang_conf.id
                            JOIN menu ON post.menu_id = menu.id
                            JOIN menu_lang ON menu.id = menu_lang.menu_id
        
                            LEFT JOIN
                            post_review_result ON post.id = post_review_result.post_id
                            LEFT JOIN post_image ON post.id = post_image.post_id
                            LEFT JOIN (
                                         SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug ,location_spot.id as spot_id
                                         FROM location_spot
                                         JOIN post_location_spot ON location_spot.id = post_location_spot.spot_id
                                         WHERE 1=1
                                         AND ( 
                                          (location_spot.status = 1 OR location_spot.status IS NULL) 
                                           AND 
                                          (location_spot.status_review = 1 OR location_spot.status_review IS NULL) 
                                         )
                                         GROUP BY post_id
                                       ) a_location_spot ON post.id = a_location_spot.post_id
                            LEFT JOIN (
                                         SELECT city_id,post_id, GROUP_CONCAT(city SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
                                         FROM location_city
                                         JOIN post_location_city ON location_city.id = post_location_city.city_id
                                         WHERE 1=1
                                         GROUP BY post_id
                                       ) a_location_city ON post.id = a_location_city.post_id 
                            LEFT JOIN ( SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
                                         FROM tags
                                         JOIN post_tags ON tags.id = post_tags.tags_id
                                         WHERE tags_kt_id='1807185B4EB4DB8934C'
                                         GROUP BY post_id
                                       ) a_tags ON post.id = a_tags.post_id 
                            LEFT JOIN ( SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
                                         FROM tags
                                         JOIN post_tags ON tags.id = post_tags.tags_id
                                         WHERE tags_kt_id='1906175D0759A49209A'
                                         GROUP BY post_id
                                       ) a_price ON post.id = a_price.post_id 
                            LEFT JOIN ( SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
                                         FROM tags
                                         JOIN post_tags ON tags.id = post_tags.tags_id
                                         WHERE tags_kt_id='1906175D0759B153415'
                                         GROUP BY post_id
                                       ) a_age ON post.id = a_age.post_id 
                            LEFT JOIN post_counter ON post.id = post_counter.post_id ";

    private $general_where = "where 1=1
                            AND post_lang_conf.status_default = ? 
                            AND post_lang_conf.status = ? 
                            AND post.status = ?  
                            AND post.status_mobile = '1' ";

    private $general_group = "GROUP BY post.id , post.ordering ORDER BY post.published desc LIMIT ?,? ";
    private $get_menu_id =  'SELECT 
                        CONCAT(CONCAT_WS(' . "','" . ',menu_1.id, 
                                GROUP_CONCAT(menu_2.id SEPARATOR ' . "','" . '), 
                                GROUP_CONCAT(menu_3.id SEPARATOR ' . "','" . '))) as id
                        FROM menu as menu_1
                        LEFT JOIN menu menu_2 ON menu_2.parent = menu_1.id
                        LEFT JOIN menu menu_3 ON menu_3.parent = menu_2.id
                        WHERE menu_1.id = ?
                        GROUP by menu_1.id';
    private $get_menu_id_by_multi =  'SELECT 
                        CONCAT(CONCAT_WS(' . "','" . ',menu_1.id, 
                                GROUP_CONCAT(menu_2.id SEPARATOR ' . "','" . '), 
                                GROUP_CONCAT(menu_3.id SEPARATOR ' . "','" . '))) as id
                        FROM menu as menu_1
                        LEFT JOIN menu menu_2 ON menu_2.parent = menu_1.id
                        LEFT JOIN menu menu_3 ON menu_3.parent = menu_2.id
                        WHERE menu_1.id IN ?
                        GROUP by menu_1.id';
    // private $get_tags_by_multi = ""

    public function get_article_by_menu_id($params = null)
    {
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        $main_sql .= "AND menu_lang.menu_id IN ? ";
        $main_sql .= $this->general_group;
        $parameter = [1, 1, 1];
        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }
        $get_Id = $this->db->query($this->get_menu_id, $parameter[3])->row();
        $parameter[3] = explode(',', $get_Id->id);
        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach($result as $index => $row){
                $result[$index]->post_content=$this->get_content_by_post_id($row->post_id);
            }
            return $result;
        } else {
            return array();
        }
    }
    public function get_article_all_by_menu_id($params = null)
    {
        $params[0]=[
            '1807185B4EB1F7BA2AA',
            '1807185B4EB209E244C',
            '1908125D5126DDE8F48',
        ];
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        if(!empty($params[0])){
            $main_sql .= "AND menu_lang.menu_id IN ? ";
        }else{
            unset($params[0]);
        }
        $main_sql .= $this->general_group;
        $parameter = [1, 1, 1];
        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }

        if(!empty($parameter[3])){
            $get_Id = $this->db->query($this->get_menu_id_by_multi, array($parameter[3]))->result_array();
            $all_id = "";
            foreach ($get_Id as $key => $value) {
                if ($key == 0) {
                    $all_id .= $value['id'];
                } else {
                    $all_id .= ",";
                    $all_id .= $value['id'];
                }
            }
            $parameter[3] = explode(',', $all_id);
        }
        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach($result as $index => $row){
                $result[$index]->post_content=$this->get_content_by_post_id($row->post_id);
            }
            return $result;
        } else {
            return array();
        }
    }

    public function get_article_by_post_id($params = null)
    {
        $sql =
            "SELECT  post.id as post_id, post.ordering as post_ordering, post.status as post_status, post.published as post_published, 
        post.meta_title, post.meta_keywords, post.meta_description, post.ctd as post_created_at, post.mdd as post_updated_at,
        (CASE
        WHEN DATE_FORMAT(event_start,'%d %M %Y') = DATE_FORMAT(event_end,'%d %M %Y') THEN DATE_FORMAT(event_start, '%d %M %Y')
        ELSE concat(DATE_FORMAT(post.event_start,'%d %M %Y'),' - ',DATE_FORMAT(post.event_end,'%d %M %Y'))
        END) as date_display,
        DATE_FORMAT(post.event_start, '%d %M %Y %H:%i:%s') as event_start , DATE_FORMAT(post.event_end, '%d %M %Y %H:%i:%s') as event_end,
        post_lang.title as post_title, post_lang.slug as post_slug, post_lang.short_description as post_shortdesc,
        menu_lang.title as menu_title, menu_lang.slug as menu_slug,
        a_location_spot.title as locate_spot_title, a_location_spot.slug as locate_spot_slug,
        a_location_city.title as locate_city_title, a_location_city.city_id as locate_city_id,
        a_tags.title as tags_title, a_tags.slug as tags_slug,
        a_img.file_location, a_img.file_thumb, a_img.file_original,
        post_lang.description as post_description, post_lang.description_about as post_description_about,
        ('http://178.128.211.27/') as base_url,status_cover

        FROM post 
        JOIN post_lang ON post.id = post_lang.post_id
        JOIN acs_lang AS post_lang_conf ON post_lang_conf.id = post_lang.acs_lang_id
        JOIN menu ON post.menu_id = menu.id 
        JOIN menu_lang ON menu.id = menu_lang.menu_id
        JOIN acs_lang AS menu_lang_conf ON menu_lang_conf.id = menu_lang.acs_lang_id

        LEFT JOIN
        (
          SELECT post_id, file_location, file_thumb, file_original,status_cover
          FROM post_image
          GROUP BY post_id
        ) a_img ON a_img.post_id = post.id

        LEFT JOIN (
          SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
          FROM location_spot
          JOIN post_location_spot ON location_spot.id = post_location_spot.spot_id
          WHERE 1=1
          AND ( 
           (location_spot.status = 1 OR location_spot.status IS NULL) 
            AND 
           (location_spot.status_review = 1 OR location_spot.status_review IS NULL) 
          )
          GROUP BY post_id
        ) a_location_spot ON post.id = a_location_spot.post_id

        LEFT JOIN (
          SELECT post_id, GROUP_CONCAT(city SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug ,city_id
          FROM location_city
          JOIN post_location_city ON location_city.id = post_location_city.city_id
          WHERE 1=1
          GROUP BY post_id
        ) a_location_city ON post.id = a_location_city.post_id 

        LEFT JOIN (
          SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
          FROM tags
          JOIN post_tags ON tags.id = post_tags.tags_id
          WHERE 1=1
          GROUP BY post_id
        ) a_tags ON post.id = a_tags.post_id
        
        WHERE 1=1 
        AND post_lang_conf.status_default = ? 
        AND post_lang_conf.status_default = ? 
        AND post.status = ?
        AND post.id = ?
        AND post.menu_id = ?
        AND post.status_mobile = '1' 
        GROUP BY post.id
        order by status_cover desc";
        $parameter = [1, 1, 1];
        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }

        $query = $this->db->query($sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result;
        } else {
            return array();
        }
    }

    public function get_article_featured_by_menu_id($menu_id = null, $params = null)
    {
        $main_sql = '';
        $parameter = [1, 1, 1, 1];

        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        $main_sql .= "AND post.status_featured = ? ";

        if (!empty($menu_id)) {
            $main_sql .= "AND menu_lang.menu_id IN ? ";

            $get_Id = $this->db->query($this->get_menu_id, $menu_id)->row();
            $menu_id = explode(',', $get_Id->id);
            array_push($parameter, $menu_id);
        }
        $main_sql .= $this->general_group;

        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }

        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_article_recomended_by_menu_id($menu_id = null, $params = null)
    {
        $main_sql = '';
        $parameter = [1, 1, 1, 1];

        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        $main_sql .= "AND post.status_recomended = ? ";

        if (!empty($menu_id)) {
            $main_sql .= "AND menu_lang.menu_id IN ? ";

            $get_Id = $this->db->query($this->get_menu_id, $menu_id)->row();
            $menu_id = explode(',', $get_Id->id);
            array_push($parameter, $menu_id);
        }
        $main_sql .= $this->general_group;

        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }

        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_related_article_by_menu_id($params = null)
    {
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        $main_sql .= "AND menu_lang.menu_id IN ? ";
        $main_sql .= "AND post.id != ? ";
        $main_sql .= $this->general_group;

        $parameter = [1, 1, 1];
        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }
        $get_Id = $this->db->query($this->get_menu_id, $parameter[3])->row();
        $parameter[3] = explode(',', $get_Id->id);
        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_top_article_by_menu_id($menu_id = null, $params = null)
    {
        $main_sql = '';
        $parameter = [1, 1, 1];
        $month = 3;
        date_default_timezone_set("Asia/Jakarta");
        $dateNow = date("Y-m-d H:i:s");
        $date3MonthLater = date("Y-m-d H:i:s", strtotime("-3 Months"));
        array_push($parameter, $dateNow, $date3MonthLater);

        $main_sql .= $this->general_select;
        $main_sql .= ", post_counter.counter as post_counter ";
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
//        $main_sql .= " JOIN post_counter ON post.id = post_counter.post_id ";
        $main_sql .= $this->general_where;
        $main_sql .= "AND ( post_counter.log_date <= ? AND post_counter.log_date >= ? ) ";

        if (!empty($menu_id)) {
            $main_sql .= "AND menu_lang.menu_id IN ? ";

            $get_Id = $this->db->query($this->get_menu_id, $menu_id)->row();
            $menu_id = explode(',', $get_Id->id);
            array_push($parameter, $menu_id);
        }

        $main_sql .=  "GROUP BY post.id , post.ordering ORDER BY post_counter desc LIMIT ?,? ";;

        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }

        $query = $this->db->query($main_sql, $parameter);
        while ($query->num_rows() <= 0 or $month == 24) {
            $parameter[4] = date("Y-m-d H:i:s", strtotime("-" . $month . " Months"));
            $query = $this->db->query($main_sql, $parameter);
            $month = $month * 2;
        }
        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach($result as $index => $row){
                $result[$index]->post_content=$this->get_content_by_post_id($row->post_id);
            }
            return $result;
        } else {
            return array();
        }
    }

    public function get_content_by_post_id($params = null)
    {
        $sql = "SELECT content_kt.content_name , post_content.content_value
                FROM post
                JOIN post_content on post.id = post_content.post_id
                JOIN content_kt_menu ON content_kt_menu.id = post_content.content_kt_menu_id
                JOIN content_kt ON content_kt.id = content_kt_menu.content_kt_id
                JOIN content_kt_lang ON content_kt.id = content_kt_lang.content_kt_id
                JOIN acs_lang as content_lang_conf ON content_lang_conf.id = content_kt_lang.acs_lang_id

                WHERE 1=1
                AND post.status = ?
                AND content_lang_conf.status = ?
                AND content_lang_conf.status_default= ?
                AND post.id = ?
                AND post.status_mobile = '1' ";

        $parameter = [1, 1, 1];
        if (!empty($params)) {
            array_push($parameter, $params);
        }

        $query = $this->db->query($sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
//            echo '<pre>';
//            var_dump($result) ;
//            die();
            foreach($result as $index => $row){
                if($row->content_name=='google_maps'){
                    $result[$index]->content_value=trim(str_replace(' ','',strip_tags($row->content_value)));
                }
            }
            
            return $result;
        } else {
            return array();
        }
    }

    public function get_post_image_by_post_id($params = nulll)
    {
        $sql = "SELECT 
            post_image.id as post_image_id,  
            post_image.file_name as post_image_file_name , 
            post_image.file_original as post_image_original,
            post_image.file_location as post_image_location,
            ('http://178.128.211.27/') as base_url
            From post_image
            WHERE 1=1
            AND post_image.status_member = 0
            AND post_image.post_id IN (?)";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_recent_article($params = null)
    {
        $main_sql = "";
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        $main_sql .= " GROUP BY post.id ,post.ordering ORDER BY post.published DESC LIMIT ?,?";

        $parameter = [1, 1, 1];
        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }
        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach($result as $index => $row){
                $result[$index]->post_content=$this->get_content_by_post_id($row->post_id);
            }
            return $result;
        } else {
            return array();
        }
    }

    public function get_tags_article($params = null)
    {
        $main_sql = '';
        $main_sql .= "SELECT 
        a_tags.title as tags_title, a_tags.slug as tags_slug ";
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        $main_sql .= "AND menu_lang.menu_id IN ? ";
        $main_sql .= "GROUP BY a_tags.slug ORDER BY counter desc ";
        $parameter = [1, 1, 1];
        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }
//        echo '<pre>';
//        var_dump($params);
//        die();
        $get_Id = $this->db->query($this->get_menu_id, $parameter[3])->row();
        $parameter[3] = explode(',', $get_Id->id);
        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $return=[];
            foreach($result as $index => $row){
                if(!empty($row->tags_title)){
                    $explode=[];
                    $explode=explode(',',$row->tags_title);
                    if(!empty($explode[1])){
                        foreach($explode as $idx => $val){
                            if(!in_array(trim($val),$return)){
                                $return[]=trim($val);
                            }
                        }
                    }else{
                        if(!in_array($row->tags_title,$return)){
                            $return[]=$row->tags_title;   
                        }
                    }
                }
            }
            return $return;
        } else {
            return array();
        }
    }
    public function get_article_by_filter($post_menu = null, $post_city = null, $tags = null, $params = null, $sorts = null, $keywords = null, $popular_tags = null,$spot=null,$rating=null)
    {
        $parameter = [1, 1, 1];
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        //cek post_city
        if (!empty($post_city)) {
            $main_sql .= "JOIN (
                SELECT post_id, city , city_id
                FROM location_city
                JOIN post_location_city ON location_city.id = post_location_city.city_id
                WHERE 1=1
                GROUP BY post_id
                ) city ON post.id = city.post_id ";
        }
        if (!empty($spot)) {
            $main_sql .= "JOIN (
                SELECT post_id, location_spot.title as spot_title, spot_id
                FROM location_spot
                JOIN post_location_spot ON location_spot.id = post_location_spot.spot_id
                WHERE 1=1
                GROUP BY post_id
                ) spot ON post.id = spot.post_id ";
        }
        // cek tags
        if (!empty($tags)) {
            $main_sql .= "JOIN (
                SELECT post_tags.post_id as post_id, tags.title as post_tags_title ,tags.slug as post_tags_slug , tags_kt_lang.slug as post_tags_type
                FROM post_tags
                JOIN tags ON tags.id = post_tags.tags_id
                JOIN tags_kt ON tags_kt.id = tags.tags_kt_id
                JOIN tags_kt_lang ON tags_kt_lang.tags_kt_id = tags_kt.id
                JOIN acs_lang ON tags_kt_lang.acs_lang_id = acs_lang.id
                WHERE 1=1
                AND acs_lang.status = 1
                AND acs_lang.status_default = 1
                ) tags ON post.id = tags.post_id ";
        }

        $main_sql .= $this->general_where;
        if (!empty($post_menu)) {
            $main_sql .= "AND menu.id IN ? ";
            array_push($parameter, $post_menu);
        }
        if (!empty($post_city)) {
            $main_sql .= "AND city.city_id IN (?) ";
            $param_city='';
            foreach($post_city as $idx => $rw){
                if($idx==0){
                  $param_city.=$rw;  
                }else{
                  $param_city.=','.$rw;
                }
            }
            array_push($parameter, $param_city);
        }
        if (!empty($tags)) {
            $main_sql .= "AND tags.post_tags_type IN ? 
                        AND tags.post_tags_title IN ? ";
            $tags_type = array();
            $tags_value = array();
            foreach ($tags as $key => $value) {
                array_push($tags_type, $key);
                $tags_value = array_merge($tags_value, $value);
            }
            array_push($parameter, $tags_type, $tags_value);
        }
//        echo '<pre>';
//        var_dump($tags_value);
//        die();
        if (!empty($keywords)) {
            $main_sql .= "AND post_lang.title like '%".$keywords."%' ";
        }
        if(!empty($popular_tags)){
            $main_sql .= " AND (";
            foreach($popular_tags as $idx => $rw){
                if($idx==0){
                    $main_sql .= " a_location_city.title like '%".$rw."%' ";
                }else{
                    $main_sql .= " OR a_location_city.title like '%".$rw."%' ";
                }
            }
            $main_sql .= " ) ";
            
        }

        if (!empty($spot)) {
            $main_sql .= "AND spot.spot_id IN (?) ";
            $param_spot='';
            foreach($spot as $idx => $rw){
                if($idx==0){
                  $param_spot.=$rw;  
                }else{
                  $param_spot.=','.$rw;
                }
            }
            array_push($parameter, $param_spot);
        }
        if(!empty($rating)){
            if($rating=='5'){
                $main_sql .= "AND rating_avg = '5' ";
            }else{
                $main_sql .= " AND (rating_avg >= '".$rating."' and rating_avg<='".(intval($rating)+1)."' )";
            }
        }
        if(!empty($sorts)){
            if($sorts=='TITLE_ASC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY post_lang.title asc LIMIT ?,? ";
            }else if($sorts=='TITLE_DESC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY post_lang.title desc LIMIT ?,? ";
            }else if($sorts=='PUBLISHED_ASC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY event_start,post.published asc LIMIT ?,? ";
            }else if($sorts=='PUBLISHED_DESC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY event_start,post.published desc LIMIT ?,? ";
            }else  if($sorts=='RATING_ASC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY rating_avg asc LIMIT ?,? ";
            }else  if($sorts=='RATING_DESC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY rating_avg desc LIMIT ?,? ";
            }else  if($sorts=='POPULAR_ASC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY counter asc LIMIT ?,? ";
            }else  if($sorts=='POPULAR_DESC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY counter desc LIMIT ?,? ";
            }else  if($sorts=='PRICE_ASC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY a_price.title asc LIMIT ?,? ";
            }else  if($sorts=='PRICE_DESC'){
                $main_sql .= "GROUP BY post.id , post.ordering ORDER BY a_price.title desc LIMIT ?,? ";
            }else {
                $main_sql .= "GROUP BY post.id , post.ordering LIMIT ?,? ";
            }
        }else{
            $main_sql .= "GROUP BY post.id , post.ordering ORDER BY post.published desc LIMIT ?,? ";
        }

        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }

        if (!empty($post_menu)) {
            $get_Id = $this->db->query($this->get_menu_id_by_multi, array($parameter[3]))->result_array();
            $all_id = "";
            foreach ($get_Id as $key => $value) {
                if ($key == 0) {
                    $all_id .= $value['id'];
                } else {
                    $all_id .= ",";
                    $all_id .= $value['id'];
                }
            }
            $parameter[3] = explode(',', $all_id);
        }
        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            foreach($result as $index => $row){
                $result[$index]->post_content=$this->get_content_by_post_id($row->post_id);
            }
            return $result;
        } else {
            return array();
        }
    }

    public function get_tags_by_menu_id($menu = null, $params = null)
    {
        $parameter = [1, 1];
        $main_sql = 'SELECT tags.id as tags_id, tags.title as tags_title , tags.slug as tags_slug, 
                    tags_kt_lang.slug as tags_kt_slug, tags_kt.id as tags_category_id, tags_kt_lang.title as tags_category_title,
                    tags_kt_lang.slug as tags_category_slug
                    From post_tags
                    JOIN post ON post.id = post_tags.post_id
                    JOIN tags ON post_tags.tags_id = tags.id
                    JOIN tags_kt ON tags_kt.id = tags.tags_kt_id
                    JOIN tags_kt_lang ON tags_kt_lang.tags_kt_id = tags_kt.id
                    JOIN acs_lang ON acs_lang.id = tags_kt_lang.acs_lang_id
                    WHERE 1=1
                    AND acs_lang.status = ?
                    AND acs_lang.status_default = ?
                    AND post.menu_id IN (?)
                    AND post.status_mobile = "1" 
                    GROUP by tags_id LIMIT ?,?';
        if (!empty($menu)) {
            array_push($parameter, $menu);
            $get_Id = $this->db->query($this->get_menu_id, array($parameter[2]))->result_array();
            $all_id = "";
            foreach ($get_Id as $key => $value) {
                if ($key == 0) {
                    $all_id .= $value['id'];
                } else {
                    $all_id .= ",";
                    $all_id .= $value['id'];
                }
            }
            $parameter[2] = explode(',', $all_id);
        }
        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }
        $query = $this->db->query($main_sql, $parameter);

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_image_member_by_post_id($post = null)
    {
        $sql = "SELECT post.id as post_id ,
            post_image.id as post_image_id,  
            post_image.file_name as post_image_file_name , 
            post_image.file_original as post_image_original,
            post_image.file_location as post_image_location,
            ('http://178.128.211.27/') as base_url
            From post
            JOIN post_image ON post.id = post_image.post_id
            WHERE 1=1
            AND post_image.status_member = 1
            AND post_image.status_member_acc = 1
            AND post.status_mobile = '1' 
            AND post.id IN (?)";

        $query = $this->db->query($sql, $post);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_article_by_search($search = null, $params = null)
    {
        $main_sql = '';
        $main_sql .= $this->general_select;
        $main_sql .= $this->general_from;
        $main_sql .= $this->general_join;
        $main_sql .= $this->general_where;
        $main_sql .= "AND ( post_lang.title LIKE ? ";
        $main_sql .= "OR post_lang.short_description LIKE ? ";
        $main_sql .= "OR post_lang.description LIKE ? ";
        $main_sql .= "OR a_location_spot.title LIKE ? ";
        $main_sql .= "OR a_location_city.title LIKE ? ";
        $main_sql .= "OR a_tags.title LIKE ? ) ";
        $main_sql .= $this->general_group;
        $parameter = [1, 1, 1];
        if (!empty($search)) {
            $search = "%" . $search . "%";
            array_push($parameter, $search, $search, $search, $search, $search, $search);
        }
        if (!empty($params)) {
            $parameter = array_merge($parameter, $params);
        }

        $query = $this->db->query($main_sql, $parameter);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return array();
        }
    }
}
