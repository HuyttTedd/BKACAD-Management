<?php

use App\User;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'fullname' => 'Tuong Huy',
            'dob' => '1999-07-22',
            'gender' => '1',
            'phone' => '0979547542',
            'avatar' => 'assets/images/avatar_default.png',
            'email' => 'huykuy99@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create(['name' => 'admin', 'description' => 'Quản Trị Viên']);

        User::get()->first()->assignRole('admin');

    }
}
