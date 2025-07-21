<?php

namespace App\services;

class Messages
{
    public function gotMessage(): string
    {
        $message = [
            'Tu l\'as fait, tu as upgrade le projet!',
            'C\'est la meilleure upgrade de toute ma vie!',
            'J\'aime les sabliers!',
        ];
        $index = array_rand($message);
        return $message[$index];
    }
}