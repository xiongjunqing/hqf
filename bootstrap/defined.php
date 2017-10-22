<?php
/**
 * 定义项目根目录
 */
define('ROOT_PATH', dirname(__DIR__));

define('APP_PATH', ROOT_PATH.'/app');

define('LIBS_PATH', APP_PATH.'/Libs');

define('LOG_PATH', ROOT_PATH.'/storage/logs');

define('DATA_PATH', ROOT_PATH . '/storage/datas');


//开发环境配置变量
if(is_file('/hqf_dev.env')){
    define('ENV_LARAVEL','development');
    define('IN_PRODUCTION',false);
}else{
    define('ENV_LARAVEL','production');
    define('IN_PRODUCTION',true);
}

