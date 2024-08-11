<?php

namespace App\DataFixtures;

use App\Entity\MaintenanceRequest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MaintenanceRequestFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $maintenanceRequest = new MaintenanceRequest();
        $maintenanceRequest->setTitle('Leaky Faucet');
        $maintenanceRequest->setDescription('The faucet in the kitchen is leaking.');
        $maintenanceRequest->setStatus('Open');
        $maintenanceRequest->setRequester($this->getReference('user-renter'));
        $maintenanceRequest->setApartment($this->getReference('apartment-1a'));
        $manager->persist($maintenanceRequest);

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
