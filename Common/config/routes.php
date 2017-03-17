<?php

//TODO: Routing
//Route::get('/test2/', array('use' => 'Main@tests', 'auth'=>false));

$routes = array(
    '/login/'  		  => array('use' => 'User@login', 'auth'=>true, 'role' => 'user'),
    '/logout/'  	  => array('use' => 'User@logout', 'auth'=>true, 'role' => 'user'),
    '/'		   		  => array('use' => 'Finance@displayIndex', 'auth'=>true, 'role' => 'user'),
    '/cash/save/'     => array('use' => 'Finance@doSaveCash', 'auth' => true, 'role' => 'user'),
    '/charts/'        => array('use' => 'Finance@onDisplayCharts', 'auth' => true, 'role' => 'user'),
    '/test/([0-9]+)/' => array('use' => 'Finance@test', 'auth' => false),
    '/admin/'         => array('use' => 'Finance@testAdmin', 'auth' => true, 'role' => 'admin'),
    '/api/(.+)/'      => array('use' => 'RESTfulApi@onApiRequest'),
    '/redirect/'      => array('use' => 'Finance@onRedirect')  
);

$rules = array(
    'user'  => array('user', 'admin'),
    'admin' => array('admin')
);

$data = array(
    'routes' => $routes,
    'rules'  => $rules
);

return $data;