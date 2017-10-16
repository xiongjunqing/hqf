requirejs.config({
    baseUrl: 'js_src',
    paths: {
        "jquery": 'jquery/jquery',
        "bootstrap": "bootstrap/bootstrap.min",
        "bootbox": "bootbox/bootbox.min",
        "select2": "select2/select2.full.min"
    },
    shim:{
        "bootstrap":{
            deps:['jquery']
        },
        "bootbox": {
            deps:['jquery']
        },
        "select2":{
            deps:['jquery']
        }
    }
});
 
