<?php
namespace App\Repositories;

use App\Dto\GenderCountDto;
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

    public function cacheHourly(GenderCountDto $genderCountDto) {
        
        Redis::set('male:count', $genderCountDto->male);
        Redis::set('female:count', $genderCountDto->female);
    }
}