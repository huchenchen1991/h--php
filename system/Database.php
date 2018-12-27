<?php
/**
*数据库操作的基类，定义了数据库的基本操作，底层为PDO
*/
class Database{
	// const 

	private $where_key = array();
	private $where_opt = array();
	private $where_value = array();
	private $set_fields = array();
	protected $_dbhandle;
	// 数据库连接函数
	public function connectDB($host,$db_name,$username,$password)
	{
		$dsn = sprintf("mysql:host=%s;dbname=%s",$host,$db_name);
		try{
			$this->_dbhandle = new PDO($dsn,$username,$password,array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
		}catch(PDOException $e){
			die("数据库连接错误，请查看数据库配置：".$e->getMessage());
		}
	}

	/**
	*定义数据库的基本操作
	*/

	// 获取所有数据
	public function findAll()
	{
		$sql = sprintf("select * from %s",$this->_table);
		$stmt = $this->_dbhandle->prepare($sql);
		$stmt->execute();
		$stmt->_dbhandle = NULL;
		return $stmt->fetchAll();
	}

	// 获取一条数据
	public function findOne()
	{
		$sql = sprintf("select * from %s limit 1",$this->_table);
		$stmt = $this->_dbhandle->prepare($sql);
		$stmt->execute();
		$stmt->_dbhandle = NULL;
		return $stmt->fetch();
	}

	// 获取所有数据数量
	public function countAll()
	{
		$sql = sprintf("select * from %s",$this->_table);
		$stmt = $this->_dbhandle->prepare($sql);
		$stmt->execute();
		$stmt->_dbhandle = NULL;
		return count($stmt->fetchAll());
	}


	//执行自定义了sql语句,查询大于一条内容
	public function findAllBySql($sql)
	{
		$stmt = $this->_dbhandle->prepare($sql);
		$stmt->execute();
		$this->_dbhandle = NULL;//释放PDO句柄
		return $stmt->fetchAll();
	}

	//执行自定义了sql语句,查询一条内容
	public function findOneBySql($sql)
	{
		$stmt = $this->_dbhandle->prepare($sql);
		$stmt->execute();
		$this->_dbhandle = NULL;//释放PDO句柄
		return $stmt->fetch();
	}

	// 增删改
	public function execSQL($sql)
	{
		$stmt = $this->_dbhandle->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();
	}



}

?>