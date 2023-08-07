<?php

namespace App\Test\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StudentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private StudentRepository $repository;
    private string $path = '/student/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Student::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Student index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'student[Vorname]' => 'Testing',
            'student[Nachname]' => 'Testing',
            'student[Email]' => 'Testing',
            'student[Eintrittsdatum]' => 'Testing',
            'student[Kommentar]' => 'Testing',
        ]);

        self::assertResponseRedirects('/student/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Student();
        $fixture->setVorname('My Title');
        $fixture->setNachname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setEintrittsdatum('My Title');
        $fixture->setKommentar('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Student');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Student();
        $fixture->setVorname('My Title');
        $fixture->setNachname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setEintrittsdatum('My Title');
        $fixture->setKommentar('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'student[Vorname]' => 'Something New',
            'student[Nachname]' => 'Something New',
            'student[Email]' => 'Something New',
            'student[Eintrittsdatum]' => 'Something New',
            'student[Kommentar]' => 'Something New',
        ]);

        self::assertResponseRedirects('/student/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getVorname());
        self::assertSame('Something New', $fixture[0]->getNachname());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getEintrittsdatum());
        self::assertSame('Something New', $fixture[0]->getKommentar());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Student();
        $fixture->setVorname('My Title');
        $fixture->setNachname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setEintrittsdatum('My Title');
        $fixture->setKommentar('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/student/');
    }
}
