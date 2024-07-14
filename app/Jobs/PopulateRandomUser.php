<?php

namespace App\Jobs;

use App\Dto\GenderCountDto;
use App\Repositories\CacheRepoInterface;
use App\Repositories\PersistentRepoInterface;
use App\Repositories\SourceRepoInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PopulateRandomUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(
        SourceRepoInterface $sourceRepo,
        CacheRepoInterface $cacheRepo,
        PersistentRepoInterface $persistentRepo,
        ): void
    {
        $rawData = $sourceRepo->fetch();

        $genderCounter = new GenderCountDto();
        
        $preparedData = $this->prepareData($rawData, $genderCounter);

        $persistentRepo->upsertMany($preparedData);

        $cacheRepo->increaseGenderCounter($genderCounter);
    }

    private function prepareData($rawData, &$genderCounter): array {
        return array_map(function ($object) use (&$genderCounter) {
            $record = [
                'name' => json_encode($object['name']), 
                'location' => json_encode($object['location']),
                'gender'  => $object['gender'], 
                'age' => $object['dob']['age'],
                'uuid' => $object['login']['uuid']
            ];

            $gender = $record['gender'];
            if (property_exists($genderCounter, $gender))
                $genderCounter->$gender++;

            return $record;
        }, $rawData);
    }
}
