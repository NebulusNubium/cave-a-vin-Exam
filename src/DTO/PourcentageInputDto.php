<?php
namespace App\DTO;

class PourcentageInputDto
{
    public function __construct(
        public float $total,
        public float $pourcentage
    )
    {}
}