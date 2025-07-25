<?php
namespace App\jwt;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;



class JWTToken
{
    public static function CreateToken($userEmail,$id){
        $key =env('JWT_SECRET');
        $payload = [
            'iss' => "laravel-token",
            'iat' => time(),
            'exp' => time() + 60*24*30,
            'userEmail' => $userEmail,
            'userId' => $id,
        ];  
        $jwt = JWT::encode($payload, $key ,'HS256');
        return $jwt;
    }

    public static function VerifyToken($token):array|string{
       try{
        $key =env('JWT_SECRET');
        $decode = JWT::decode($token, new key($key, 'HS256'));
        return [
            'userEmail' => $decode->userEmail,
            'userId' => $decode->userId,
        ];
       }
       catch(Exception $e){
            return 'Unauthorized';
    };
}
public static function CreateTokenForSetPassword($userEmail){
    $key =env('JWT_SECRET');
    $payload = [
        'iss' => "laravel-token",
        'iat' => time(),
        'exp' => time() + 60*24*30,
        'userEmail' => $userEmail,
        'userId' => '0',
    ];  
    $jwt = JWT::encode($payload, $key ,'HS256');
    return $jwt;
}
}