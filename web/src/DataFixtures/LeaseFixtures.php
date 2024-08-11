<?php

namespace App\DataFixtures;

use App\Entity\Lease;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LeaseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $lease = new Lease();
        $lease->setStartDate(new \DateTimeImmutable('2023-01-01'));
        $lease->setEndDate(new \DateTimeImmutable('2023-12-31'));
        $lease->setRentAmount(1500.00);
        $lease->setSecurityDeposit(1500.00);
        $lease->setRenter($this->getReference('user-renter'));
        $lease->setApartment($this->getReference('apartment-1a'));
        $manager->persist($lease);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ApartmentFixtures::class,
        ];
    }
}
