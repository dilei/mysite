<?php


if (phpversion() >= "5.3") {
    $root = dirname(__DIR__);
} else {
    $root = dirname(dirname(__FILE__));
}
//xhprof 性能采集，1为100%采集  0 为不采集， 100为1%的几率采集,
// 生产环境请根据实际访问量情况修改
define('XHPROF_PROFILE_COUNT' , 0);

define("APP_PATH", $root);  //当前app的根目录
define("ROOT_PATH", $root); //系统根目录
ini_set('yaf.library', ROOT_PATH.'/phplib');
date_default_timezone_set('Asia/Shanghai');
//优先注册smarty的自动加载类 jiangsf
//本来不优先加载也可以，但是在测试环境下会先执行yaf的autoloader，然后会警告
define('SMARTY_SPL_AUTOLOAD', 1);
require_once APP_PATH."/phplib/Smarty/Smarty.class.php";

if (XHPROF_PROFILE_COUNT == 1) {
    require_once APP_PATH."/phplib/Ap/Xhprof.php";
}

//加载htmlpurifier
require_once APP_PATH."/phplib/lib/htmlpurifier/library/HTMLPurifier.auto.php";

$uri = $_SERVER['REQUEST_URI'];
$ary = explode('/', $uri);
if (count($ary) > 1 && strlen($ary[1]) > 0) {
    //这里也可以直接include模块的index.php入口文件
    $module = $ary[1];
} else {
    $module = 'index';
}
$modules = array('course','user','index','space','u','message','tms','sms',
            'cms','oms','error','wiki','activity','api','api2','api3','code','mobile','cooperation',
            'about','wap','visitlog', 'wenda', 'open','subject','corp','exp',
            'opus','myclub','article','highlines','seek','social','mall','szpublish','service','vms','search','seo', 'apiw', 't');
if(!in_array($module,$modules)){
        $module = 'index';
}


define("MODULE", $module);
Yaf_Registry::set('module', $module);
$config =  APP_PATH . '/conf/app.ini';
$app = new Yaf_Application($config);
Yaf_Registry::set('config', Yaf_Application::app()->getConfig());



try {
    $app->bootstrap();
    $app->run();
} catch (Exception $ex) {
    $message = $ex->getMessage();
    Ap_Log::error($message);
    if (ini_get('display_errors')) {
        $message .= '<br>'. nl2br($ex->getTraceAsString());
        echo $message;
        
    } elseif ($_SERVER['REQUEST_URI'] != '/error/wrong') {
       header("HTTP/1.0 404 Not Found");
       exit;
    }
}
