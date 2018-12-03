<?php
/**
*视图基类
*/

class H_View{
	protected $params = array();

// 视图变量分配
	public function assign($key,$value)
	{
		$this->params[$key] = $value;
	}


//视图渲染逻辑
	public function render($viewpath,$paramsarr = array())
	{
		// 处理assign()分配来的参数数组
		extract($this->params);

		// 处理控制器传来的数组
		extract($paramsarr);
		
		$viewspath = APP_PATH.'views/'.$viewpath;
		$viewspathPHP = APP_PATH.'views/'.$viewpath.'.php';
		$viewspathHTML = APP_PATH.'views/'.$viewpath.'.html';
		if(is_file($viewspath)){
			require_once($viewspath);
		}elseif(is_file($viewspathHTML)){
			require_once($viewspathHTML);
		}elseif(is_file($viewspathPHP)){
			require_once($viewspathPHP);
		}else{
			echo "404 NOT FOUND VIEW";
		}
	}
}
?>