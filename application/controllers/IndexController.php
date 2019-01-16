<?php
class IndexController extends H_Controller{
	const B = 4;
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

	public function time33($str) {
	    $hash = 0;
	    $s = md5($str);
	    $len  = 32;
	    for ($i = 0; $i < $len; $i++) {
	        $hash = ($hash * 33 + ord($s{$i})) & 0x7FFFFFFF;
	    }
	    return $hash;
	}

	public function &test(){
		$a = 4;
		return $a;
	}

}
?>