<?php

namespace ReactBlog\Backend\Controllers;
use ReactBlog\Backend\services\JwtService;
use Respect\Validation\Validator as v;
use ReactBlog\Backend\constants\HTTPCodes;

class AuthController extends BaseController {
    public function login($request, $response) {
        $constraints = [
            'username' => v::stringVal()->length(1, 100)->notEmpty()->notOptional()->setName('username'),
            'password' => v::stringVal()->length(1, 100)->notEmpty()->notOptional()->setName('password'),
        ];
        $this->validatePostBody($constraints);
        $body = $request->paramsPost();
        $username = $body->get('username');
        $password = $body->get('password');
        $model = new \ReactBlog\Backend\Models\UserModel();
        $user = $model->checkPassword($username, $password);
        $token = JwtService::generateJwt($user);
        $response->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function register($request, $response) {
        $constraints = [
            'username' => v::stringVal()->length(6, 100)->alnum()->notEmpty()->notOptional()->setName('username'),
            'password' => v::allof(
                v::stringVal()->length(8, 100),
                v::regex('/[a-z]/'),
                v::regex('/[A-Z]/'),
                v::regex('/[0-9]/'),
                v::regex('/[!@#$%^&*()\-_=+{};:,<.>]/'),
            )->notEmpty()->notOptional()->setName('password'),
        ];
        $this->validatePostBody($constraints);
        $body = $request->paramsPost();
        $username = $body->get('username');
        $password = $body->get('password');
        $model = new \ReactBlog\Backend\Models\UserModel();
        $user = $model->checkUserExists($username);
        if ($user) {
            $response->code(HTTPCodes::CONFLICT);
            $response->json([
                'error' => true,
                'message' => 'User already exists',
            ]);
        } else {
            $model->createUser($username, $password);
            $response->code(HTTPCodes::CREATED);
            $response->json([
                'error' => false,
                'message' => 'User created',
            ]);
        }
    }
}