<?php

namespace App\Faker;

use Faker\Provider\Base;

class CategoryProvider extends Base
{
    private static array $categories = [
        'Mer',
        'Montagne',
        'Neige',
        'Soleil',
        'Balade',
        'Campagne',
        'Urbain',
    ];

    private static array $descriptions = [
        'Un lieu relaxant près de la mer, parfait pour les vacances.',
        'Une escapade aventureuse en montagne avec des vues spectaculaires.',
        'Un paradis enneigé pour les amateurs de sports d’hiver.',
        'Des destinations ensoleillées pour profiter du beau temps.',
        'Un endroit parfait pour des balades en pleine nature.',
        'Une ambiance calme et rustique au cœur de la campagne.',
        'Un séjour au cœur d’une ville dynamique et culturelle.',
    ];

    public final function category(): string
    {
        return self::randomElement(self::$categories);
    }

    public final function categoryDescription(): string
    {
        return self::randomElement(self::$descriptions);
    }

}