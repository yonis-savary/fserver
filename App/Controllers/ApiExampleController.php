<?php

namespace App\Controllers;

use Cube\Web\Controller;
use Cube\Web\Http\Response;
use Cube\Web\Router\Route;
use Cube\Web\Router\Router;

class ApiExampleController extends Controller
{
    public function routes(Router $router): void
    {
        $router->group("/api", routes: [
            Route::get("/", [self::class, "sayHello"])
        ]);
    }

    public static function sayHello() {
        return Response::json("Hello!");
    }
}