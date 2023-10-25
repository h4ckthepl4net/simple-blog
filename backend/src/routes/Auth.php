<?php

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../helpers/callControllerFunction.php';
global $klein;

$klein->respond('POST', '/auth/login', function ($request, $response) {
    callControllerFunction(
        'ReactBlog\Backend\Controllers\AuthController',
        'login',
        $request,
        $response,
    );
});

$klein->respond('POST', '/auth/register', function ($request, $response) {
    callControllerFunction(
        'ReactBlog\Backend\Controllers\AuthController',
        'register',
        $request,
        $response,
    );
});
