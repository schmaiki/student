<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $neuerSchueler = new Student();
        $neuerSchueler->setVorname('TestUser1');
        $neuerSchueler->setNachname('UserNachname');
        $neuerSchueler->setEmail('testuser@local.de');
        $neuerSchueler->setEintrittsdatum(new \DateTime('2023-02-15'));
        $neuerSchueler->setKommentar('test kommentar');

        $manager->persist($neuerSchueler);
        $manager->flush();
    }
}
