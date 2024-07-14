<?php
namespace App\Repositories;

use App\Models\DailyRecord;
use App\Models\RandomUser;
use Illuminate\Database\Eloquent\Collection;

interface PersistentRepoInterface {
    public function upsertMany(array $data): void;
    public function getAverageAgeByGender(): Collection;
    public function getDailyByDate(string $date): ?DailyRecord;
    public function deleteUser(RandomUser $entity): void;
    public function selectAllUser(): Collection;
    public function saveDaily(DailyRecord $entity): void;
}