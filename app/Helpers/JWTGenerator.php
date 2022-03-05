<?php

namespace App\Helpers;

use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;
use Nowakowskir\JWT\TokenEncoded;


class JWTGenerator
{

    public static function getToken($payload)
    {
        $refresh_key = random_bytes(20);
        $privateKey = file_get_contents(base_path() . '/private.key');
        $tokenDecoded = new TokenDecoded(['payload_key' => $payload, 'exp' => time() + 3600 * 24 * 365], ['refresh_token' => bin2hex($refresh_key)]);
        $tokenEncoded = $tokenDecoded->encode($privateKey, JWT::ALGORITHM_RS256);
        return $tokenEncoded->toString();
    }

    public static function showPayload($token)
    {
        $tokenEncoded = new TokenEncoded($token);
        return $tokenEncoded->decode()->getPayload()['payload_key'];
    }

    public static function validateToken($token)
    {
        $tokenEncoded = new TokenEncoded($token);
        $publicKey = file_get_contents(base_path() . '/public.pub');

        try {
            return $tokenEncoded->validate($publicKey, JWT::ALGORITHM_RS256);
        } catch (\Throwable $th) {
            return false;
        }
    }
}
