<?php

namespace App\Test\Controller;

use App\Entity\MaintenanceRequest;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MaintenanceRequestControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/maintenance/request/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(MaintenanceRequest::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('MaintenanceRequest index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'maintenance_request[title]' => 'Testing',
            'maintenance_request[description]' => 'Testing',
            'maintenance_request[status]' => 'Testing',
            'maintenance_request[createdAt]' => 'Testing',
            'maintenance_request[updatedAt]' => 'Testing',
            'maintenance_request[deletedAt]' => 'Testing',
            'maintenance_request[requester]' => 'Testing',
            'maintenance_request[apartment]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new MaintenanceRequest();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setStatus('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setRequester('My Title');
        $fixture->setApartment('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('MaintenanceRequest');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new MaintenanceRequest();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setStatus('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setRequester('Value');
        $fixture->setApartment('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'maintenance_request[title]' => 'Something New',
            'maintenance_request[description]' => 'Something New',
            'maintenance_request[status]' => 'Something New',
            'maintenance_request[createdAt]' => 'Something New',
            'maintenance_request[updatedAt]' => 'Something New',
            'maintenance_request[deletedAt]' => 'Something New',
            'maintenance_request[requester]' => 'Something New',
            'maintenance_request[apartment]' => 'Something New',
        ]);

        self::assertResponseRedirects('/maintenance/request/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getRequester());
        self::assertSame('Something New', $fixture[0]->getApartment());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new MaintenanceRequest();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setStatus('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setRequester('Value');
        $fixture->setApartment('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/maintenance/request/');
        self::assertSame(0, $this->repository->count([]));
    }
}
