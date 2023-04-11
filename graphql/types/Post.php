<?php

require __DIR__.'/../../vendor/autoload.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$userType = require __DIR__.'/User.php';

return new ObjectType([
    'name' => 'Post',
    'fields' => [
        'id' => Type::nonNull(Type::id()),
        'title' => Type::nonNull(Type::string()),
        'body' => Type::nonNull(Type::string()),
        'created_at' => Type::nonNull(Type::string()),
        'updated_at' => Type::nonNull(Type::string()),
    ]
]);
