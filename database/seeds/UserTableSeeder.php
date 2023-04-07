<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_customer = Role::where('name', 'customer')->first();
        $role_administrator  = Role::where('name', 'administrator')->first();

        $administrator = new User();
        $administrator->name = 'Administrator Name';
        $administrator->email = 'a@trip.com';
        $administrator->password = bcrypt('secret');
        $administrator->email_verified_at = date('Y-m-d H:i:s');
        $administrator->save();
        // $administrator->roles()->attach($role_administrator);

        $customer = new User();
        $customer->name = 'Customer Name';
        $customer->email = 'c@trip.com';
        $customer->password = bcrypt('secret');
        $customer->email_verified_at = date('Y-m-d H:i:s');
        $customer->save();
        // $customer->roles()->attach($role_customer);

    }
}
