<?php
require __DIR__ .'/../app/core/helpers.php';
require base_path('vendor/autoload.php');

date_default_timezone_set(config('timezone'));

use app\core\Auth;
use app\core\Router;

$router = new Router();

$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'loginProcess']);
$router->get('/about', [PageController::class, 'about']);

if (Auth::authCheck() === true) {

    $router->get('/', [PersonController::class, 'index']);
    $router->get('/logout', [AuthController::class, 'logout']);

    $router->get('/import', [ImportController::class, 'index']);
    $router->post('/import/download', [ImportController::class, 'download']);
    $router->get('/import/deletefile', [ImportController::class, 'deletefile']);
    $router->get('/import/parse', [ImportController::class, 'parse']);
    $router->get('/import/dbempty', [ImportController::class, 'dbempty']);
    
    $router->get('/companies', [CompanyController::class, 'index']);

    $router->get('/ajax/stars', [AjaxController::class, 'stars']);
    $router->get('/ajax/city-search', [AjaxController::class, 'citySearch']);

} elseif (!in_array($router->getUri(), array_keys($router->routes[$router->getHttpMethod()]))) {

    Router::redirect('/login');

}

echo $router->run();