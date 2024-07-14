<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface PersistentRepoInterface {
    public function insertHourly(array $data): void;
    public function getAverageAgeByGender(): Collection;
    public function deleteUser(string $id): void;
    public function selectAllUser(): Collection;
}