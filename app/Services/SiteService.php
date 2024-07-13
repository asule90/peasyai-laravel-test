<?php
namespace App\Services;

use App\Repositories\DataRepositoryInterface;
use App\Services\SiteServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SiteService implements SiteServiceInterface {
    public function __construct(
        public DataRepositoryInterface $repo
    ){}

    public function getList(): Collection {
        return $this->repo->selectAllUser();
    }

    public function delete(Request $request, string $id): void {
        $this->repo->deleteUser($id);
    }
}