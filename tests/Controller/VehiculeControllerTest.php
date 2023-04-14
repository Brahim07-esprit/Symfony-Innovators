<?php

namespace App\Test\Controller;

use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VehiculeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/vehicule/contoller/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Vehicule::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vehicule index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'vehicule[typeDuVehicule]' => 'Testing',
            'vehicule[marque]' => 'Testing',
            'vehicule[cinConducteur]' => 'Testing',
            'vehicule[etat]' => 'Testing',
            'vehicule[kilometrage]' => 'Testing',
            'vehicule[imagev]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Vehicule();
        $fixture->setTypeDuVehicule('My Title');
        $fixture->setMarque('My Title');
        $fixture->setCinConducteur('My Title');
        $fixture->setEtat('My Title');
        $fixture->setKilometrage('My Title');
        $fixture->setImagev('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vehicule');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Vehicule();
        $fixture->setTypeDuVehicule('Value');
        $fixture->setMarque('Value');
        $fixture->setCinConducteur('Value');
        $fixture->setEtat('Value');
        $fixture->setKilometrage('Value');
        $fixture->setImagev('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'vehicule[typeDuVehicule]' => 'Something New',
            'vehicule[marque]' => 'Something New',
            'vehicule[cinConducteur]' => 'Something New',
            'vehicule[etat]' => 'Something New',
            'vehicule[kilometrage]' => 'Something New',
            'vehicule[imagev]' => 'Something New',
        ]);

        self::assertResponseRedirects('/vehicule/contoller/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTypeDuVehicule());
        self::assertSame('Something New', $fixture[0]->getMarque());
        self::assertSame('Something New', $fixture[0]->getCinConducteur());
        self::assertSame('Something New', $fixture[0]->getEtat());
        self::assertSame('Something New', $fixture[0]->getKilometrage());
        self::assertSame('Something New', $fixture[0]->getImagev());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Vehicule();
        $fixture->setTypeDuVehicule('Value');
        $fixture->setMarque('Value');
        $fixture->setCinConducteur('Value');
        $fixture->setEtat('Value');
        $fixture->setKilometrage('Value');
        $fixture->setImagev('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/vehicule/contoller/');
        self::assertSame(0, $this->repository->count([]));
    }
}
