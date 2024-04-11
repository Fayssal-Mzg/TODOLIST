<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;
class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder ){

    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@demo.fr');
        $admin->setLastname('Fayss');
        $admin->setFirstname('Boss');
        $admin->setPassword(
            $this ->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin-> setRoles(['ROLE_ADMIN']);
   
        $manager->persist($admin);
        $faker= Faker\Factory::create('fr_FR');

        for ($usr = 1; $usr <=5; $usr++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastname);
            $user->setFirstname($faker->firstname);
            $user->setPassword(
                $this ->passwordEncoder->hashPassword($user, 'secret')
            );
       
            $manager->persist($user);

        }

        $manager->flush();
    }
}
