<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use App\Enum\PaymentStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $payment = new Payment();
        $payment->setAmount(1500.00);
        $payment->setDate(new \DateTimeImmutable());
        $payment->setStatus(PaymentStatus::COMPLETED);
        $payment->setRenter($this->getReference('user-renter'));
        $payment->setApartment($this->getReference('apartment-1a'));
        $manager->persist($payment);

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
