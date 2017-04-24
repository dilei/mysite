<?php
/**
 * @desc 控制器基类
 */
class BaseController extends Yaf_Controller_Abstract {

	/** 
     * 初始化方法
     */
	public function init() {
        // do somthing
		$this->getView()->assign("static_path", "/public/static/");
	}
}
