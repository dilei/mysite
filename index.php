<?php
define('APPLICATION_PATH', dirname(__FILE__));

define('IS_CGI',(0 === strpos(PHP_SAPI,'cgi') || false !== strpos(PHP_SAPI,'fcgi')) ? 1 : 0 );
define('DS', DIRECTORY_SEPARATOR); // 分隔符

$application = new Yaf_Application(APPLICATION_PATH . "/conf/home.ini");
$application->bootstrap()->run();
