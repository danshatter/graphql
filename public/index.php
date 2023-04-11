<?php

require __DIR__.'/../vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\DebugFlag;
use App\Services\Auth as AuthService;

$capsule = require __DIR__.'/../database/capsule.php';

// Get all headers
$headers = getallheaders();

// Get the authenticated user
$user = (new AuthService)->decodeToken($headers['Authorization'] ?? null);

// Get the query
$query = require __DIR__.'/../graphql/Query.php';
$mutation = require __DIR__.'/../graphql/Mutation.php';

$schema = new Schema([
    'query' => $query,
    'mutation' => $mutation
]);

// Get the raw input
$rawInput = file_get_contents('php://input');

// Decode the raw input
$input = json_decode($rawInput, true);

// Get the query
$query = $input['query'];

// Get the variables
$variableValues = isset($input['variables']) ? $input['variables'] : null;

try {
    $rootValue = ['prefix' => 'You said: '];

    $result = GraphQL::executeQuery(
        $schema,
        $query,
        $rootValue,
        [
            'user' => $user
        ],
        $variableValues
    );
    
    $output = $result->toArray(DebugFlag::RETHROW_INTERNAL_EXCEPTIONS);

    $status = 200;
} catch (Throwable $e) {
    $output = [
        'errors' => [
            [
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]
        ]
    ];

    $status = http_response_code();

    if ($status >= 200 && $status <= 299) {
        $status = 500;
    }
}

header('Content-Type: application/json', true, $status);

echo json_encode($output, JSON_THROW_ON_ERROR);


