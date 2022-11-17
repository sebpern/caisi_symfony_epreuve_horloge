<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0;$i<10;$i++){
            $formation = new Formation();
            $formation->setCode("Code ".$i);
            $formation->setLibelle("Libelle ".$i);
            $manager->persist($formation);
        }
        $manager->flush();
    }
}
