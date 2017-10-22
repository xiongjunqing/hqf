<?php

/*
 * 给页面加载公共的样式文件
 * */

function baseCss($arr = [])
{
    $base_css = [
        'bootstrap.min',
        'bootstrap-responsive.min',
        'select2_metro',
        'bootstrap-datetimepicker.min',
        'prettify',
        'font-awesome.min',
        'style-metro',
        'style',
        'style-responsive',
        'default',
        'uniform.default',
    ];

    if(!empty($arr))
    {
        $base_css = array_merge($base_css,$arr);
    }

    foreach ($base_css as $key => $val)
    {
        echo "<link rel=\"stylesheet\" href=\"" .  config('app.url'). ('media/css/' . $val . '.css') . "\">";
    }
}

function extraCss($arr = [])
{
    if(empty($arr))
    {
        return;

    }

    foreach ($arr as $val)
    {
        echo "<link rel=\"stylesheet\" href=\"" .  config('app.url'). ('media/css/' . $val . '.css') . "\">";
    }

}

