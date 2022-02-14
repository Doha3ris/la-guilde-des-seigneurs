<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Character;
use App\Entity\Player;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         * Character fixture
         */
        for ($i = 0; $i < 10; $i++) {
            $character = new Character();
            $character
                ->setIdentifier(hash('sha1', uniqid()))
                ->setKind(rand(0, 1) ? 'Dame' : 'Seigneur')
                ->setName('Eldalótë' . $i)
                ->setSurname('Fleur elfique')
                ->setCaste('Elfe')
                ->setKnowledge('Arts')
                ->setIntelligence(mt_rand(100, 200))
                ->setLife(mt_rand(10, 20))
                ->setImage('/images/eldalote.jpg')
                ->setCreation(new DateTime())
                ->setModification(new DateTime());

            $manager->persist($character);

            $player = new Player();
            $player
                ->setIdentifier(hash('sha1', uniqid()))
                ->setFirstname(rand(0, 1) ? 'Valentin' : 'Gauthier')
                ->setLastname(rand(0, 1) ? 'Henri' . $i : 'Mathieu' . $i)
                ->setEmail("oofed" . $i . "@valfol.org")
                ->setMirian(25)
                ->setCreation(new DateTime())
                ->setModification(new DateTime());

            $manager->persist($player);
        }

        $manager->flush();
    }
}
