<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role' => '1',
            'name'=> 'Admin',
            'email'=>'admin@blog.com',
            'password'=>bcrypt('admin')
        ]);
    }
}
