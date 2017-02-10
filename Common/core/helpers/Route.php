<?php

class Route
{
    private $_requestUri;
    private static $_routes = array();
    private $_rules = array();

    public function pareseUrl()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestUriArray = explode('?', $requestUri);

        $currentUri = $requestUriArray[0];
        /* uri => array('controller'  => 'method') */
        $result = array();

        $routes = $this->_getRoutes();

        foreach ($routes as $uri => $config) {
            $uri  = '#^'.$uri.'$#';
            if (preg_match($uri, $currentUri, $matches)) {
                array_shift($matches);

                $use = explode('@', $config['use']);

                $auth = false;
                
                if (array_key_exists('auth', $config) && $config['auth']) {
                    $auth = true;
                }
                
                if (array_key_exists('role', $config) && $config['role']) {
                    $role = $config['role'];
                }
                
                $result = array(
                    'uri'        => $uri,
                    'matches'    => $matches,
                    'controller' => $use[0],
                    'method'     => $use[1],
                    'auth'       => $auth,
                    'role'       => $role
                );
            }
        }

        return $result;
    }

    public static function get($url, $params=array())
    {
        if (array_key_exists($url,static::$_routes )) {
            throw new Exception('Route is Exists: '.$url);
        }
        static::$_routes[$url] = $params;
    }

    private function _getRoutes()
    {
        $routes = array();
        require_once COMMON_DIR.'/config/routes.php';
        
        static::$_routes = array_merge(static::$_routes, $data['routes']);
        
        $this->_rules = $data['rules'];
        
        return static::$_routes;
    }
    
    public function getRules()
    {
        return $this->_rules;
    }
}