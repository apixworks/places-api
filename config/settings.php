<?php

// Error reporting for production
error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('Africa/Nairobi');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['public'] = $settings['root'] . '/public';
$settings['template'] = $settings['root'] . '/templates';

// Auth settings
$settings['api_auth'] = [
    'path' => '/places-api',
    'secure' => 'true',
    'relaxed' => ["asyx-places-api.herokuapp.com, remotemysql.com"],
    'users' => [
       'admin' => '$2y$10$IwXJYzXsyRdtgCbEBeEgteJYNx5lIGj2T.5PqFyN60y7WmaHR1/Ui'
   ],
   'error' => function ($response, $arguments) {
        $data = [];
        $data['status'] = 'error';
        $data['message'] = $arguments['message'];

        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
    }
];

// Error Handling Middleware settings
$settings['error'] = [

    // Should be set to false in production
    'display_error_details' => true,

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,

];

return $settings;