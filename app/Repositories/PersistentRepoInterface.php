<?php
namespace App\Repositories;

use App\Models\DailyRecord;
use App\Models\RandomUser;
use Illuminate\Database\Eloquent\Collection;

interface PersistentRepoInterface {
    public function upsertManyUsers(array $data): void;
    public function getAvgGenderAgeByDate(string $date): Collection;
    public function getGenderCountByDate(string $date): Collection;
    public function getDailyByDate(string $date): ?DailyRecord;
    public function deleteUser(RandomUser $entity): void;
    public function selectAllUser(): Collection;
    public function saveDaily(DailyRecord $entity): void;
    public function saveDailyQuietly(DailyRecord $entity): void;
    public function selectAlldaily(): Collection;
}