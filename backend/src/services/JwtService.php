<?php

namespace ReactBlog\Backend\services;

use Nowakowskir\JWT\Exceptions\AlgorithmMismatchException;
use Nowakowskir\JWT\Exceptions\IntegrityViolationException;
use Nowakowskir\JWT\Exceptions\UnsupportedAlgorithmException;
use Nowakowskir\JWT\JWT;
global $JWT_SECRET;
$JWT_SECRET = getenv('JWT_SECRET');

class JwtService
{

    /**
     * @throws AlgorithmMismatchException
     */
    public static function generateJwt($payload)
    {
        global $JWT_SECRET;
        return JWT::encode($payload, $JWT_SECRET, 'HS256');
    }

    /**
     * @throws UnsupportedAlgorithmException
     * @throws IntegrityViolationException
     */
    public static function validateJwt($jwt) {
        global $JWT_SECRET;
        return JWT::validate($jwt, $JWT_SECRET, 'HS256');
    }

    public static function decodeJwt($jwt) {
        return JWT::decode($jwt);
    }

}