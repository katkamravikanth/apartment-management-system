<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create an admin user
        $admin = new User();
        $admin->setFirstName('Admin');
        $admin->setLastName('User');
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpassword'));
        $admin->setPhoneNumber('1234567890');
        $admin->setVerified(true);
        $manager->persist($admin);

        // Create an owner user
        $owner = new User();
        $owner->setFirstName('Owner');
        $owner->setLastName('User');
        $owner->setEmail('owner@example.com');
        $owner->setRoles(['ROLE_OWNER']);
        $owner->setPassword($this->passwordHasher->hashPassword($owner, 'ownerpassword'));
        $owner->setPhoneNumber('0987654321');
        $owner->setVerified(true);
        $manager->persist($owner);

        // Create a renter user
        $renter = new User();
        $renter->setFirstName('Renter');
        $renter->setLastName('User');
        $renter->setEmail('renter@example.com');
        $renter->setRoles(['ROLE_RENTER']);
        $renter->setPassword($this->passwordHasher->hashPassword($renter, 'renterpassword'));
        $renter->setPhoneNumber('1122334455');
        $renter->setVerified(true);
        $manager->persist($renter);

        // Save all the users to the database
        $manager->flush();

        // Reference for other fixtures
        $this->addReference('user-admin', $admin);
        $this->addReference('user-owner', $owner);
        $this->addReference('user-renter', $renter);
    }
}
