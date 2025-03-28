<?php
namespace App\jwt;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;



class JWTToken
{
    function CreateToken($userEmail){
        $key =env('JWT_SECRET');
        $payload = [
            'iss' => "laravel-token",
            'iat' => time(),
            'exp' => time() + 60*60,
            'userEmail' => $userEmail
        ];
        $jwt = JWT::encode($payload, $key ,'HS256');
        return $jwt;
    }

    function VerifyToken($token):string{
       try{
        $key =env('JWT_SECRET');
        $decode = JWT::decode($token, new key($key, 'HS256'));
        return $decode->userEmail;
       }
       catch(Exception $e){
            return 'Unauthorized';
    };
}
}