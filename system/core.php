<?php
/*
*PHP核心类
*/
class core{
	private static $instance;

	//定义静态实例化方法
	public static function &get_instance()
	{
		if(!self::$instance){
			self::$instance = new core();
		}
		return self::$instance;
	}

//启动框架
	public function start()
	{
		/**
		*注册自动加载，将autoLoad() 函数注册为自动加载函数，当实例化类时找不到该类就会调用该方法
		*调用方法时，会将被实例化的类名传入autoload() 函数作为参数
		*spl_autoload_register() @param array('类名'，’该类下的方法名‘)
		*/
		spl_autoload_register(array($this,'autoLoad'));

		// require类库与全局函数文件
		$this->requireFile();

		//删除斜杠
		$this->removeMagicQuotes();

		//移除全局
		$this->removeRegisterGlobals();

		//路由解析
		$this->routeParse();

	}


	// 定义自动加载函数，加载顺序system -> controllers ->models
	private static function autoLoad($classname)
	{
		$systemFile = SYS_PATH.$classname.'.php';
		$controllerFile = APP_PATH.'contrllers/'.$classname.'.php';
		$modelFile = APP_PATH.'models/'.$classname.'.php';

		//先自动加载直接建立在system，controller与model下的类。
		if(file_exists($systemFile)){
			//如果类名在system目录下，则自动加载
			require_once($systemFile);

		}elseif (file_exists($controllerFile)){
			// 类名在controller目录下，则自动加载
			require_once($controllerFile);

		}elseif(file_exists($modelFile)){
			// 类名在models目录下，则自动加载
			require_once($modelFile);
		}

	}

	 //加载系统与自定义的类库，函数
	 private function requireFile()
	 {
	 	// 定义类库路径
	 	$librariesPath = ROOT_PATH.'libraries';

	 	//定义全局函数路径
	 	$functionsPath = ROOT_PATH.'functions';

	 	//定义加载路径数组
	 	$require_arr = array($librariesPath , $functionsPath);

	 	//循环加载两个路径下的php文件
	 	foreach ($require_arr as $path) {
	 		// 以目录为参数调用getFileFromDir($dirPath)函数，去加载目录下的php文件
	 		$this->getFileFromDir($path);
	 	}

	 }


	// 从目录中一直循环拿到每个文件，然后加载
	 private function getFileFromDir($dirPath)
	 {
	 	//如果是php文件，则加载
	 	if(is_file($dirPath)){
	 		require_once($dirPath);
	 	}elseif(is_dir($dirPath)){
	 		$files = scandir($dirPath);
	 		array_shift($files);
	 		array_shift($files);
	 		foreach ($files as $file){
	 			$filePath = $dirPath.'/'.$file;
	 			if(is_file($filePath)){
	 				require_once($filePath);
	 			}elseif(is_dir($filePath)){
	 				$this->getFileFromDir($filePath);
	 			}
	 		}
	 	}
	 }


	// 删除企斜杠
	private function stripSlashesDeep($val)
	{
		$value = is_array($val) ? array_map('stripSlashesDeep', $val) : stripcslashes($val);
		return $value;

	}


	// 检测是否开启‘为用户提供的数据增加斜杠’,有则删除
	private function removeMagicQuotes()
	{
		if(get_magic_quotes_gpc()){
			$_GET = $this->stripSlashesDeep($_GET);
			$_POST = $this->stripSlashesDeep($_POST);
			$_COOKIE = $this->stripSlashesDeep($_COOKIE);
			$_SESSION = $this->stripSlashesDeep($_SESSION);
		}
	}

	/**
	*检测自定义全局变量并删除
	*百度：ini_get('register_globals')查看：
	register_globals是php.ini里的一个配置，这个配置影响到php如何接收传递过来的参数
	register_globals的值可以设置为：On或者Off
	当register_globals=Off的时候，下一个程序接收的时候应该用$_GET['user_name']和$_GET['user_pass']来接受传递过来的值。（注：当<form>;的method属性为post的时候应该用$_POST['user_name']和$_POST['user_pass']）
	当register_globals=On的时候，下一个程序可以直接使用$user_name和$user_pass来接受值。
	*所以该方法，移除全局变量中与用户输入相同的全局变量，保证用户的输入能被正确执行
	*/
	private function removeRegisterGlobals(){
		if(ini_get('register_globals')){
			$arr = ['_SESSION','_COOKIE','_POST','_GET','_ENV','_FILES','_REQUEST','_SERVER'];
			foreach ($arr as $value) {
				foreach ($GLOBALS[$value] as $key => $val) {
					$GLOBALS[$key] = $val;
					unset($GLOBALS[$key]);
				}
			}
		}
	}


	// 路由解析
	private function routeParse()
	{
		// 定义默认控制器与默认方法
		$controllerName = "Index";
		$actionName = "index";
		$controllersPath = APP_PATH.'controllers/';
		// 判断是否有URI
		$uri = trim($_SERVER['REQUEST_URI'],'/');
		// 存在uri
		if($uri){
			$uriArray = explode('/', $uri);
			$firstItem = $uriArray[0];
			//如果uri第一项是不是目录，是目录则起目录中寻找
			// echo APP_PATH.'controllers/'.$firstItem;die();
			if(is_dir(APP_PATH.'controllers/'.$firstItem)){
				// 更改控制器目录
				$controllersPath = APP_PATH.'controllers/'.$firstItem.'/';
				//移除uriArray的第一项，目录部分
				array_shift($uriArray);
				// 获取控制器名
				$controllerName = $uriArray[0];
				// 控制器名首字母要大写
				$controllerName = ucfirst($controllerName);

				//移除控制器
				array_shift($uriArray);
				//获取方法名称
				$actionName = empty($uriArray)?"index" : $uriArray[0];
				// 移除方法名
				array_shift($uriArray);
				// 获取方法参数
				$queryString = empty($uriArray)?array() : $uriArray;
			}elseif(is_file(APP_PATH.'controllers/'.ucfirst($firstItem).'Controller.php')){
				$controllersPath = APP_PATH.'controllers/';
				$controllerName = ucfirst($firstItem);
				//移除数组第一项，控制器
				array_shift($uriArray);
				$actionName = empty($uriArray)?"index" : $uriArray[0];
				// 移除方法名
				array_shift($uriArray);
				// 获取方法参数
				$queryString = empty($uriArray)?array() : $uriArray;
			}

		}

		//如果没有进入if语句，那么需要处理查询字符串为空的情况
		$queryString = empty($queryString)?array():$queryString;
		
		//加载类文件
		$controllerClass = $controllerName.'Controller.php';//文件名
		$className = $controllerName.'Controller';//类名
		require_once($controllersPath.$controllerClass);
		$disPatch = new $className();
		// 判断类中是否存在对应方法
		if(method_exists($disPatch, $actionName)){
			$viewPath = call_user_func_array(array($disPatch,$actionName), $queryString);
			//有return字符串，解析字符串，加载对应视图
			if(isset($viewPath)){
				$viewFilePHP = $viewPath.'.php';
				$viewFileHTML = $viewPath.'.html';
				$viewFilePHPPath = APP_PATH.'views/'.$viewFilePHP;
				$viewFileHTMLPath = APP_PATH.'views/'.$viewFileHTML;
				$viewFilePath = APP_PATH.'views/'.$viewPath;
				if(is_file($viewFilePath)){
					require_once($viewFilePath);
				}elseif(is_file($viewFileHTMLPath)){
					require_once($viewFileHTMLPath);
				}elseif(is_file($viewFileHTMLPath)){
					require_once($viewFileHTMLPath);
				}else{
					echo "404 NOT FOUND VIEW";
				}
			}
		}else{
			echo $controllerClass.'中不存在方法（函数）：'.$actionName.' ()';
		}
	}


}

?>