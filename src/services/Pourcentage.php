<?php 
namespace App\services;

use App\DTO\PourcentageInputDto;
use App\DTO\PourcentageOutputDto;

class Pourcentage
{
public function Pourcentage(PourcentageInputDto $input): PourcentageOutputDto
{
    $result = $input->total * ($input->pourcentage / 100);
    return new PourcentageOutputDto($result); 
}

}