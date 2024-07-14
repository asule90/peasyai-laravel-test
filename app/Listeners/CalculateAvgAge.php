<?php

namespace App\Listeners;

use App\Events\DailyRecordCountChanged;
use App\Repositories\PersistentRepoInterface;
use Illuminate\Support\Facades\Log;

class CalculateAvgAge /* implements ShouldQueue */
{
    // eloquent->wasChanged is not working with queue
    public $connection = 'sync';
    /**
     * Create the event listener.
     */
    public function __construct(public PersistentRepoInterface $persistentRepo)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(DailyRecordCountChanged $event): void
    {   
        if ($event->dailyRecord->wasChanged(['male_count', 'female_count'])) {

            $avgAge = $this->persistentRepo->getAverageAgeByGender();

            $event->dailyRecord->male_avg_age =  $avgAge->get(0)->avg;
            $event->dailyRecord->female_avg_age = $avgAge->get(1)->avg;
            $event->dailyRecord->saveQuietly();

            Log::info('CalculateAvgAge listener works');
        }
    }
}
