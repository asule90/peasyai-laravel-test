<?php

namespace Tests\Feature;

use App\Jobs\PopulateRandomUser;
use App\Models\DailyRecord;
use App\Models\RandomUser;
use App\Repositories\CacheRepoInterface;
use App\Repositories\PersistentRepoInterface;
use App\Repositories\PostgreRepo;
use App\Repositories\RandomUserRepo;
use App\Repositories\SourceRepoInterface;
use Database\Seeders\DailyRecordSeeder;
use Database\Seeders\RandomUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class RandomUserTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_fetch_random_user(): void
    {
        $jsonContent = File::get(base_path('tests/Feature/20-random-users.json'));
        $jsonData = json_decode(json: $jsonContent, associative: true);

        Http::fake([
            '*' => Http::response($jsonData)
        ]);

        $cacheMock = Mockery::mock(CacheRepoInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('increaseGenderCounter')->once();
        });
        $this->instance(
            CacheRepoInterface::class,
            $cacheMock
        );

        Queue::fake();

        $job = new PopulateRandomUser();
        $job->handle(
            new RandomUserRepo(),
            $cacheMock,
            new PostgreRepo()
        );

        Queue::assertNotPushed(PopulateRandomUser::class);

        $this->assertDatabaseCount('random_user', 20);
    }

    public function test_fetch_duplicate_uuid(): void
    {
        $jsonContent = File::get(base_path('tests/Feature/20-random-users.json'));
        $jsonData = json_decode(json: $jsonContent, associative: true);

        Http::fake([
            '*' => Http::response($jsonData)
        ]);

        $cacheMock = Mockery::mock(CacheRepoInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('increaseGenderCounter')->twice();
        });
        $this->instance(
            CacheRepoInterface::class,
            $cacheMock
        );

        Queue::fake();

        $job = new PopulateRandomUser();
        $job->handle(
            new RandomUserRepo(),
            $cacheMock,
            new PostgreRepo()
        );

        $this->assertDatabaseCount('random_user', 20);

        $job->handle(
            new RandomUserRepo(),
            $cacheMock,
            new PostgreRepo()
        );

        $this->assertDatabaseCount('random_user', 20);
    }

    public function test_delete_event(): void
    {
        //prepare
        $this->prepareData();
        $today = now()->toDateString();

        $postgreRepo = new PostgreRepo();
        $previousDailyRecord = $postgreRepo->getDailyByDate($today);

        $randomData = RandomUser::inRandomOrder()->first();
        $gender = $randomData->gender;
        $genderColumn = $gender.'_count';
        $avgAgeColumn = $gender.'_avg_age';

        $prevCount = $previousDailyRecord->$genderColumn;
        $prevAvgAge = $previousDailyRecord->$avgAgeColumn;


        //action
        $this->json(
            'DELETE', 
            'api/users/' . $randomData->uuid
        )/* ->dump() */
        ->assertStatus(200);

        $latestDailyRecord = $postgreRepo->getDailyByDate($today);
        $latestCount = $latestDailyRecord->$genderColumn;
        $latestAvgAge = $latestDailyRecord->$avgAgeColumn;

        /* dump([
            'prevCount' => $prevCount,
            'latestCount' => $latestCount,
            'prevAvgAge' => $prevAvgAge,
            'latestAvgAge' => $latestAvgAge,
        ]); */

        //test
        $this->assertTrue($latestCount == $prevCount-1);
        // $this->assertTrue($prevAvgAge != $latestAvgAge);

    }

    private function prepareData() {

        $this->seed([
            RandomUserSeeder::class,
            DailyRecordSeeder::class
        ]);
    }
}
