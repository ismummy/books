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

$router->get('/', 'BookController@index');

$router->get('/preload', 'BookController@preloadBooks');

$router->get('/books', 'BookController@getBooks');

$router->get('/books/{bookId}', 'BookController@getBook');

$router->get('/books/{bookId}/characters', 'BookController@getCharacters');

$router->get('/books/{bookId}/comments', 'BookController@getComments');

$router->post('/books/{bookId}/comments', 'BookController@addComment');
