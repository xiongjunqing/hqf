<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        return view('/index/index',[
            'test'       => 'xjq',
            'require_js' => 'test',
        ]);
    }
}
