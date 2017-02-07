<?php

//TODO: Routing
//Route::get('/test2/', array('use' => 'Main@tests', 'auth'=>false));

$routes = array(
    '/login/'  		 => array('use' => 'User@login', 'auth'=>true),
    '/logout/'  	 => array('use' => 'User@logout', 'auth'=>true),
    '/'		   		 => array('use' => 'Finance@displayIndex', 'auth'=>true),
    '/cash/save/'    => array('use' => 'Finance@doSaveCash', 'auth' => true),
    '/charts/'    => array('use' => 'Finance@onDisplayCharts', 'auth' => true),
    '/test/([0-9]+)/'    => array('use' => 'Finance@test', 'auth' => true)
);

return $routes;