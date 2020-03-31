<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory('App\Models\User')->create()->id;
        },
        'thread_id' => function(){
            return factory('App\Models\Thread')->create()->id;
        },
        'body' => $faker->paragraph,
    ];
});
