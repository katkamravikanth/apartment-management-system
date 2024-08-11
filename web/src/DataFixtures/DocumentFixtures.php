<?php

namespace App\DataFixtures;

use App\Entity\Document;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DocumentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $document = new Document();
        $document->setTitle('Lease Agreement');
        $document->setFilePath('/path/to/lease-agreement.pdf');
        $document->setUploadedAt(new \DateTimeImmutable());
        $document->setUploader($this->getReference('user-owner'));
        $document->setApartment($this->getReference('apartment-1a'));
        $manager->persist($document);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ApartmentFixtures::class,
            LeaseFixtures::class,
        ];
    }
}
