<?php

use Faker\Generator as Faker;

$factory->define(App\Empresa::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'rut' => $faker->swiftBicNumber,
        'direccion' => $faker->streetAddress,
        'telefono' => $faker->e164PhoneNumber,
        'razon_social' => $faker->jobTitle,
        'email' => $faker->unique()->safeEmail,
    ];
});
