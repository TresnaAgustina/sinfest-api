<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'uuid' => Uuid::uuid4()->toString(),
                'username' => 'developer_club',
                'email' => 'idc@instiki.ac.id',
                'password' => bcrypt('developer!!'),
                'roles' => 'engineer',
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'username' => 'sinbun_club',
                'email' => 'sinbun@instiki.ac.id',
                'password' => bcrypt('sinbun!!'),
                'roles' => 'wibu',
            ],
        ])->each(function ($admin) {
            DB::table('admins')->insert($admin);
        });
    }
}
