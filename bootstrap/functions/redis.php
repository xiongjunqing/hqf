<?php

use Illuminate\Support\Facades\Redis;

/*
 * @param string $key
 * 以下方法封装了redis的一些常用的方法，方便全局调用
 * 更多方法可以在这个文件中添加
 * see http://www.cnblogs.com/blog-dyn/p/6610029.html
 * */








/*
 * 判断是否存在某个键
 * */
function redis_exists($key)
{
    return Redis::exists('key');
}

/*
 * 存入redis
 * */
function redis_set($key,$val)
{
    if(empty($key) || empty($val))
    {
        return false;
    }

    return Redis::set($key, $val);
}

/*
 * 获取redis中的值
 * */
function redis_get($key)
{
    if(empty($key))
    {
        return false;
    }

    return Redis::get($key);
}


/*
 * 获取队列长度
 * */
function redis_lLen($key)
{
    if(empty($key))
    {
        return false;
    }

    return Redis::lLen($key);
}

/*
 * 右侧出队列
 * */
function redis_rpop($key)
{
    if(empty($key))
    {
        return false;
    }

    return Redis::rpop($key);
}

/*
 * 右侧存入队列
 * */
function redis_rpush($key,$val)
{
    if(empty($key) || empty($val))
    {
        return false;
    }

    return Redis::rpush($key,$val);
}