<?php

class Dev
{

}


function _print_r($arr)
{
    echo '<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />';
    echo '<pre>';
    print_r($arr);
    echo '<pre>';
    exit;
}

function _var_dump($obj)
{
    echo '<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />';
    echo '<pre>';
    var_dump($obj);
    echo '<pre>';
    exit;
}

function _text_2_array($text, $seperator = ';', $filter = true)
{
    $arr = array_map('trim', explode($seperator, $text));
    if($filter == true) {
        $arr = array_unique(
            array_filter($arr)
        );
    }

    return $arr;
}


function sbs_url_exists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}


if(!function_exists('getallheaders')) {
    function getallheaders()
    {
        $headers = '';
        foreach ($_SERVER as $name => $value) {
            if(substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}
