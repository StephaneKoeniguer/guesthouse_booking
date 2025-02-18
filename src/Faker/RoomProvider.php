<?php

namespace App\Faker;

use Faker\Provider\Base;

class RoomProvider extends Base
{
    public final function roomName(): String
    {
        $names = [
            'Le Repos du Voyageur',
            'La Douceur de l’Accueil',
            'L’Oasis des Sens',
            'La Sérénité de l’Instant',
            'Les Cimes de la Tranquillité',
            'L’Écrin du Bonheur',
            'Le Jardin Secret',
            'L’Escapade Enchantée',
            'La Maison de la Lune',
            'Les Rêves d’Antan',
            'Le Refuge des Étoiles',
            'Le Domaine des Délices',
            'Les Lumières du Matin',
            'Le Chalet du Bonheur',
            'Le Manoir des Flots',
            'La Maison des Vents',
            'L’Instant Suspendu',
            'Le Havre de Paix',
            'La Villa du Soleil Couchant',
            'Le Sentier de la Sérénité',
            'La Chambre des Douces Nuits',
            'Le Coeur des Montagnes',
            'Le Parfum des Fleurs',
            'Les Étoiles du Soir',
            'La Forêt Enchantée',
            'Le Refuge des Rêveries',
            'La Perle du Lac',
            'L’Armure du Silence',
            'Le Charme Secret',
            'Le Balcon du Bonheur'
        ];

        return self::randomElement($names);

    }


    public final function roomDescription(): string
    {
        $introductions = [
            'Une charmante chambre avec une vue magnifique.',
            'Un espace confortable pour se détendre après une journée bien remplie.',
            'Chaleureusement décorée pour un séjour inoubliable.',
            'Idéalement située, cette chambre offre tout le confort nécessaire.',
            'Un lieu parfait pour un moment de repos ou d’évasion.',
        ];

        $details = [
            'Elle dispose d’un lit spacieux et d’un mobilier élégant.',
            'Profitez de sa luminosité naturelle et de son ambiance apaisante.',
            'Équipée de toutes les commodités modernes pour votre confort.',
            'Avec une salle de bain privée et une vue imprenable sur les environs.',
            'Parfaite pour les couples, les familles ou les voyageurs en solo.',
        ];

        $conclusions = [
            'Vous serez charmé par son atmosphère unique.',
            'Une adresse incontournable pour vos vacances.',
            'Une expérience qui restera gravée dans votre mémoire.',
            'Un véritable havre de paix pour se ressourcer.',
            'Le choix idéal pour une escapade relaxante.',
        ];

        // Combine les phrases pour former une description complète
        return sprintf(
            '%s %s %s',
            self::randomElement($introductions),
            self::randomElement($details),
            self::randomElement($conclusions)
        );
    }

}