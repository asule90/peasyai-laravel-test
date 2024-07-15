<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface SiteServiceInterface {
    public function getList(): Collection;
    public function delete(Request $request, string $id): void;
    public function getDailyRecords(): Collection;
}