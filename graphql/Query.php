<?php

require __DIR__.'/../vendor/autoload.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Models\{User, Post};

$userType = require __DIR__.'/types/User.php';
$postType = require __DIR__.'/types/Post.php';

return new ObjectType([
    'name' => 'Query',
    'fields' => [
        'me' => [
            'type' => $userType,
            'resolve' => fn($root, $args, $context, $info) => $context['user']
        ],

        'posts' => [
            'type' => Type::nonNull(Type::listOf(Type::nonNull($postType))),
            'resolve' => fn($root, $args, $context, $info) => isset($context['user']) ? Post::where('user_id', $context['user']['id'])->get()->toArray() : []
        ],
        'post' => [
            'type' => $postType,
            'args' => [
                'id' => Type::nonNull(Type::id()),
            ],
            'resolve' => fn($root, $args, $context, $info) => isset($context['user']) ? Post::where('user_id', $context['user']['id'])->find($args['id'])->toArray() : null
        ],
    ]
]);
