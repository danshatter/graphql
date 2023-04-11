<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\User;

$capsule = require __DIR__.'/capsule.php';

Capsule::schema()->create('users', function($table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email');
    $table->string('phone');
    $table->string('password')->nullable();
    $table->timestamps();
});

Capsule::schema()->create('posts', function($table) {
    $table->id();
    $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
    $table->string('title');
    $table->string('body');
    $table->timestamps();
});

echo 'Migrations run successfully.';