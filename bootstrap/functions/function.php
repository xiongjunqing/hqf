<?php

/*
 * @param array $functions
 * */
function load_functions($fun = [])
{
    if(empty($fun))
    {
        return false;
    }

    foreach ($fun as $key => $val)
    {
        if(is_file(__DIR__ . '/' . $val . '.php'))
        {
            require __DIR__ . '/' .  $val . '.php';

        }

    }
}

/* @param string $log_name
 * @param mixed $content
 * 全局日志方法
 * */

function write_log($log_name, $content)
{
    if (!$log_name || !$content) {
        return false;
    }

    $dirname = date('Ymd', time());

    $dirname = __DIR__ . '/../../storage/logs/' . $dirname;

    try {
        if ( !file_exists( $dirname) || !is_dir( $dirname)) {
              mkdir($dirname);
        }

        $fp = fopen( $dirname . '/' . $log_name . '.log', 'a+');

        $content = var_export($content,true);
        fwrite($fp,$content . PHP_EOL);

        fclose($fp);

    } catch (Exception $e){

        return "there is something wrong in write_log function";
    }
}


/*
 * @param string $fileName
 * 返回文件的后缀
 * */
function file_suffix($fileName)
{
    if(!$fileName) return false;

    return substr(strrchr($fileName, '.'), 1);
}


/*
 * @param string $file_name
 * @param string $title
 * @param string $type
 * @param array  $patams
 * 全局的文件导出方法
 * $type csv xls xlsx
 *
 * see http://www.maatwebsite.nl/laravel-excel/docs/export
 * */

//function export($file_name, $title, $ype = 'csv', $params = [])
//{
//    if(empty($file_name)){
//        return "file name cann't be empty";
//    }
//
//    Excel::create($file_name, function($excel){
//
//        $excel->setTitle($title);
//
//        $excel->setCreator()
//    })->export($type);
//}


