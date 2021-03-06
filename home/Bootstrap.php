<?php
/**
 * @name Bootstrap
 * @author root
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{

    public function _initConfig() {
		//把配置保存起来
		$arrConfig = Yaf_Application::app()->getConfig();
		Yaf_Registry::set('config', $arrConfig);

        // 加入自己的自动加载
        // require 'vendor/autoload.php';
        Yaf_Loader::import(APPLICATION_PATH . "/vendor/autoload.php");
        /* 加载自定义函数 */
        // Yaf_Loader::import("Helper.php");
	}


    public function _initDefaultName(Yaf_Dispatcher $dispatcher) {
        /**
         *                  
         * 这个只是举例, 本身Yaf默认的就是"Index"
         */
        // $dispatcher->setDefaultModule("Admin")->setDefaultController("User")->setDefaultAction("index");
    }

    public function _initPlugin(Yaf_Dispatcher $dispatcher) {
        //注册一个插件
        $objSamplePlugin = new SamplePlugin();
        $dispatcher->registerPlugin($objSamplePlugin);

        $objSamplePlugin = new UserPlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
         $router = Yaf_Dispatcher::getInstance()->getRouter();
         /**
          * 添加配置中的路由
          */
         $router->addConfig(Yaf_Registry::get("config")->routes);
    }
	
	public function _initView(Yaf_Dispatcher $dispatcher){
		//在这里注册自己的view控制器，例如smarty,firekylin
	}
}
