<?php
class IndexController extends H_Controller{
	private $a=3;
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		var_dump(phpinfo());die;
		echo $this->a;
		$this->render('view');//渲染视图
		$this->db('test');//调用模型
	}	

}
?>