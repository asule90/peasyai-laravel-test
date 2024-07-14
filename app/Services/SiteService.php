<?php
namespace App\Services;

use App\Repositories\PersistentRepoInterface;
use App\Services\SiteServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SiteService implements SiteServiceInterface {
    public function __construct(
        public PersistentRepoInterface $persistentRepo
    ){}

    public function getList(): Collection {
        return $this->persistentRepo->selectAllUser();
    }

    public function delete(Request $request, string $id): void {
        $this->persistentRepo->deleteUser($id);
    }
}