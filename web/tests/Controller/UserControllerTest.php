<?php

namespace App\Test\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/api/user/';
    private string $jwtToken;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->followRedirects(true);
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(User::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();

        $this->createTestUserAndAuthenticate();
    }

    private function createTestUserAndAuthenticate(): void
    {
        $hasher = static::getContainer()->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail('testuser@example.com');
        $user->setPassword($hasher->hashPassword($user, 'password'));

        $this->manager->persist($user);
        $this->manager->flush();

        // Obtain JWT token
        $this->client->request('POST', '/api/login', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'email' => 'testuser@example.com',
            'password' => 'password'
        ]));

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        $this->jwtToken = $data['token'];
    }

    public function testIndex(): void
    {
        $this->client->request('GET', $this->path, [], [], ['HTTP_Authorization' => 'Bearer ' . $this->jwtToken]);

        self::assertResponseStatusCodeSame(200);
    }

    public function testShow(): void
    {
        $fixture = new User();
        $fixture->setEmail('showuser@example.com');
        $fixture->setPassword('password');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()), [], [], ['HTTP_Authorization' => 'Bearer ' . $this->jwtToken]);

        self::assertResponseStatusCodeSame(200);
    }

    public function testNew(): void
    {
        $this->client->request('POST', $this->path . 'new', [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_Authorization' => 'Bearer ' . $this->jwtToken], json_encode([
            'email' => 'newuser@example.com',
            'password' => 'password'
        ]));

        self::assertResponseStatusCodeSame(201);
    }

    public function testEdit(): void
    {
        $fixture = new User();
        $fixture->setEmail('edituser@example.com');
        $fixture->setPassword('password');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('PUT', sprintf('%s%s', $this->path, $fixture->getId()), [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_Authorization' => 'Bearer ' . $this->jwtToken], json_encode([
            'email' => 'updated@example.com',
            'roles' => ['ROLE_ADMIN'],
            'password' => 'newpassword'
        ]));

        self::assertResponseStatusCodeSame(200);

        $updatedUser = $this->repository->find($fixture->getId());

        self::assertSame('updated@example.com', $updatedUser->getEmail());
    }

    public function testRemove(): void
    {
        $fixture = new User();
        $fixture->setEmail('removeuser@example.com');
        $fixture->setPassword('password');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('DELETE', sprintf('%s%s', $this->path, $fixture->getId()), [], [], ['HTTP_Authorization' => 'Bearer ' . $this->jwtToken]);

        self::assertResponseStatusCodeSame(204);
        self::assertSame(0, $this->repository->count(['email' => 'removeuser@example.com']));
    }

    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn() => null);
            restore_exception_handler();

            if ($previousHandler === null) {
                break;
            }

            restore_exception_handler();
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->restoreExceptionHandler();
    }
}
