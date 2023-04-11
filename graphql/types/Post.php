<?php

require __DIR__.'/../../vendor/autoload.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

return new ObjectType([
    'name' => 'Post',
    'fields' => [
        'id' => Type::nonNull(Type::id()),
        'user_id' => Type::nonNull(Type::int()),
        'title' => Type::nonNull(Type::string()),
        'body' => Type::nonNull(Type::string()),
        'created_at' => Type::nonNull(Type::string()),
        'updated_at' => Type::nonNull(Type::string()),
    ]
]);
