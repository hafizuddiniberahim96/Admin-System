<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User_roles as Roles;
use App\Models\User;
use Hash;
use App\Models\User_details as Details;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        $roles = new Roles();
        $roles->name = 'student';
        $roles->save();

        $roles = new Roles();
        $roles->name = 'teacher';
        $roles->save();

        $roles = new Roles();
        $roles->name = 'instructor';
        $roles->save();

        $roles = new Roles();
        $roles->name = 'entrepreneur';
        $roles->save();

        $roles = new Roles();
        $roles->name = 'secretariat';
        $roles->save();

        // \App\Models\User::factory(10)->create();
        $roles = new Roles();
        $roles->name = 'admin';
        $roles->save();

        $user = new User();
        $user->nric = "900707040303";
        $user->password = Hash::make("password1234");
        $user->roles_id = $roles->_id;
        $user->email = "admin@pkink.gov.my";
        $user->lockout_time = 1;
        $user->registerComplete = 1;
        $user->isActive = 1;
        $user->isApproved = 1;
        $user->save();

        $details = new Details();
        $details->user_id = $user->_id;
        $details->fullName = "Admin BUIPA";
        $details->phoneNumber = NULL;
        $details->profileImg = NULL;
        $details->save();


    }
}
