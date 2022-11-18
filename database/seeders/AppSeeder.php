<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
        ]);
        $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $userModel = $user;
        $user->save();

        $role = Role::create([
            'name'=>'admin',
            'display_name'=>'Admin',
        ]);
        Role::create([
            'name'=>'user',
            'display_name'=>'User',
        ]);
        $userModel->attachRole($role);
        // Exam::create([
        //     'name' =>'Test Exam 1',
        //     'exam_start' =>Carbon::now()->format('Y-m-d'),
        //     'exam_end' =>Carbon::now()->addDays(1)->format('Y-m-d'),
        //     'duration' =>90,
        //     'created_by' =>$userModel->id,
        // ]);
    }
}
