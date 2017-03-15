<?php

class Core extends Dispatcher
{
	private static $_instance = null;
	protected $_sessionData = null;
	protected $controller = null;
    private $_route;
    
	public function __construct()
	{
		if (isset(self::$_instance)) {
			$message = 'Instance already defined use Core::getInstance';
			throw new Exception($message);
		}
        $this->_initSession();
        $this->_initBundles();
        $this->_route = new Route();
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
    
    public function make()
    {
        
    }
    
    public function terminate()
    {
        SystemLog::showInfo();
    }
    
	public function start()
	{
	    SystemLog::startRecord();
        
		$this->controller = new Controller();

		$currentRouteConfig =  $this->_route->pareseUrl();
        $rules = $this->_route->getRules();
		if ($this->_hasExistMethodControllerByConfig($currentRouteConfig)) {

			if ($this->_isAuthRoute($currentRouteConfig)) {
			    $user = Controller::getModule('User');
                $user->login();
				return true;
			}
            
            if ($this->getUserID()) {
                $this->_doCheckRoleRules($currentRouteConfig['role'], $rules);
            }
            
            
            $controllerName = $currentRouteConfig['controller'];
            
            $controller = Controller::getModule($controllerName);
            
			$method = $currentRouteConfig['method'];
			
			$params = array();
            $response = new Response();
            $params[] = &$response;
			$maches = $currentRouteConfig['matches'];
			$params = array_merge($params, $maches);
            
			call_user_func_array(
				array($controller, $method),
				$params
			);
            
            $this->_doPrepareResponseByAnnotationss(
			    $response,
			    $controller,
			    $method
            );
            
			$response->send($controller);
			
			return true;
		}
		throw new NotFoundException();
	}

    public function send()
    {
        
    }
    
    private function _doPrepareResponseByAnnotationss(
        $response, $controller, $method
    )
    {
        $annotations = $this->getClassAnnotations($controller, $method);
        
        if (!$annotations) {
            return false;
        }
        
        foreach ($annotations as $annotation) {
            $params = explode(" ", $annotation);
            
            $const = $params[2];
            
            if (!defined($const)) {
                throw new Exception(sprintf('Constant not found %s', $const));
            }
            switch($params[1]) {
                case 'type': 
                    $response->setType(constant($const));
                    break;
                case 'action':
                    $response->setAction(constant($const));
                    break;
                default: 
                    break;
            }
        }
        
        return true;
    }
    
    // TODO: move to Controller
    public function getClassAnnotations($class, $method)
    {
        $r = new ReflectionMethod($class, $method);       
       
        $doc = $r->getDocComment();
        
        $allow = array(
            'Response'
        );
        
        $regExp = '#@('.implode("|", $allow).'.*?)\n#s';
        
        preg_match_all($regExp, $doc, $annotations);
        
        if (empty($annotations[1])) {
            return false;
        }
        
        return $annotations[1];
    }

    private function _doCheckRoleRules($role, $rules)
    {
        if (!$role) {
            return true;
        }
        
        $userID = $this->getUserID();
        $userModule = Controller::getModule('User');
        $user = $userModule->getUserByID($userID);
        
        if (!array_key_exists($role, $rules)) {
            return true;    
        }
        
        $rule = $rules[$role];
        
        if (in_array($user['role'], $rule)) {
            return true;        
        }
        
        throw new PermissionException();
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
		   
            $dirPath = MODULES_DIR.$class.'/';
            $dirPath = str_replace('Object', '', $dirPath);
            $filePath = $dirPath.$class.'.php';
            if (!file_exists($filePath)) {
                throw new Exception("Class Not Found: ". $filePath);
            }
            require_once $filePath;
        });
    }

	public function getController()
	{
		return new Controller();
	}
	
	public function getUserID()
	{
		if (array_key_exists('user_id', $this->_sessionData)) {
			return $this->_sessionData['user_id'];
		}
		
		return false;
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