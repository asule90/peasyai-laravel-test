<?php
namespace App\Repositories;

use App\Dto\UserQueryDto;
use App\Models\DailyRecord;
use App\Models\RandomUser;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

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

    public function getGenderCountByDate(string $date): Collection {
        return RandomUser::select('gender')
        ->selectRaw('count(*) as count')
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

    private function selectQuery(UserQueryDto $filterQuery) {
        $query = RandomUser::select(
            'uuid',
            'age',
            'gender',
            'created_at'
        )
        ->selectRaw("CONCAT(name ->> 'title', ' ', name ->> 'first', ' ', name ->> 'last') AS full_name")
        ->selectRaw("CONCAT(
            location -> 'street' ->> 'name',
            ' ', location -> 'street' ->> 'number',
            ' ', location ->> 'city', 
            ' ', location ->> 'state',
            ' ', location ->> 'country') 
            AS full_location"
        );
    
        if ($filterQuery->search) {
            $query->where('name->title', 'ILIKE', '%'.$filterQuery->search.'%')
                ->orWhere('name->first', 'ILIKE', '%'.$filterQuery->search.'%')
                ->orWhere('name->last', 'ILIKE', '%'.$filterQuery->search.'%')
                ->orWhere('location->street->name', 'ILIKE', '%'.$filterQuery->search.'%')
                ->orWhere('location->street->number', 'ILIKE', '%'.$filterQuery->search.'%')
                ->orWhere('location->city', 'ILIKE', '%'.$filterQuery->search.'%')
                ->orWhere('location->state', 'ILIKE', '%'.$filterQuery->search.'%')
                ->orWhere('location->country', 'ILIKE', '%'.$filterQuery->search.'%');
        }

        return $query;
    }

    public function selectAllUser(UserQueryDto $filterQuery): Collection {
        return $this->selectQuery($filterQuery)
            ->get();
    }

    public function selectPaginatedUser(UserQueryDto $filterQuery): LengthAwarePaginator {

        return $this->selectQuery($filterQuery)
            ->paginate($filterQuery->per_page);
    }

    public function selectAlldaily(): Collection {
        return DailyRecord::select(
                'date',
                'male_count',
                'female_count',
                'male_avg_age',
                'female_avg_age',
            )
            ->get();
    }

    public function saveDaily(DailyRecord $entity): void {
        $entity->save();
    }
    public function saveDailyQuietly(DailyRecord $entity): void {
        $entity->saveQuietly();
    }
}