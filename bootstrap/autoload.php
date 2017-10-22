<?php

define('LARAVEL_START', microtime(true));


/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/defined.php';

//  根据不同的环境读取相应的配置文件，线上环境默认是.env文件
//if(ENV_LARAVEL == 'development'){
//    $app->loadEnvironmentFrom('.env' . ENV_LARAVEL);
//}else{
//    $app->loadEnvironmentFrom('.env');
//}

require __DIR__.'/functions/function.php';

load_functions(['alias','redis','string','time','url','valid','common','array','media']);

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

$compiledPath = __DIR__.'/cache/compiled.php';

if (file_exists($compiledPath)) {
    require $compiledPath;
}
