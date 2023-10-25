<?php

namespace ReactBlog\Backend\services;

use Nowakowskir\JWT\JWT;
global $JWT_SECRET;
$JWT_SECRET = getenv('JWT_SECRET');

class JwtService
{

    public static function generateJwt($payload)
    {
        global $JWT_SECRET;
        $token = JWT::encode($payload, $JWT_SECRET, 'HS256');
        return $token;
    }

    public static function validateJwt($jwt) {
        global $JWT_SECRET;
        return JWT::decode($jwt, $JWT_SECRET, ['HS256']);
    }

}