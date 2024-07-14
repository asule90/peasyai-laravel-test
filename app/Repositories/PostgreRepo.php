<?php
namespace App\Repositories;

use App\Models\RandomUser;
use Illuminate\Database\Eloquent\Collection;

class PostgreRepo implements PersistentRepoInterface {

    public function insertHourly(array $data): void {
        RandomUser::upsert($data, ['uuid'], [
            'name',
            'location',
            'gender',
            'age',
        ]);
    }

    public function getAverageAgeByGender(): Collection {
        return RandomUser::select('gender')
        ->selectRaw('AVG(age)')
        ->groupBy('gender')
        ->orderByRaw("array_position(
            ARRAY['male', 'female'],
            gender
        )")->get();
    }

    public function deleteUser(string $id): void {
        $user = RandomUser::findOrFail($id);
        $user->delete();
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
}