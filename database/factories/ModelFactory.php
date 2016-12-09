<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Quotation::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->text,
    ];
});

$factory->define(App\Player::class, function (Faker\Generator $faker) {
    return [
        'app_uid' => $faker->unique()->randomNumber,
        'nid'     => $faker->optional()->regexify('[DEPMV]{1}[0-9]{7}'),
    ];
});

$factory->define(App\Question::class, function (Faker\Generator $faker) {
    return [
        'content'         => $faker->sentence,
        'correct_message' => $faker->optional()->sentence,
        'wrong_message'   => $faker->optional()->sentence,
    ];
});
$factory->define(App\Choice::class, function (Faker\Generator $faker) {
    return [
        'content'    => $faker->sentence,
        'is_correct' => $faker->boolean,
    ];
});
