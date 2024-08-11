<?php

namespace App\DataFixtures;

use App\Entity\Building;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BuildingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $building = new Building();
        $building->setName('Sunset Towers');
        $building->setAddress('123 Main St, Springfield');
        $building->setNumOfFloors(10);
        $manager->persist($building);

        $manager->flush();

        // Reference for other fixtures
        $this->addReference('building-1', $building);
    }
}
