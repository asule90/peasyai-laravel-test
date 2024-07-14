<?php
namespace App\Repositories;

use App\Dto\GenderCountDto;

interface CacheRepoInterface {
    public function set(GenderCountDto $genderCountDto);
    public function get(): GenderCountDto;
    public function increaseGenderCounter(GenderCountDto $data): void;
    public function clear(): void;
}