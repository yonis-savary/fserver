<?php

use Cube\Core\Autoloader\Applications;
use Cube\Data\Database\DatabaseConfiguration;

use function Cube\env;

return [
    // The list of your applications to load
    new Applications('App'),

    // Configure your sql connection here
    new DatabaseConfiguration(
        'mysql', 
        env('DATABASE_NAME', 'root'),
        env('DATABASE_HOST', 'mysql'),
        env('DATABASE_PORT', 3306),
        env('DATABASE_USER', 'root'),
        env('DATABASE_PASSWORD', 'root'),
    ),

    // To improve performances, you can enable autoloading caching
    // new AutoloaderConfiguration(false),

    // You can serve your frontend application with a static file server
    // new RouterConfiguration(
    //     apis: [
    //         new StaticServer('FrontEnd/Public')
    //     ]
    // )
];
