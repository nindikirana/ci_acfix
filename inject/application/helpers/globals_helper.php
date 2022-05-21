<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists("theme_admin_locations")) {
    function theme_admin_locations()
    {
        $CI             =& get_instance();
        $theme_location = $CI->template_admin->get_theme_path();
        return base_url() . $theme_location;
    }
}

if (!function_exists("theme_front_locations")) {
    function theme_front_locations()
    {
        $CI             =& get_instance();
        $theme_location = $CI->template_front->get_theme_path();
        return base_url() . $theme_location;
    }
}

if (!function_exists("theme_global_locations")) {
    function theme_global_locations()
    {
        $CI             =& get_instance();
        $theme_location = 'themes/globals/';
        return base_url() . $theme_location;
    }
}

if (!function_exists("variable_issets")) {
    function variable_issets($params = null, $strip_tags = false, $no_enter = false)
    {
        if (isset($params)) {
            if ($no_enter == TRUE) {
                $params = str_replace(array("\n", "\r"), '', $params);
            }
            if ($strip_tags == TRUE) {
                echo strip_tags($params);
            } else {
                echo $params;
            }
        }
    }
}

if (!function_exists("crypto_rand_secure")) {
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1)
            return $min; // not so random...
        $log    = ceil(log($range, 2));
        $bytes  = (int)($log / 8) + 1; // length in bytes
        $bits   = (int)$log + 1; // length in bits
        $filter = (int)(1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }
}

if (!function_exists("get_random_numeric")) {
    function get_random_numeric($length)
    {
        $token        = "";
        $codeAlphabet = "0123456789";
        $max          = strlen($codeAlphabet); // edited
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
        }
        return $token;
    }
}

if (!function_exists("get_random_alphanumeric")) {
    function get_random_alphanumeric($length)
    {
        $token        = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "0123456789";
        $max          = strlen($codeAlphabet); // edited
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
        }
        return $token;
    }
}


if (!function_exists("format_rupiah")) {
    function format_rupiah($currency, $nilai = 0)
    {
        return $currency . ' ' . number_format($nilai, 0, ',', '.');
    }
}

if (!function_exists("format_tanggal_indonesia")) {
    function format_tanggal_indonesia($tanggal, $use_day = false)
    {
        $hari    = array(
            '1' => 'Senin',
            '2' => 'Selasa',
            '3' => 'Rabu',
            '4' => 'Kamis',
            '5' => 'Jumat',
            '6' => 'Sabtu',
            '7' => 'Minggu',
        );
        $hari_en = date('N', strtotime($tanggal));

        $bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        // pecah string
        $tanggalan = explode('-', $tanggal);
        if ($use_day) {
            return $hari[$hari_en] . ', ' . $tanggalan[2] . ' ' . $bulan[$tanggalan[1]] . ' ' . $tanggalan[0];
        } else {
            return $tanggalan[2] . ' ' . $bulan[$tanggalan[1]] . ' ' . $tanggalan[0];
        }
    }
}
if (!function_exists("split_name")) {
    function split_name($name)
    {
        $name       = trim($name);
        $last_name  = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return array($first_name, $last_name);
    }
}
if (!function_exists('aasort')) {
    function aasort(&$array, $key)
    {
        $sorter = array();
        $ret    = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        return $array = $ret;
    }
}
if (!function_exists('buildTree')) {
    function buildTree(array $elements, $parentId = 0)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
}
if (!function_exists('area_convert')) {
    function area_convert($table = '', $where = [])
    {
        $CI =& get_instance();
        return $CI->db->get_where($table, $where, 1)->result_array();
    }
}


function generate_new_id_string()
{
    return strtoupper(date('ymd') . uniqid());
}

function getting_match_city_la()
{

}