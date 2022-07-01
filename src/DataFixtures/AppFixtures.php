<?php

namespace App\DataFixtures;

use App\Entity\Tricks;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        /*admin type user*/
        $user = new User();

        $user->setFirstname('sergio');
        $user->setLastname('prieto');
        $user->setPassword('azerty');
        $user->setEmail('sergio@yieldstudio.fr');
        $user->setConfirmed(true);
        $user->setRoles(['admin', 'user']);

        $manager->persist($user);
        $manager->flush();

        /*visitors*/
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setFirstname($this->faker->firstName());
            $user->setLastname($this->faker->lastName());
            $user->setPassword($this->faker->password());
            $user->setEmail($this->faker->email());
            $user->setConfirmed(false);
            $user->setRoles(['user']);


            $manager->persist($user);
        }

        /*tricks*/
        $tricksList = array("stalefish", "backside rodeo 1080", "backflip", "frontFlip");
        for ($i = 0; $i < count($tricksList); $i++) {
            $tricks = new Tricks();

            $tricks->setTitle($tricksList[$i]);
            $tricks->setDescription($this->faker->paragraph());
            $tricks->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($tricks);
        }

        $manager->flush();
    }
}
