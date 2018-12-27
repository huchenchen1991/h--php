<?php
// require_once(LIB_PATH.'Redis.php');

class RedisTestController extends H_Controller{
	public function index(){
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		$redis->set('a', 1);
		echo $redis->get('a');
	}
}
?>