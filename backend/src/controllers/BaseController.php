<?php

namespace ReactBlog\Backend\Controllers;

use Klein\Request;
use Klein\Response;
use Nowakowskir\JWT\Exceptions\IntegrityViolationException;
use ReactBlog\Backend\helpers\Validator;
use ReactBlog\Backend\services\JwtService;

class BaseController
{
    public Request $request;
    public Response $response;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function validate($constraints, $data): bool {
        $validator = new Validator($constraints, $data);
        return $validator->validate();
    }

    public function validateQuery($constraints) {
        $params = $this->request->paramsGet()->all();
        $this->validate($constraints, $params);
    }

    public function validateNamedParams($constraints) {
        $params = $this->request->paramsNamed()->all();
        $this->validate($constraints, $params);
    }

    /**
     * @throws IntegrityViolationException
     */
    public function authenticate($throw = true) {
        try {
            $authHeader = $this->request->headers()->get('Authorization');
            if (!$authHeader) {
                throw new IntegrityViolationException('Authorization header is missing');
            }
            $valid = JwtService::validateJwt($authHeader);
            if (!$valid) {
                throw new IntegrityViolationException('Invalid token');
            }
            $decoded = JwtService::decodeJwt($authHeader);
            return $decoded;
        } catch (IntegrityViolationException $e) {
            if ($throw) {
                throw $e;
            }
            return null;
        }
    }
}