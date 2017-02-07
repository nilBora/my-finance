<?php

class Core extends Dispatcher
{
	private static $_instance = null;
	private $_request = null;
	private $_requestUri;
	protected $_sessionData = null;
	private $_layout = 'layout.phtml';
	public $socketInstance = null;
	protected $controller = null;
	protected $bundle = null;

	public function __construct()
	{
		if (isset(self::$_instance)) {
			$message = 'Instance already defined use Core::getInstance';
			throw new Exception($message);
		}

		if (!array_key_exists('sessionData', $_SESSION)) {
			$this->_sessionData = array(
				'auth' => ''
			);
		} else {
			$this->_sessionData = $_SESSION['sessionData'];
		}

		$this->bundle = new stdClass();
	}

	public static function getInstance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function start()
	{
		$this->controller = new Controller();
		$this->_initBundles();

		$route = new Route();
		$currentRouteConfig = $route->pareseUrl();

		if ($this->_hasExistMethodControllerByConfig($currentRouteConfig)) {

			if ($this->_isAuthRoute($currentRouteConfig)) {
				$main = $this->bundle->User;
				$main->login();
				return true;
			}

			$controller = $this->bundle->$currentRouteConfig['controller'];
			$method = $currentRouteConfig['method'];
			//$controller->$method();
			$params = $currentRouteConfig['matches'];
			call_user_func_array(
				array($controller, $method),
				$params
			);
			return true;
		}
		throw new NotFoundException();
	}

	private function _hasExistMethodControllerByConfig($currentRouteConfig)
	{
		return $currentRouteConfig &&
		 	   method_exists(
				   $currentRouteConfig['controller'],
				   $currentRouteConfig['method']
			   );
	}

	private function _isAuthRoute($currentRouteConfig)
	{
		return $currentRouteConfig['auth'] && !$this->_isAuthInSessionData();
	}

	private function _initBundles()
	{
		$bundles = $this->_getActiveBundles();

		foreach ($bundles as $dir) {
			if (!$this->_isBundleDir($dir)) {
				continue;
			}
			$dirPath = BUNDLE_DIR . $dir . "/";

			$nameController = $dir;

			if (!$this->_isExistsPHPFileByPath($dirPath . $nameController)) {
				throw new SystemException('Not file controller ' . $dirPath . $nameController);
			}
			if (class_exists($nameController)) {
				continue;
			}

			$this->_doCreateBundlesInstance($dirPath, $nameController);

			$this->_doCreateObjectsBundlesInstance($dirPath, $nameController);


			$this->_doIncludeValuesObject($dirPath, $nameController);
		}
	}

	private function _doCreateBundlesInstance($dirPath, $nameController)
	{
		require_once $dirPath . $nameController . ".php";

		$instanceBundle = new $nameController($dirPath);

		$this->bundle->$nameController = $instanceBundle;

		return true;
	}

	private function _doCreateObjectsBundlesInstance($dirPath, $nameController)
	{
		$nameObject = $nameController . 'Object';
		if ($this->_isExistsPHPFileByPath($dirPath . $nameObject)) {
			if (class_exists($nameObject)) {
				return false;
			}

			require_once $dirPath . $nameObject . ".php";
			$instanceBundleObject = new $nameObject();

			$this->bundle->$nameController->object = $instanceBundleObject;
		}

		return true;
	}

	private function _doIncludeValuesObject($dirPath, $nameController)
	{
		$valuesObject = $nameController . 'ValuesObject';
		if ($this->_isExistsPHPFileByPath($dirPath . $valuesObject)) {

			require_once $dirPath . $valuesObject . ".php";
		}
	}

	public function getControllers()
	{
		return $this->controller;
	}

	private function _getActiveBundles()
	{
		$bundles = scandir(BUNDLE_DIR);
		if (!$bundles && !is_array($bundles)) {
			throw new Exception('Not bundles in folder' . BUNDLE_DIR);
		}

		$bundles = array(
			'Queue',
			'User',
			'Main',
			'Finance'
		);

		return $bundles;
	}


	private function _isExistsPHPFileByPath($path)
	{
		return file_exists($path.'.php');
	}

	private function _isBundleDir($dir)
	{
		return is_dir(BUNDLE_DIR.$dir) && $dir != "." && $dir != "..";
	}
	
	public function getUserID()
	{
		if (array_key_exists('user_id', $this->_sessionData)) {
			return $this->_sessionData['user_id'];
		}
		
		return false;
	}

	public function getUser()
	{
		return 1;
	}

	private function _isAuthInSessionData()
	{
		return array_key_exists('auth', $this->_sessionData)
			   && $this->_sessionData['auth'];
	}
	
	public function _setSession($key, $value)
	{
		$this->_sessionData[$key] = $value;
		$_SESSION['sessionData'][$key] = $value;
	}
	
	private function _isUrlInRequest()
	{
		return array_key_exists('url', $this->_request);
	}

	public function doClearSession()
	{
		unset($_SESSION['sessionData']['auth']);
		unset($this->_core->_sessionData['auth']);
		unset($this->_core->_sessionData['user_id']);

		return true;
	}

	public function getBundles()
	{
		return $this->bundle;
	}
}