<?php

namespace App\services;

use DateTime;

class DateAnniv
{
public function dateAnniv(string $user, string $anniv): string
{
    $annivDate = DateTime::createFromFormat('d-m-Y', $anniv);
    $today     = new DateTime();

    if (!$annivDate) {
        return 'Date invalide.';
    }

    if ($annivDate->format('d/m') === $today->format('d/m')) {
        return 'Bon anniversaire, ' . $user . ' !';
    }
    return 'On est le ';
}
}