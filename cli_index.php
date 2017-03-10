<?php
$module = "Admin";
$controller = "User";
$action = "index";
$request = new Yaf_Request_Simple("CLI", $module, $controller, $action, array("name" => 2));
// print_r($request);

define('APPLICATION_PATH', dirname(__FILE__));
$app = new Yaf_Application("conf/home.ini");
// $app->bootstrap()->run();
$app->getDispatcher()->dispatch(new Yaf_Request_Simple());
