<?php
class TestModel extends H_Model{
	public function get($id)
	{
		//数据库操作方法在
		$sql = "select *from test where id = $id";
		$re = $this->findOneBySql($sql);
		return $re;
	}
}
?>