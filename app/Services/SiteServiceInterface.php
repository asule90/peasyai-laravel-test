<?php
namespace App\Services;

use App\Dto\UserQueryDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;

interface SiteServiceInterface {
    public function getList(UserQueryDto $filterQuery): SupportCollection;
    public function delete(Request $request, string $id): void;
    public function getDailyRecords(): Collection;
}