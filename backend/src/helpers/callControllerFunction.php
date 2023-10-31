<?php

use ReactBlog\Backend\constants\HTTPCodes;

function callControllerFunction ($controller, $function, $request, $response) {
    try {
        $controller = new $controller($request, $response);
        return $controller->$function($request, $response);
    } catch (\Respect\Validation\Exceptions\ValidationException $e) {
        $response->json([
            'error' => true,
            'message' => $e->getMessage(),
        ])->code(HTTPCodes::BAD_REQUEST)->send();
    } catch (\Nowakowskir\JWT\Exceptions\IntegrityViolationException $e) {
        $response->json([
            'error' => true,
            'message' => $e->getMessage(),
        ])->code(HTTPCodes::UNAUTHORIZED)->send();
    } catch (\ReactBlog\Backend\exceptions\NotFoundException $e) {
        $response->json([
            'error' => true,
            'message' => $e->getMessage(),
        ])->code(HTTPCodes::NOT_FOUND)->send();
    }
}