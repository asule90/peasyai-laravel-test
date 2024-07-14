<?php
namespace App\Repositories;

interface SourceRepoInterface {
    public function fetch(): array;
}