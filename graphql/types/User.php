<?php

require __DIR__.'/../../vendor/autoload.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

return new ObjectType([
    'name' => 'User',
    'fields' => [
        'id' => Type::nonNull(Type::id()),
        'first_name' => Type::nonNull(Type::string()),
        'last_name' => Type::nonNull(Type::string()),
        'email' => Type::nonNull(Type::string()),
        'phone' => Type::nonNull(Type::string()),
        'created_at' => Type::nonNull(Type::string()),
        'updated_at' => Type::nonNull(Type::string())
    ]
]);
