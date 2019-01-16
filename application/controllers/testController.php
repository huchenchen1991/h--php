<?php
class TestController extends H_Controller{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$db=$this->db('test');
		$re = $db->test("呵呵爱丽丝堵我IE的");
		// $this->render('view'); //渲染视图
	}	

	public function testSQL($id)
	{
		$db = $this->db('test');//调用模型
		$re = $db->get($id);//调用模型类中的get方法
		echo json_encode($re);//echo 返回值
	}

	public function testIndex()
	{
		$db=$this->db('test');
		$re = $db->test("呵呵爱丽丝堵我IE的");

	}
}
?>