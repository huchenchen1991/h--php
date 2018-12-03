<?php
/**
*模型类，做数据库连接
*/
class H_Model extends Database{
	protected $_model;
	protected $_table;//表名，供父类database使用


	//定义数据库连接方式
	public function connect($tablename , $dbname)
	{
		$this->_table = $tablename;
		$db = require_once(CONF_PATH.'database.php');
		if(!isset($db[$dbname])){
			die('$this->db()中的数据库不存在');
		}
		$host = $db[$dbname]['host'];
		$username = $db[$dbname]['username'];
		$password = $db[$dbname]['password'];
		$db_name = $db[$dbname]['dbname'];

		$this->connectDB($host,$db_name,$username,$password);
	}

	

}
?>