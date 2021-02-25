<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

# API v1 created at February, 2021
$router->group(['prefix' => 'v1','middleware' => 'apiToken'], function($router) {
    $router->get('inbox', 'InboxController@index');
    $router->get('inbox/{id}', 'InboxController@show');
    $router->post('inbox', 'InboxController@store');
    $router->delete('inbox/{id}', 'InboxController@destroy');
});


