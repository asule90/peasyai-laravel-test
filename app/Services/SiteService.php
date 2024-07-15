<?php
namespace App\Services;

use App\Models\DailyRecord;
use App\Models\RandomUser;
use App\Repositories\PersistentRepoInterface;
use App\Services\SiteServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteService implements SiteServiceInterface {
    public function __construct(
        public PersistentRepoInterface $persistentRepo
    ){}

    public function getList(): Collection {
        return $this->persistentRepo->selectAllUser();
    }

    public function delete(Request $request, string $id): void {

        DB::transaction(function () use ($id) {
            $randUser = RandomUser::findOrFail($id);
            // $randUser->created_at

            $dailyRecord = $this->persistentRepo->getDailyByDate($randUser->created_at);
            if ($dailyRecord == null){
                throw new \Exception('daily record not found', 404);
            }

            $columnName = $randUser->gender.'_count';
            $dailyRecord->$columnName -= 1;

            $this->persistentRepo->saveDaily($dailyRecord);

            $this->persistentRepo->deleteUser($randUser);
        });
    }
    
    public function getDailyRecords(): Collection {
        return $this->persistentRepo->selectAlldaily();
    }

}