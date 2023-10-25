<?php

function callControllerFunction ($controller, $function, $request, $response) {
    try {
        $controller = new $controller($request, $response);
        return $controller->$function($request, $response);
    } catch (\Respect\Validation\Exceptions\ValidationException $e) {
        $response->json([
            'error' => true,
            'message' => $e->getMessage(),
        ])->code(400)->send();
    } catch (\Nowakowskir\JWT\Exceptions\IntegrityViolationException $e) {
        $response->json([
            'error' => true,
            'message' => $e->getMessage(),
        ])->code(401)->send();
    }
}