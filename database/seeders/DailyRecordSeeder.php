<?php

namespace Database\Seeders;

use App\Repositories\PostgreRepo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DailyRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = now()->toDateString();
        $postgreRepo = new PostgreRepo();
        $avgAge = $postgreRepo->getAvgGenderAgeByDate($today);
        $genderCount = $postgreRepo->getGenderCountByDate($today);

        $rowData = [
            "date" => $today,
            "male_count" => $genderCount->get(0)->count,
            "female_count" => $genderCount->get(1)->count,
            "male_avg_age" => $avgAge->get(0)->avg,
            "female_avg_age" => $avgAge->get(1)->avg,
        ];

        DB::table('daily_record')->insert($rowData);
    }
}
