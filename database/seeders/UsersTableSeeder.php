<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'Firstname'=>'Admin',
            'Middlename'=>'SuperAdmin',
            'Lastname' => 'Admin',
            'Sex' =>'Male',
            'Role'=>0,
            'SectionID'=>0,
            'BatchID'=>0,
            'StudentID'=>0,
            'vrfy'=>1,
            'status'=>0,
            'dstatus'=>0,
            'email'=>'admin@admin.com',
            'password'=>Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
