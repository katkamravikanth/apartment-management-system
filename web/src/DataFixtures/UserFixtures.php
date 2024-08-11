<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $user = new User(
            $faker->firstName,
            $faker->lastName,
            $faker->email,
            $this->passwordHasher->hashPassword(
                new User($faker->firstName,
                    $faker->lastName,
                    $faker->email,
                    'password',
                    $faker->phoneNumber,
                    $faker->phoneNumber,
                    $this->getReference("userType0")
                ),
                'password' // Default password for all users
            ),
            $faker->phoneNumber,
            $faker->phoneNumber,
            $this->getReference("userType0")
        );

        $manager->persist($user);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TransactionTypeFixtures::class,
            UserTypeFixtures::class,
        ];
    }
}