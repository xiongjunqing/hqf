<?php

/**
 * 获取静态资源地址
 *
 * @link   http://docs.phalconphp.com/zh/latest/api/Phalcon_Mvc_Url.html
 *
 * @param  string   $uri
 * @param  string   $time
 * @return string
 */
function static_url($uri = null, $time = true, $request = null)
{
    if (!preg_match('~t=\d+$~i', $uri) && $time) {
        $params = ['t' => DEVELOPMENT ? time() : app_update_time()];
    } else {
        $params = null;
    }

    if (!preg_match('~^https?://~i', $uri) && !is_null($request)) {

        $uri = $request->url();
    }
    return $uri;

    return url_param($uri, $params);
}

/**
 * 获取包含域名在内的 url
 *
 * @param  string   $uri
 * @param  string   $base
 * @return string
 */
function baseurl($uri = null, $base = HTTP_BASE)
{
    return $base . ltrim($uri, '/');
}

/**
 * 根据 query string 参数生成 url
 *
 *     url_param('item/list', array('page' => 1)) // item/list?page=1
 *     url_param('item/list?page=1', array('limit' => 10)) // item/list?page=1&limit=10
 *
 * @param  string   $uri
 * @param  array    $params
 * @return string
 */
function url_param($uri = null, array $params = null)
{
    if (null === $uri) {
        $uri = HTTP_URL;
    }

    if (empty($params)) {
        return $uri;
    }

    $parts   = parse_url($uri);
    $queries = [];
    if (isset($parts['query']) && $parts['query']) {
        parse_str($parts['query'], $queries);
    }

    // xss 修正
    $params = array_merge($queries, $params);
    foreach ($params as $key => &$val) {
        $val = htmlspecialchars($val, ENT_QUOTES);
    }

    // 重置 query 组件
    $parts['query'] = rawurldecode(http_build_query($params, null, '&amp;'));

    return http_build_url($uri, $parts);
}


/**
 *  调用百度短链接api 生成短链接
 * @param  [string] $url                      [要处理的长链接]
 * @return [string] [生成后的短链接]
 */
function shortUrlFromBaidu($url, $noHttp = false)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://dwz.cn/create.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $data = ['url' => $url];

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $strRes = curl_exec($ch);
    curl_close($ch);

    $arrResponse = json_decode($strRes, true);
    if (0 != $arrResponse['status']) {
        /**错误处理*/
        write_log(__FUNCTION__, 'Error: ' . $arrResponse['err_msg']);

        return (PRODUCTION) ? false : $url;
    }

    return $noHttp ? str_replace("http://", "", $arrResponse['tinyurl']) : $arrResponse['tinyurl'];
}

// 对url 的参数进行 urlencode的 操作
function urlencodeParams($url)
{
    preg_match('/^(.*?)\?(.*)/', $url, $matchs);

    if (count($matchs) <= 2) {
        return $url;
    }

    $urlHead   = $matchs[1];
    $urlParams = $matchs[2];

    $params = explode('&', $urlParams);

    $num = count($params);
    for ($i = 0; $i < $num; $i++) {
        $temp = $params[$i];

        $temps      = explode('=', $temp);
        $temps[1]   = urlencode($temps[1]);
        $params[$i] = $temps[0] . '=' . $temps[1];
    }

    return $urlHead . '?' . implode('&', $params);
}
