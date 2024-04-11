<?php

namespace App\DataFixtures;
use App\Entity\Task;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// description/statut/priority
class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker= Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setDescription($faker->sentence());
            $task->setStatut($faker->randomElement(['Pas commencé', 'En cours', 'Fait', 'Annulée']));
            $task->setPriority($faker->randomElement(['Elevée', 'Moyenne', 'Faible']));

            $manager->persist($task);
        }

        $manager->flush();
    }
    
}
