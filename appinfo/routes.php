<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\StationeryApp\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
	   ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
	   ['name' => 'page#mail', 'url' => '/mail', 'verb' => 'GET'],
	   ['name' => 'action#index', 'url' => '/actions', 'verb' => 'GET'],
       ['name' => 'action#show', 'url' => '/action/{id}', 'verb' => 'GET'],
       ['name' => 'action#create', 'url' => '/insertAction', 'verb' => 'POST'],
       ['name' => 'action#destroy', 'url' => '/deleteAction/{id}', 'verb' => 'DELETE'],
       ['name' => 'material#index', 'url' => '/materials', 'verb' => 'GET'],
       ['name' => 'material#create', 'url' => '/insertMaterial', 'verb' => 'POST'],
       ['name' => 'material#update', 'url' => '/updateMaterial/{id}', 'verb' => 'PUT'],       
    ]
];
