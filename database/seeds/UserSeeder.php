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
            'fullname' => 'Lê Văn Long',
            'dob' => '2000-07-22',
            'gender' => '1',
            'phone' => '0979547542',
            'avatar' => 'assets/images/avatar_default.png',
            'email' => 'levanlong220700@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create(['name' => 'admin', 'description' => 'Quản Trị Viên']);

        $user->assignRole('admin');

    }
}
