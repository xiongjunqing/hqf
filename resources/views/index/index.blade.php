<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{isset($title) ? $title : '花卿风企业订餐平台'}}</title>

        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/select2/select2.min.css">
    </head>

    <body>
        <!-- 加载公共页头 -->
        @if(!isset($header))
            @include('layout.header')
        @endif

        <!-- 页面内容 -->
        @if(!isset($content))
            @include('layout.content')
        @endif

        <!-- 加载公共页脚 -->
        @if(!isset($footer))
            @include('layout.footer')
        @endif

        <script type="text/javascript" src="require.js" ></script>
        <script>
            var require_js = ["../..{{isset($require_js) ? $require_js : ''}}"];
                requirejs(['../../config'], function(){
                    requirejs(require_js);
                });
        </script>
    </body>

</html>
