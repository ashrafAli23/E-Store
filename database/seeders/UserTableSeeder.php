<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'full_name' => 'test admin',
                'username' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'status' => 'active'
            ], [
                'full_name' => 'test vendor',
                'username' => 'vendor',
                'email' => 'vendor@vendor.com',
                'password' => Hash::make('123456'),
                'role' => 'vendor',
                'status' => 'active'
            ], [
                'full_name' => 'test customer',
                'username' => 'customer',
                'email' => 'customer@customer.com',
                'password' => Hash::make('123456'),
                'role' => 'customer',
                'status' => 'active'
            ],
        ]);
    }
}
