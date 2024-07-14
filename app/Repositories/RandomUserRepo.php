<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RandomUserRepo implements SourceRepoInterface {

    public function fetch(): array {
        $response = Http::get(config('app.api_random_user'));
        if ($response->ok()) {
            return $response->json('results');
        }

        Log::warn('api communication attempt was failed');
        throw $response->toException();
    }
}