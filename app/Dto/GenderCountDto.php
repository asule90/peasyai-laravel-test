<?php

namespace App\Dto;

class GenderCountDto {
    public function __construct(
        public int $male = 0,
        public int $female = 0,
    ) { }
}