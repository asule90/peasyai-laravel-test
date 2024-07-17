<?php
namespace App\Dto;

class UserQueryDto {
    public function __construct(
        public ?string $search = null,
        public ?int $page = 1,
        public ?int $per_page = 10
    ) { }

}