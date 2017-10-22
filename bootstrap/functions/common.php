<?php


function dump()
{
    echo '<pre>';

    foreach (func_get_args() as $v) {
        var_dump($v);
    }

    echo '</pre>';

    return null;
}


/**
 * post md5 加密数据
 */
function post_sign($url, $postdata, array $curl_opts = null)
{
    if (!isset($postdata['key'])) {
        return false;
    }
    $key             = $postdata['key'];
    $sign            = sign($postdata, $key);
    $postdata['key'] = $sign;
    $ch              = curl_init();
    if ('' !== $postdata && is_array($postdata)) {
        $postdata = http_build_query($postdata);
    }

    curl_setopt_array($ch, [
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_URL            => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POST           => 1,
        CURLOPT_POSTFIELDS     => $postdata,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FAILONERROR    => 1,
    ]);

    if (null !== $curl_opts) {
        curl_setopt_array($ch, $curl_opts);
    }

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function sign($data, $key)
{
    $unset = [
        'key',
        '_url',
    ];
    foreach ($unset as $k) {
        if (isset($data[$k])) {
            unset($data[$k]);
        }

    }
    ksort($data);
    $query = http_build_query($data);
    return md5($query . $key);
}

function create_uuid($prefix = "")
{
    $str  = md5(uniqid(mt_rand(), true));
    $uuid = substr($str, 0, 8) . '-';
    $uuid .= substr($str, 8, 4) . '-';
    $uuid .= substr($str, 12, 4) . '-';
    $uuid .= substr($str, 16, 4) . '-';
    $uuid .= substr($str, 20, 12);

    return $prefix . $uuid;
}

function create_str($length = 1)
{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'zUcQPaoXpZAYYfj8VYmqhbnm76UufYzTwoukpWizUtzaLJTFtmisywCgalhdSbVJCvyhJL4WF8STXc0RIsnrthT5chrtTouxbaCcoLwczTYkltuzthAzhuxwwsbcJ5SXq0sVywsRl77fiYrTTTmiph';
    $str   = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
        $str .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    return $str;
}

/**
 * 判断两个浮点数是否相等
 * @param  float  $num1
 * @param  float  $num2
 * @param  float  $diff
 * @return bool
 */
function float_eq($num1, $num2, $diff = 0.000001)
{
    return abs($num1 - $num2) < $diff;
}



/**
 * 和pr功能类似，只是在最末尾截断后面的输出
 */
function diepr()
{
    echo "<xmp>\n";
    foreach (func_get_args() as $var) {
        print_r($var);
    }
    echo '</xmp>';
    die;
}


function toArray($obj)
{
    return $obj ? $obj->toArray() : [];
}

/**
 * 生成订单号
 *
 * @return string 订单号
 */
function genOrderNo()
{
    return date('Ymd') . substr(implode(null, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

function replace_storage_extension($url)
{
    if (strpos($url, "storage/") === false) {
        return $url;
    }
    return rev_extension($url);
}

//反转扩展名
function rev_extension($url)
{
    $url = preg_replace_callback('/\.([a-zA-Z]+)/', function ($match) {
        return "." . strrev($match[1]);
    }, $url);
    return $url;
}

//驼峰命名改成下划线命名
function camel_to_line($name)
{
    $temp_array = [];

    for($i= 0; $i < strlen($name); $i++){

        $ascii_code = ord($name[$i]);

        if($ascii_code >= 65 && $ascii_code <= 90){

            if($i == 0){
                $temp_array[] = chr($ascii_code + 32);
            }else{
                $temp_array[] = '_'.chr($ascii_code + 32);
            }
        }else{
            $temp_array[] = $name[$i];
        }
    }
    return implode('',$temp_array);
}

/*移动端判断*/
function isMobile()
{ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
}
