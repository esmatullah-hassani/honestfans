<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(User::class,3)->create();
        factory(App\Post::class, 3)->create([
            'user_id'  => 1,
        ]);

        factory(App\Post::class, 3)->create([
            'user_id'  => 2,
        ]);

        factory(App\Post::class, 3)->create([
            'user_id'  => 3,
        ]);

       User::create([
            'name' => "admin",
            'email' => "admin@email.com",
            'password' => Hash::make("admin"),

        ]);

    }

}
