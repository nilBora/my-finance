<?php

//TODO: Routing
//Route::get('/test2/', array('use' => 'Main@tests', 'auth'=>false));

$routes = [
    '/login/'  		  => ['use' => 'User@login', 'auth'=>true, 'role' => 'user'],
    '/logout/'  	  => ['use' => 'User@logout', 'auth'=>true, 'role' => 'user'],
    '/'		   		  => ['use' => 'Finance@displayIndex', 'auth'=>true, 'role' => 'user'],
    '/cash/save/'     => ['use' => 'Finance@doSaveCash', 'auth' => true, 'role' => 'user'],
    '/charts/'        => ['use' => 'Finance@onDisplayCharts', 'auth' => true, 'role' => 'user'],
    '/test/([0-9]+)/' => ['use' => 'Finance@test', 'auth' => false],
    '/admin/'         => ['use' => 'Admin@defaultIndex', 'auth' => true, 'role' => 'admin'],
    '/api/(.+)/'      => ['use' => 'RESTfulApi@onApiRequest'],
    '/redirect/'      => ['use' => 'Finance@onRedirect']  
];

$rules = [
    'user'  => ['user', 'admin'],
    'admin' => ['admin']
];

$data = [
    'routes' => $routes,
    'rules'  => $rules
];

return $data;