<?php

namespace App\Faker;
use Faker\Provider\Base;

class ReviewProvider extends Base
{

    public final function reviewDescription(): String
    {
        $descriptions = [
            'Un séjour agréable, l’accueil était chaleureux et la chambre très confortable.',
            'Excellente expérience ! L’endroit est calme et bien situé, parfait pour se détendre.',
            'Très bon séjour, les hôtes sont accueillants et la chambre propre et bien équipée.',
            'Nous avons passé un moment magnifique, la vue depuis la chambre était incroyable.',
            'La maison est charmante et le service impeccable, nous reviendrons avec plaisir.',
            'Un endroit parfait pour se ressourcer. Tout était à la hauteur de nos attentes.',
            'Les chambres sont spacieuses et décorées avec goût. Nous avons adoré notre séjour.',
            'Un accueil exceptionnel, les hôtes sont attentionnés et aux petits soins.',
            'Séjour très agréable, la literie était très confortable et l’ambiance très calme.',
            'Le cadre est idyllique, parfait pour un week-end en amoureux ou en famille.',
            'Très bon rapport qualité/prix. Nous recommandons vivement cet endroit.',
            'L’endroit est parfait pour se reposer, l’atmosphère est apaisante et relaxante.',
            'Le petit déjeuner était délicieux et très varié, une vraie gourmandise.',
            'Une maison d’hôtes à la hauteur de nos espérances, nous reviendrons sans hésiter.',
            'Tout était parfait, du service à la chambre en passant par les installations.',
            'Un endroit de rêve, nous avons passé un excellent moment en famille.',
            'L’accueil était très chaleureux, nous avons été traités comme des rois.',
            'Très bonne expérience, l’emplacement est idéal et la chambre très agréable.',
            'Nous avons adoré notre séjour. La chambre était propre et bien aménagée.',
            'L’hôte a été très accueillant et nous a donné de bons conseils pour visiter la région.',
            'Un séjour magnifique, tout était parfait, un vrai havre de paix.',
            'L’endroit est calme, avec une belle vue et des équipements modernes et pratiques.',
            'Nous avons passé un moment très agréable, un très bon rapport qualité/prix.',
            'La décoration de la chambre était magnifique et très soignée.',
            'Séjour très agréable, calme et reposant. L’endroit est parfait pour se détendre.',
            'Nous recommandons vivement cet endroit. Le cadre est magnifique et les hôtes très sympas.',
            'Un lieu charmant, idéal pour une escapade en amoureux ou un week-end relaxant.',
            'La maison est superbe, très bien située et les chambres sont parfaites.',
            'L’hôte est très sympathique et disponible, il nous a bien conseillé sur les activités locales.',
            'Séjour très agréable, tout était conforme à nos attentes.',
            'Une superbe expérience, nous reviendrons sans hésiter.',
            'Le cadre est magnifique, et la chambre était parfaite pour un séjour relaxant.',
            'Les hôtes étaient très accueillants et nous avons passé un moment très agréable.',
            'Le petit déjeuner était excellent, avec des produits locaux et frais.',
            'Une maison d’hôtes très agréable, bien située et calme.',
            'Le service était impeccable, nous avons été traités comme des rois.',
            'Une belle découverte, la maison est très bien située et très agréable.',
            'Séjour très agréable, avec un accueil chaleureux et une chambre confortable.',
            'Les chambres sont spacieuses et bien décorées, un vrai plaisir.',
            'L’endroit est calme, idéal pour un séjour reposant.',
            'Un séjour parfait, nous reviendrons très certainement.',
            'Le cadre était idyllique, et la maison pleine de charme.',
            'Les hôtes étaient très accueillants et nous ont donné plein de bons conseils.',
            'Nous avons adoré cet endroit, tout était parfait.',
            'Un endroit calme et reposant, avec une très bonne literie.',
            'Les hôtes sont très sympathiques et à l’écoute de leurs invités.',
            'Un cadre magnifique, parfait pour un séjour en famille ou entre amis.',
            'La chambre était très bien aménagée, avec une belle vue.',
            'Un accueil chaleureux et un cadre superbe, nous recommandons vivement.',
            'Le service était parfait et l’emplacement idéal.',
            'Nous avons passé un moment exceptionnel, tout était au top.',
            'Un séjour reposant et agréable, avec une belle maison bien située.'
        ];

        $firstDescription = self::randomElement($descriptions);
        $secondDescription = self::randomElement($descriptions);

        return $firstDescription . ' ' . $secondDescription;

    }

}