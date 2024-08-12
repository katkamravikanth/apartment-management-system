<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use App\Enum\InvoiceStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $invoice = new Invoice();
        $invoice->setAmount(1500.00);
        $invoice->setDueDate(new \DateTimeImmutable('+1 month'));
        $invoice->setStatus(InvoiceStatus::PAID);
        $invoice->setRenter($this->getReference('user-renter'));
        $invoice->setApartment($this->getReference('apartment-1a'));
        $manager->persist($invoice);

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
