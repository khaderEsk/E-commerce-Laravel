<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new  User();
        $user->name = "Admin";
        $user->email = "admin@gmail.com";
        $user->password = Hash::make('12341234');
        $user->save();
        $user->assignRole('admin');
    }
}
