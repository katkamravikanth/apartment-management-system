<?php

namespace App\DataFixtures;

use App\Entity\Notification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NotificationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $notification = new Notification();
        $notification->setContent('Your rent is due in one week.');
        $notification->setType('Payment');
        $notification->setIsRead(false);
        $notification->setRecipient($this->getReference('user-renter'));
        $manager->persist($notification);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
