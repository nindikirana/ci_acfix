<?php


$this->sql_general_select_decription = ' a_lang.description as post_description, a_lang.description_about as post_description_about ';

$this->sql_general_select     = "SELECT 
                                       a.id as post_id, a.ordering as post_ordering, a.status as post_status, a.published as post_published, 
                                       a.meta_title, a.meta_keywords, a.meta_description, a.ctd as post_created_at, a.mdd as post_updated_at,
                                       a_lang.title as post_title, a_lang.slug as post_slug, a_lang.short_description as post_shortdesc,
                                       b_lang.title as menu_title, b_lang.slug as menu_slug,
                                       a_location_spot.title as locate_spot_title, a_location_spot.slug as locate_spot_slug,
                                       a_location_city.title as locate_city_title, a_location_city.slug as locate_city_slug,
                                       a_tags.title as tags_title, a_tags.slug as tags_slug,
                                       price_tags.title as price_title, price_tags.slug as tags_price,
                                       age_tags.title as age_title, age_tags.slug as tags_age,
                                       a_img.file_location, a_img.file_thumb, a_img.file_original
                                      ";
$this->sql_general_from       = " FROM {$this->table_post} a";
$this->sql_general_join       = " JOIN {$this->table_post_lang} a_lang ON a.id = a_lang.post_id
                                       JOIN {$this->table_lang} a_lang_conf ON a_lang_conf.id = a_lang.acs_lang_id
                                       JOIN {$this->table_menu} b ON a.menu_id = b.id 
                                       JOIN {$this->table_menu_lang} b_lang ON b.id = b_lang.menu_id
                                       JOIN {$this->table_lang} b_lang_conf ON b_lang_conf.id = b_lang.acs_lang_id
                                       LEFT JOIN
                                       (
                                         SELECT post_id, file_location, file_thumb, file_original 
                                         FROM {$this->table_post_image}
                                         WHERE status_cover = '{$this->status_image_cover}' AND status_type = '{$this->status_image_type_cover}'
                                         GROUP BY post_id
                                       ) a_img ON a_img.post_id = a.id
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
                                       ) a_location_spot ON a.id = a_location_spot.post_id
                                       LEFT JOIN (
                                         SELECT post_id, GROUP_CONCAT(city SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
                                         FROM location_city
                                         JOIN post_location_city ON location_city.id = post_location_city.city_id
                                         WHERE 1=1
                                         GROUP BY post_id
                                       ) a_location_city ON a.id = a_location_city.post_id 
                                       LEFT JOIN (
SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
                                         FROM tags
                                         JOIN post_tags ON tags.id = post_tags.tags_id
                                         WHERE 1=1
                                         and tags.tags_kt_id='1807185B4EB4DB8934C'
                                         GROUP BY post_id
                                       ) a_tags ON a.id = a_tags.post_id
                                       LEFT JOIN (
                                         SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
                                         FROM tags
                                         JOIN post_tags ON tags.id = post_tags.tags_id
                                         WHERE 1=1
                                         and tags.tags_kt_id='1906175D0759A49209A'
                                         GROUP BY post_id
                                       ) price_tags ON a.id = price_tags.post_id
                                       LEFT JOIN (
                                         SELECT post_id, GROUP_CONCAT(title SEPARATOR ', ') as title, GROUP_CONCAT(slug SEPARATOR ', ') as slug 
                                         FROM tags
                                         JOIN post_tags ON tags.id = post_tags.tags_id
                                         WHERE 1=1
                                         and tags.tags_kt_id='1906175D0759B153415'
                                         GROUP BY post_id
                                       ) age_tags ON a.id = age_tags.post_id
                                       ";
$this->sql_general_where      = " WHERE 1=1 AND a_lang_conf.{$this->table_lang_status} = 1 AND a_lang_conf.{$this->table_lang_status_default} = 1";
$this->sql_general_where_menu = " AND b_lang.slug = ? ";
$this->sql_general_groupby    = " GROUP BY a.id";
$this->sql_general_orderby    = " ORDER BY a.published DESC, a.ordering DESC";
$this->sql_general_limit      = " LIMIT ?";


(
    [0] => Array
        (
            [id] => 1807185B4EB267AE410,1807185B4EB40D485A2,1807185B4EB3D738F3A
        )

    [1] => Array
        (
            [id] => 1807185B4EB39E0B98F,1810095BBC2EB8B448E,1810115BBEC3CCAF457,1810115BBEC48A53BE6,1810115BBEC4E7B04FA
        )

)