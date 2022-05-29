<?php

/**
 * @return string
 */
function parse_some_host()
{
    $str = htmlentities("https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3");
    $parse_url =  parse_url($str);

    parse_str(htmlspecialchars_decode($parse_url['query']), $queryArr);
    asort($queryArr);

    $queryArr = array_filter($queryArr, function ($item){
        if ($item != 3) {
            return $item;
        }
    });

    $queryArr['url'] = $parse_url['path'];
    $query = htmlentities(http_build_query($queryArr));

    $result = $parse_url['scheme'] . "://" . $parse_url['host'] . "/?" . $query;

    return $result;
}

echo parse_some_host();