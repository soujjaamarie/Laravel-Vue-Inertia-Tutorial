<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=[
            [
                'name'=>"Admin",
                'email'=>"admin@gamil.com",
                'password'=>bcrypt('password'),
            ]
            ];
    
    User::insert($user);
}







}
