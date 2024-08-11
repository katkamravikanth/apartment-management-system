<?php

namespace App\Test\Controller;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocumentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/document/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Document::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Document index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'document[title]' => 'Testing',
            'document[filePath]' => 'Testing',
            'document[uploadedAt]' => 'Testing',
            'document[createdAt]' => 'Testing',
            'document[updatedAt]' => 'Testing',
            'document[deletedAt]' => 'Testing',
            'document[uploader]' => 'Testing',
            'document[apartment]' => 'Testing',
            'document[lease]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Document();
        $fixture->setTitle('My Title');
        $fixture->setFilePath('My Title');
        $fixture->setUploadedAt('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setUploader('My Title');
        $fixture->setApartment('My Title');
        $fixture->setLease('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Document');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Document();
        $fixture->setTitle('Value');
        $fixture->setFilePath('Value');
        $fixture->setUploadedAt('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setUploader('Value');
        $fixture->setApartment('Value');
        $fixture->setLease('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'document[title]' => 'Something New',
            'document[filePath]' => 'Something New',
            'document[uploadedAt]' => 'Something New',
            'document[createdAt]' => 'Something New',
            'document[updatedAt]' => 'Something New',
            'document[deletedAt]' => 'Something New',
            'document[uploader]' => 'Something New',
            'document[apartment]' => 'Something New',
            'document[lease]' => 'Something New',
        ]);

        self::assertResponseRedirects('/document/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getFilePath());
        self::assertSame('Something New', $fixture[0]->getUploadedAt());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getUploader());
        self::assertSame('Something New', $fixture[0]->getApartment());
        self::assertSame('Something New', $fixture[0]->getLease());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Document();
        $fixture->setTitle('Value');
        $fixture->setFilePath('Value');
        $fixture->setUploadedAt('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setUploader('Value');
        $fixture->setApartment('Value');
        $fixture->setLease('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/document/');
        self::assertSame(0, $this->repository->count([]));
    }
}
