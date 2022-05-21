<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inject extends CI_Controller
{

    public function index()
    {

    }

    public function events()
    {
        $table       = 'la_kids_parents';
        $menu_id_new = '1807185B4EB2116728E';

        $sql   = "SELECT * FROM {$table} LIMIT 2";
        $query = $this->db->query($sql);

        $output_query      = array();
        $output_query_lang = array();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $query->free_result();
            foreach ($result as $index => $row) {

                $data = array(
                    'id'               => $row->id,
                    'menu_id'          => $menu_id_new,
                    'parent'           => 0,
                    'ordering'         => 0,
                    'published'        => $row->article_date,
                    'status'           => 1,
                    'meta_title'       => $row->title_event,
                    'meta_keywords'    => $row->tags,
                    'meta_description' => $row->teaser,
                    'ctb'              => 1,
                    'mdb'              => 1,
                    'ctd'              => $row->article_date,
                    'mdd'              => $row->article_date,
                );

                $data_lang_id = array(
                    'id'                => generate_new_id_string() . get_random_alphanumeric(5),
                    'post_id'           => $row->id,
                    'acs_lang_id'       => 'LGID',
                    'title'             => $row->title_event,
                    'short_description' => $row->teaser,
                    'description'       => $row->content,
                    'ctb'               => 1,
                    'mdb'               => 1,
                    'ctd'               => $row->article_date,
                    'mdd'               => $row->article_date,
                );
                $data_lang_en = array(
                    'id'                => generate_new_id_string() . get_random_alphanumeric(5),
                    'post_id'           => $row->id,
                    'acs_lang_id'       => 'LGEN',
                    'title'             => $row->title_event,
                    'short_description' => $row->teaser_en,
                    'description'       => $row->content_en,
                    'ctb'               => 1,
                    'mdb'               => 1,
                    'ctd'               => $row->article_date,
                    'mdd'               => $row->article_date,);

                $output_query[]      = $this->db->insert_string('post', $data);
                $output_query_lang[] = $this->db->insert_string('post_lang', $data_lang_id);
                $output_query_lang[] = $this->db->insert_string('post_lang', $data_lang_en);

            }
        }
        $output_query      = implode(';', $output_query);
        $output_query      .= ';';
        $output_query_lang = implode(';', $output_query_lang);
        $output_query_lang .= ';';

        echo '<pre>';
        echo $output_query;
        echo $output_query_lang;

    }

    public function places($menu_old_id = null, $menu_new_id = null)
    {
        $table       = 'la_fun_courses';
        $menu_id_old = $menu_old_id;
        $menu_id_new = $menu_new_id;

        if (!empty($menu_id_new) && !empty($menu_old_id)) {
            $sql   = "SELECT * FROM {$table} WHERE category_id = ? LIMIT 3";
            $query = $this->db->query($sql, $menu_id_old);

            $output_query               = array();
            $output_query_lang          = array();
            $output_query_location_city = array();
            if ($query->num_rows() > 0) {
                $result = $query->result();
                $query->free_result();
                foreach ($result as $index => $row) {

                    $data = array(
                        'id'               => $row->id,
                        'menu_id'          => $menu_id_new,
                        'parent'           => 0,
                        'ordering'         => $row->sort,
                        'published'        => $row->published_date,
                        'status'           => 1,
                        'meta_title'       => $row->title_course,
                        'meta_keywords'    => $row->tags,
                        'meta_description' => $row->teaser,
                        'ctb'              => 1,
                        'mdb'              => 1,
                        'ctd'              => $row->article_date,
                        'mdd'              => $row->article_date,
                    );

                    $data_lang_id = array(
                        'id'                => generate_new_id_string() . get_random_alphanumeric(5),
                        'post_id'           => $row->id,
                        'acs_lang_id'       => 'LGID',
                        'title'             => $row->title_course,
                        'short_description' => $row->teaser,
                        'description'       => $row->content,
                        'ctb'               => 1,
                        'mdb'               => 1,
                        'ctd'               => $row->article_date,
                        'mdd'               => $row->article_date,
                    );
                    $data_lang_en = array(
                        'id'                => generate_new_id_string() . get_random_alphanumeric(5),
                        'post_id'           => $row->id,
                        'acs_lang_id'       => 'LGEN',
                        'title'             => $row->title_course,
                        'short_description' => $row->teaser_en,
                        'description'       => (!empty($row->content_en)) ? $row->content_en : $row->content,
                        'ctb'               => 1,
                        'mdb'               => 1,
                        'ctd'               => $row->article_date,
                        'mdd'               => $row->article_date,
                    );

                    /**
                     * =============================================================================================================================================
                     * LOCATION  : CITY
                     */
                    $check_city = $this->get_city_id($row->city);
                    if (!empty($check_city)) {
                        $data_location_city           = array(
                            'id'      => generate_new_id_string() . get_random_alphanumeric(5),
                            'post_id' => $row->id,
                            'city_id' => $check_city
                        );
                        $output_query_location_city[] = $this->db->insert_string('post_location_city', $data_location_city);
                    }
                    /**
                     * LOCATION  : CITY
                     * =============================================================================================================================================
                     */

                    /**
                     * =============================================================================================================================================
                     * LOCATION  : SPOT
                     */
                    $check_spot = $this->get_spot_id($row->location);
                    if (!empty($check_spot)) {
                        $data_location_spot           = array(
                            'id'      => generate_new_id_string() . get_random_alphanumeric(5),
                            'post_id' => $row->id,
                            'spot_id' => $check_spot
                        );
                        $output_query_location_spot[] = $this->db->insert_string('post_location_spot', $data_location_spot);
                    } else {

                    }
                    /**
                     * LOCATION  : SPOT
                     * =============================================================================================================================================
                     */


                    $output_query[]      = $this->db->insert_string('post', $data);
                    $output_query_lang[] = $this->db->insert_string('post_lang', $data_lang_id);
                    $output_query_lang[] = $this->db->insert_string('post_lang', $data_lang_en);

                }
            }
            $output_query               = implode(';', $output_query);
            $output_query               .= ';';
            $output_query_lang          = implode(';', $output_query_lang);
            $output_query_lang          .= ';';
            $output_query_location_city = implode(';', $output_query_location_city);
            $output_query_location_city .= ';';

            echo '<pre>';
//            echo $output_query;
//            echo $output_query_lang;
//            print_r($output_query_location_city);
        }

    }

    public function match_province()
    {
        $DB1     = $this->load->database('default', TRUE);
        $DB2     = $this->load->database('default_la_new', TRUE);
        $query_1 = $DB1->get('la_province')->result();
        foreach ($query_1 as $index => $row) {
            $DB2->like('province', $row->propinsi);
            $query_2 = $DB2->get('location_province')->row();
            if (!empty($query_2)) {
                $data_update = array('new_id' => $query_2->id);
                $this->db->update('la_province', $data_update, array('id' => $row->id));
            }

        }
    }

    public function match_city()
    {
        $DB1 = $this->load->database('default', TRUE);
        $DB2 = $this->load->database('default_la_new', TRUE);

        $DB1->select('la_city.id, la_city.kota_kabupaten, la_city.propinsi_id, la_province.new_id as new_provice_id');
        $DB1->join('la_province', 'la_province.id = la_city.propinsi_id');
        $query_1 = $DB1->get('la_city')->result();
        foreach ($query_1 as $index => $row) {


            $DB2->where('province_id', $row->new_provice_id);
            $DB2->like('city', $row->kota_kabupaten);
            $query_2 = $DB2->get('location_city')->row();
            if (!empty($query_2)) {
                $data_update = array('new_id' => $query_2->id);
                $this->db->update('la_city', $data_update, array('id' => $row->id));
            } else {
            }

        }
    }

    public function get_city_id($parameter = null)
    {
        $this->db->where('id', $parameter);
        $get = $this->db->get('la_city')->row();
        if (!empty($get)) {
            return $get->new_id;
        } else {
            return null;
        }
    }
}
