<?php
/**
*控制器的基类
*/
class H_Controller{
	protected $_view;
	protected $_model;
	public function __construct()
	{
		$this->_view = new H_View();
		// $this->_model = new H_Model();
	}

	//分配key与value给视图使用
	public function assign($key , $value)
	{
		$this->_view->assign($key,$value);
	}

	//第二种渲染视图的方式，调用render函数
	public function render($viewpath , $paramsarr = array())
	{
		$this->_view->render($viewpath,$paramsarr);
	}


	//实例化模型类，传入application/models后的相对路径
	public function db($modelpath , $dbname = "default")
	{
		//删除$modelpath后缀的  .php
		$modelpath = preg_replace("/.php/","",$modelpath);

		// 判断是否存在model或者Model
		if(!strpos($modelpath, 'model') AND !strpos($modelpath, 'Model')){
			// 不存在则加上model
			$modelpath = $modelpath.'model';
		}
		$modelFile = $modelpath.'.php';
		$modelArr = explode('/', $modelpath);
		$modelNme = end($modelArr);

		// 加载模型类
		require_once(APP_PATH.'models/'.$modelFile);
		// 实例化模型类
		$this->db = new $modelNme();
		// 获取表名字
		$this->db->table = preg_replace("/model/","",strtolower($modelNme));
		//连接数据库
		$this->db->connect($this->db->table , $dbname);

		return $this->db;	
	}

	//连接redis
	public function redis()
	{
		
	}

	// 切换数据库连接
	public function changedb($dbname)
	{
		$this->_model->changedb($dbname);
	}
}
?>