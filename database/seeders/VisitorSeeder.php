<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class VisitorSeeder extends Seeder
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
                "uuid" => Uuid::uuid4()->toString(),
                "username" => "newbie",
                "email" => "newbie@gmail.com",
                "password" => bcrypt("newbie"),
                "phone" => "081234567890",
                "created_at" => now(),
                "updated_at" => now()
            ]
        ])->each(fn($visitor) => DB::table('visitors')->insert($visitor));
    }
}
