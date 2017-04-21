<?php
define('APPLICATION_PATH', dirname(__FILE__));

define('IS_CGI',(0 === strpos(PHP_SAPI,'cgi') || false !== strpos(PHP_SAPI,'fcgi')) ? 1 : 0 );
define('DS', DIRECTORY_SEPARATOR); // 分隔符

if (IS_CGI) {
    $request_uri = trim($_SERVER["REQUEST_URI"], "/");
    if ($request_uri) {
        $params = explode("/", $request_uri);
        $len  = count($params);
        if ($len == 1) {
            $module = $params[0];
            Yaf_Registry::set('module', $module);
        }
    }
}

$application = new Yaf_Application(APPLICATION_PATH . "/conf/home.ini");
$application->bootstrap()->run();
