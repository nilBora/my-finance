<?php

class Core extends Dispatcher
{
	private static $_instance = null;
	protected $_sessionData = null;
	protected $controller = null;

	public function __construct()
	{
		if (isset(self::$_instance)) {
			$message = 'Instance already defined use Core::getInstance';
			throw new Exception($message);
		}
        $this->_initSession();
	}

	public static function getInstance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
    
    private function _initSession()
    {
        $this->_sessionData = array('auth' => '');
        
        if (array_key_exists('sessionData', $_SESSION)) {
           $this->_sessionData = $_SESSION['sessionData'];
        }

        return true;
    }
    
	public function start()
	{
		$this->controller = new Controller();
		$this->_initBundles();

		$route = new Route();
		$currentRouteConfig = $route->pareseUrl();

		if ($this->_hasExistMethodControllerByConfig($currentRouteConfig)) {

			if ($this->_isAuthRoute($currentRouteConfig)) {
			    $user = $this->controller->getBundleInstance('User');
                $user->login();
				return true;
			}
            
            $controllerName = $currentRouteConfig['controller'];
            
            $controller = $this->controller->getBundleInstance($controllerName);
			
			$method = $currentRouteConfig['method'];
			
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
		spl_autoload_register(function ($class) {
            $dirPath = BUNDLE_DIR.$class.'/';
            $dirPath = str_replace('Object', '', $dirPath);
            $filePath = $dirPath.$class.'.php';
            if (!file_exists($filePath)) {
                throw new Exception("Class Not Found: ". $filePath);
            }
            require_once $filePath;
        });
    }

	public function getControllers()
	{
		return $this->controller;
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

	public function doClearSession()
	{
		unset($_SESSION['sessionData']['auth']);
		unset($this->_sessionData['auth']);
		unset($this->_sessionData['user_id']);

		return true;
	}
}