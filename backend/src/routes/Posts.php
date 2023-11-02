<?php
require_once __DIR__ . '/../controllers/PostsController.php';
require_once __DIR__ . '/../helpers/callControllerFunction.php';
global $klein;

$klein->respond('GET', '/posts', function ($request, $response) {
    callControllerFunction(
        'ReactBlog\Backend\Controllers\PostsController',
        'getPosts',
        $request,
        $response,
    );
});

$klein->respond('POST', '/posts/new', function ($request, $response) {
    callControllerFunction(
        'ReactBlog\Backend\Controllers\PostsController',
        'createPost',
        $request,
        $response,
    );
});

$klein->respond('OPTIONS', '/posts/new', function ($request, $response) {
    $response->headers()->set('Access-Control-Allow-Methods', 'POST');
    $response->headers()->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    $response->headers()->set('Access-Control-Allow-Origin', '*');
    $response->code(200);
    $response->send();
});

$klein->respond('GET', '/posts/[i:postId]', function ($request, $response) {
    callControllerFunction(
        'ReactBlog\Backend\Controllers\PostsController',
        'getSpecificPost',
        $request,
        $response,
    );
});

$klein->respond('DELETE', '/posts/[i:postId]', function ($request, $response) {
    callControllerFunction(
        'ReactBlog\Backend\Controllers\PostsController',
        'deletePost',
        $request,
        $response,
    );
});

$klein->respond('OPTIONS', '/posts/[i:postId]', function ($request, $response) {
    $response->headers()->set('Access-Control-Allow-Methods', 'DELETE');
    $response->headers()->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    $response->headers()->set('Access-Control-Allow-Origin', '*');
    $response->code(200);
    $response->send();
});

//$klein->respond('PATCH', '/posts/[i:postId]', function ($request, $response) {
//    callControllerFunction(
//        'ReactBlog\Backend\Controllers\PostsController',
//        'editPost',
//        $request,
//        $response,
//    );
//});

