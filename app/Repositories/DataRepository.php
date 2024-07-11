<?php
namespace App\Repositories;

use App\Dto\GenderCountDto;
use App\Models\DailyRecord;
use App\Models\RandomUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class DataRepository implements DataRepositoryInterface {

    public function fetchData(): array {
        $response = Http::get(config('app.api_random_user'));
        if ($response->ok()) {
            return $response->json('results');
        }

        Log::warn('api communication attempt was failed');
        throw $response->toException();
    }

    public function setCache(GenderCountDto $genderCountDto) {
        
        Redis::set('male:count', $genderCountDto->male);
        Redis::set('female:count', $genderCountDto->female);
    }
    
    public function getCache(): GenderCountDto {
        return new GenderCountDto(
            male: Redis::get('male:count') ?? 0,
            female: Redis::get('female:count') ?? 0,
        );
    }

    public function increaseGenderCounterCache(GenderCountDto $data): void {
        Redis::incr('male:count', $data->male);
        Redis::incr('female:count', $data->female);
    }

    public function insertHourly(array $data): void {
        RandomUser::upsert($data, ['uuid'], [
            'name',
            'location',
            'gender',
            'age',
        ]);
    }

    public function clearCache(): void {
        Redis::flushdb();
    }

    public function getAverageAgeByGender(): Collection {
        return RandomUser::select('gender')
        ->selectRaw('AVG(age)')
        ->groupBy('gender')
        ->orderByRaw("array_position(
            ARRAY['male', 'female'],
            gender
        )")->get();
    }
}