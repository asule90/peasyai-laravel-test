<?php
namespace App\Repositories;

use App\Dto\GenderCountDto;
use Illuminate\Support\Facades\Redis;

class RedisRepo implements CacheRepoInterface {
    public function set(GenderCountDto $genderCountDto) {
        
        Redis::set('male:count', $genderCountDto->male);
        Redis::set('female:count', $genderCountDto->female);
    }
    
    public function get(): GenderCountDto {
        return new GenderCountDto(
            male: Redis::get('male:count') ?? 0,
            female: Redis::get('female:count') ?? 0,
        );
    }

    public function increaseGenderCounter(GenderCountDto $data): void {
        Redis::incr('male:count', $data->male);
        Redis::incr('female:count', $data->female);
    }

    public function clear(): void {
        Redis::flushdb();
    }
}