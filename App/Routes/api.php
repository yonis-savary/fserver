<?php

use App\Controllers\DownloadController;
use Cube\Web\Router\Route;
use Cube\Web\Router\Router;

Router::getInstance()->addRoutes(
    Route::get("/api/{uuid}", [DownloadController::class, 'showDirectory']),
    Route::get("/api/{uuid}/download", [DownloadController::class, 'download']),
);