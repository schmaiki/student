<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Vorname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nachname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Eintrittsdatum = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Kommentar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVorname(): ?string
    {
        return $this->Vorname;
    }

    public function setVorname(?string $Vorname): static
    {
        $this->Vorname = $Vorname;

        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->Nachname;
    }

    public function setNachname(?string $Nachname): static
    {
        $this->Nachname = $Nachname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getEintrittsdatum(): ?\DateTimeInterface
    {
        return $this->Eintrittsdatum;
    }

    public function setEintrittsdatum(?\DateTimeInterface $Eintrittsdatum): static
    {
        $this->Eintrittsdatum = $Eintrittsdatum;

        return $this;
    }

    public function getKommentar(): ?string
    {
        return $this->Kommentar;
    }

    public function setKommentar(?string $Kommentar): static
    {
        $this->Kommentar = $Kommentar;

        return $this;
    }
}
