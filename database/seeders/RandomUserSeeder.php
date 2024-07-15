<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RandomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/seeders/100-random-users.json");
        $randomUsers = json_decode($json);
        $today = now()->toDateString();

        foreach ($randomUsers as $key => $value) {
            $rowData = [
                "gender" => $value->gender,
                "name" => json_encode($value->name),
                "location" => json_encode($value->location),
                "age" => $value->dob->age,
                "uuid" => $value->login->uuid,
                "created_at" => $today,
                "updated_at" => $today,
            ];

            DB::table('random_user')->insert($rowData);
        }
    }
}
