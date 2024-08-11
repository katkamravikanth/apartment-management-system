<?php

namespace App\Test\Controller;

use App\Entity\Lease;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeaseControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/lease/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Lease::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lease index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'lease[startDate]' => 'Testing',
            'lease[endDate]' => 'Testing',
            'lease[rentAmount]' => 'Testing',
            'lease[securityDeposit]' => 'Testing',
            'lease[createdAt]' => 'Testing',
            'lease[updatedAt]' => 'Testing',
            'lease[deletedAt]' => 'Testing',
            'lease[renter]' => 'Testing',
            'lease[apartment]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lease();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setRentAmount('My Title');
        $fixture->setSecurityDeposit('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setRenter('My Title');
        $fixture->setApartment('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lease');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lease();
        $fixture->setStartDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setRentAmount('Value');
        $fixture->setSecurityDeposit('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setRenter('Value');
        $fixture->setApartment('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'lease[startDate]' => 'Something New',
            'lease[endDate]' => 'Something New',
            'lease[rentAmount]' => 'Something New',
            'lease[securityDeposit]' => 'Something New',
            'lease[createdAt]' => 'Something New',
            'lease[updatedAt]' => 'Something New',
            'lease[deletedAt]' => 'Something New',
            'lease[renter]' => 'Something New',
            'lease[apartment]' => 'Something New',
        ]);

        self::assertResponseRedirects('/lease/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getRentAmount());
        self::assertSame('Something New', $fixture[0]->getSecurityDeposit());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getRenter());
        self::assertSame('Something New', $fixture[0]->getApartment());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lease();
        $fixture->setStartDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setRentAmount('Value');
        $fixture->setSecurityDeposit('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setRenter('Value');
        $fixture->setApartment('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/lease/');
        self::assertSame(0, $this->repository->count([]));
    }
}
