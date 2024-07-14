<?php

namespace App\Jobs;

use App\Models\DailyRecord;
use App\Repositories\CacheRepoInterface;
use App\Repositories\PersistentRepoInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateDailyRecord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        CacheRepoInterface $cacheRepo,
        PersistentRepoInterface $persistentRepo
    ): void
    {
        $genderCount = $cacheRepo->get();        

        $avgAge = $persistentRepo->getAverageAgeByGender();

        $daily = new DailyRecord;
        $daily->male_count = $genderCount->male;
        $daily->female_count = $genderCount->female;
        $daily->male_avg_age = $avgAge->get(0)->avg;
        $daily->female_avg_age = $avgAge->get(1)->avg;
        $daily->save();

        $cacheRepo->clear();
    }
}
