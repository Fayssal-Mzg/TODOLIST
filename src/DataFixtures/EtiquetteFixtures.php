<?php

namespace App\DataFixtures;

use App\Entity\Etiquette;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtiquetteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $etiquettes = [
            'Urgent' => 1,
            'Important' => 2,
            'Personnel' => 3,
            'Professionnel' => 4,
            'Maison' => 5,
            // Ajoutez d'autres étiquettes avec leur numéro de couleur correspondant ici...
        ];

        // Génération d'étiquettes fictives
        foreach ($etiquettes as $nom => $numeroCouleur) {
            $etiquette = new Etiquette();
            $etiquette->setName($nom);
            $etiquette->setCouleur($numeroCouleur);

            $manager->persist($etiquette);
        }

        $manager->flush();
    }
}
