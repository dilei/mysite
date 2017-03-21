<?php
$module = "Admin";
$controller = "User";
$action = "index";
$request = new Yaf_Request_Simple("CLI", $module, $controller, $action, array("name" => 2));
// print_r($request);

define('APPLICATION_PATH', dirname(__FILE__));
$app = new Yaf_Application(APP_PATH."/conf/home.ini");
// $app->bootstrap()->run();
// $app->getDispatcher()->dispatch(new Yaf_Request_Simple());

// 不需要初始化的时候这样做
// $app->getDispatcher()->dispatch($request);

// 需要初始化的时候这样做
$app->bootstrap()->getDispatcher()->dispatch($request);
