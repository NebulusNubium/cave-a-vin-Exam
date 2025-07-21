<?php

namespace App\Controller;

use App\services\Messages;
use App\services\DateAnniv;
use App\services\Pourcentage;
use App\DTO\PourcentageInputDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController{
    #[Route('/', name: 'home')]
    public function index(Messages $myMessage, DateAnniv $anniv, Pourcentage $calculette): Response
    {
        $HomeMessage = $myMessage->gotMessage();
        $lilou = $anniv->dateAnniv('Lilou', '11-07-2025');
        $number = floatval(45.9);
        $percentage = floatval(5.2);
        $inputDto = new PourcentageInputDto($number, $percentage);
        $outputDto = $calculette->pourcentage($inputDto);
        return $this->render('home/index.html.twig', [
            'HomeMessage'=> $HomeMessage,
            'dateAnniv'=>$lilou,
            'result' =>$outputDto,
            'input'=> $number,
            'pourcentage'=>$percentage,
        ]);
    }
}
