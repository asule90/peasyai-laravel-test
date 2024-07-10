<?php

namespace App\Jobs;

use App\Dto\GenderCountDto;
use App\Models\RandomUser;
use App\Repositories\DataRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchRandomUser implements ShouldQueue
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
    public function handle(DataRepositoryInterface $repo): void
    {
        $results = $repo->fetchData();

        $genderCount = new GenderCountDto();
        
        $filteredData = array_map(function ($object) use (&$genderCount) {
            $record = [
                'name' => json_encode($object['name']), 
                'location' => json_encode($object['location']),
                'gender'  => $object['gender'], 
                'age' => $object['dob']['age'],
                'uuid' => $object['login']['uuid']
            ];

            $gender = $record['gender'];
            if (property_exists($genderCount, $gender))
                $genderCount->$gender++;

            return $record;
        }, $results);

        RandomUser::upsert($filteredData, ['uuid'], [
            'name',
            'location',
            'gender',
            'age',
        ]);

        $repo->cacheHourly($genderCount);
    }
}
