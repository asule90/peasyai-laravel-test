<?php
namespace App\Repositories;

use App\Dto\GenderCountDto;
use App\Models\DailyRecord;
use Illuminate\Database\Eloquent\Collection;

interface DataRepositoryInterface {
    public function fetchData(): array;
    public function setCache(GenderCountDto $genderCountDto);
    public function getCache(): GenderCountDto;
    public function increaseGenderCounterCache(GenderCountDto $data): void;
    public function insertHourly(array $data): void;
    public function clearCache(): void;
    public function getAverageAgeByGender(): Collection;
}