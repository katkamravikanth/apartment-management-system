<?php

namespace App\DataFixtures;

use App\Entity\Apartment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ApartmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $apartment = new Apartment();
        $apartment->setName('Apartment 1A');
        $apartment->setAddress('123 Main St, Springfield, Apt 1A');
        $apartment->setSize(80);
        $apartment->setRentAmount(1500.00);
        $apartment->setOwner($this->getReference('user-owner'));
        $apartment->setBuilding($this->getReference('building-1'));
        $manager->persist($apartment);

        $manager->flush();

        // Reference for other fixtures
        $this->addReference('apartment-1a', $apartment);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            BuildingFixtures::class,
        ];
    }
}
