<?php

namespace App\services;

class Fete
{
public function getTodayTheme(): string
{
    $calendar = [
        '11-07' => 'journée des canards',
        '12-07' => 'journée des lapins',
        '13-07' => 'journée des poireaux',
        // Ajoute autant de dates que tu veux (Ou récupère de la base de données)
    ];

    $today = date('d-m');

    return $calendar[$today] ?? 'Aucune fête enregistrée pour aujourd’hui';
}
}