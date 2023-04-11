<?php

namespace App\Services;

use Throwable;
use Firebase\JWT\{JWT, Key};
use App\Models\User;

class Auth
{
    /**
     * The JWT key
     */
    private $tokenKey = 'limFfvqq5uUV5I9YTKawIF';

    /**
     * The JWT token duration
     */
    private $tokenDuration = 7200;

    /**
     * Create an instance
     */
    public function createToken($user)
    {
        $payload = [
			'iss' => 'http://localhost:8000',
			'iat' => time(),
			'exp' => time() + $this->tokenDuration,
			'userId' => $user->id
		];

		return JWT::encode($payload, $this->tokenKey, 'HS256');
    }
    
    /**
     * Decode a bearer token
     */
    public function decodeToken($authorization = null)
    {
        if (!isset($authorization)) {
            return null;
        }

        $token = str_replace('Bearer ', '', $authorization);

        try {
            $payload = JWT::decode($token, new Key($this->tokenKey, 'HS256'));

            return User::find($payload->userId)?->toArray();
        } catch (Throwable $e) {
            return null;
        }
    }
}