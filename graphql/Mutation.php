<?php

require __DIR__.'/../vendor/autoload.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Models\{User, Post};
use App\Services\Auth as AuthService;

$userType = require __DIR__.'/types/User.php';

return new ObjectType([
    'name' => 'Mutation',
    'fields' => [
        'loginUser' => [
            'type' => new ObjectType([
                'name' => 'LoginUser',
                'fields' => [
                    'token' => Type::nonNull(Type::string()),
                ]
            ]),
            'args' => [
                'username' => Type::nonNull(Type::string()),
                'password' => Type::nonNull(Type::string())
            ],
            'resolve' => function($root, $args, $context, $info) {
                $user = User::where('email', $args['username'])
                            ->orWhere('phone', $args['username'])
                            ->first();

                if (!isset($user)) {
                    http_response_code(401);

                    throw new Exception('Unauthenticated.');
                }

                // Check the password to know if the inputted password is correct
                if (!password_verify($args['password'], $user->password)) {
                    http_response_code(401);

                    throw new Exception('Unauthenticated.');
                }

                // Create the token
                $token = (new AuthService)->createToken($user);

                return [
                    'token' => $token
                ];
            }
        ],
    ]
]);
