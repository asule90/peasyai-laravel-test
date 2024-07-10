<?php
namespace App\Repositories;

use App\Dto\GenderCountDto;

interface DataRepositoryInterface {
    public function fetchData(): array;
    public function cacheHourly(GenderCountDto $genderCountDto);
}