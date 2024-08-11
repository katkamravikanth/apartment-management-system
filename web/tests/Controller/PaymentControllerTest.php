<?php

namespace App\Test\Controller;

use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/payment/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Payment::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Payment index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'payment[amount]' => 'Testing',
            'payment[date]' => 'Testing',
            'payment[status]' => 'Testing',
            'payment[createdAt]' => 'Testing',
            'payment[updatedAt]' => 'Testing',
            'payment[deletedAt]' => 'Testing',
            'payment[renter]' => 'Testing',
            'payment[apartment]' => 'Testing',
            'payment[invoice]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Payment();
        $fixture->setAmount('My Title');
        $fixture->setDate('My Title');
        $fixture->setStatus('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setRenter('My Title');
        $fixture->setApartment('My Title');
        $fixture->setInvoice('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Payment');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Payment();
        $fixture->setAmount('Value');
        $fixture->setDate('Value');
        $fixture->setStatus('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setRenter('Value');
        $fixture->setApartment('Value');
        $fixture->setInvoice('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'payment[amount]' => 'Something New',
            'payment[date]' => 'Something New',
            'payment[status]' => 'Something New',
            'payment[createdAt]' => 'Something New',
            'payment[updatedAt]' => 'Something New',
            'payment[deletedAt]' => 'Something New',
            'payment[renter]' => 'Something New',
            'payment[apartment]' => 'Something New',
            'payment[invoice]' => 'Something New',
        ]);

        self::assertResponseRedirects('/payment/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAmount());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getStatus());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getRenter());
        self::assertSame('Something New', $fixture[0]->getApartment());
        self::assertSame('Something New', $fixture[0]->getInvoice());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Payment();
        $fixture->setAmount('Value');
        $fixture->setDate('Value');
        $fixture->setStatus('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setRenter('Value');
        $fixture->setApartment('Value');
        $fixture->setInvoice('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/payment/');
        self::assertSame(0, $this->repository->count([]));
    }
}
