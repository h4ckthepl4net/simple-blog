<?php

use ReactBlog\Backend\constants\HTTPCodes;

function callControllerFunction ($controller, $function, $request, $response) {
    try {
        $controller = new $controller($request, $response);
        return $controller->$function($request, $response);
    } catch (\Respect\Validation\Exceptions\ValidationException $e) {
        $response->code(HTTPCodes::BAD_REQUEST)->json([
            'error' => true,
            'message' => $e->getMessage(),
        ])->send();
    } catch (\Nowakowskir\JWT\Exceptions\IntegrityViolationException $e) {
        $response->code(HTTPCodes::UNAUTHORIZED)->json([
            'error' => true,
            'message' => $e->getMessage(),
        ])->send();
    } catch (\ReactBlog\Backend\exceptions\NotFoundException $e) {
        $response->code(HTTPCodes::NOT_FOUND)->json([
            'error' => true,
            'message' => $e->getMessage(),
        ])->send();
    }
}