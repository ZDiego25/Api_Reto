<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/cursos','CursoController@index');
$router->get('/cursos/{id}','CursoController@view');
$router->post('/cursos','CursoController@store');
$router->delete('/cursos/{id}','CursoController@delete');
$router->post('/cursos/{id}','CursoController@update');