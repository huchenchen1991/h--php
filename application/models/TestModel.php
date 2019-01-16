<?php
class MYTestModel extends H_Model{
	public function get($id)
	{
		//数据库操作方法在
		$sql = "select *from test where id = $id";
		$re = $this->findOneBySql($sql);
		return $re;
	}

	public function test($str)
	{
		$sql = "insert into mytest(username,age,school) values($str,22,'a')";
		$re = $this->exec($sql);
	}
}
?>