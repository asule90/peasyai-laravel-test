<?php
namespace App\Repositories;

use App\Models\DailyRecord;
use App\Models\RandomUser;
use Illuminate\Database\Eloquent\Collection;

class PostgreRepo implements PersistentRepoInterface {

    public function upsertManyUsers(array $data): void {
        RandomUser::upsert($data, ['uuid'], [
            'name',
            'location',
            'gender',
            'age',
        ]);
    }

    public function getAvgGenderAgeByDate(string $date): Collection {
        return RandomUser::select('gender')
        ->selectRaw('AVG(age)')
        ->whereRaw("TO_CHAR(created_at, 'YYYY-MM-DD') LIKE '$date'")
        ->groupBy('gender')
        ->orderByRaw("array_position(
            ARRAY['male', 'female'],
            gender
        )")->get();
    }

    public function getDailyByDate(string $date): ?DailyRecord {
        return DailyRecord::select(
            'date',
            'male_count',
            'female_count',
            'male_avg_age',
            'female_avg_age',
        )->where('date', $date)
        ->limit(1)
        ->first();
    }

    public function deleteUser(RandomUser $entity): void {
        $entity->delete();
    }

    public function selectAllUser(): Collection {
        return RandomUser::select(
                'uuid',
                'age',
                'gender',
                'created_at',
            )
            ->selectRaw("CONCAT(name ->> 'title', ' ', name ->> 'first', ' ', name ->> 'last') AS full_name")
            ->selectRaw("CONCAT(
                location -> 'street' ->> 'name',
                ' ', location -> 'street' ->> 'number',
                ' ', location ->> 'city', 
                ' ', location ->> 'state'
                ' ', location ->> 'country') 
                AS full_location"
            )
            ->get();
    }

    public function saveDaily(DailyRecord $entity): void {
        $entity->save();
    }
}