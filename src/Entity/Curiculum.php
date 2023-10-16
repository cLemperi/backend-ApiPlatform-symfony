<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CuriculumRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CuriculumRepository::class)]
#[ApiResource(
    // Les opérations disponibles pour les administrateurs incluent toutes les opérations CRUD.
    // Veuillez adapter les chemins et les méthodes en fonction de votre conception API.
)]
#[Post(security:"is_granted('ROLE_USER')")]     
#[Get(security: "is_granted('ROLE_ADMIN')")]
#[GetCollection(security:"is_granted('ROLE_ADMIN')")]
#[Delete(security:"is_granted('ROLE_ADMIN')")]
class Curiculum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['curiculum:write'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['curiculum:write'])]
    private ?string $CuriculumFile = null;

    #[ORM\Column(length: 255)]
    #[Groups(['curiculum:write'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['curiculum:write'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 700, nullable: true)]
    #[Groups(['curiculum:write'])]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCuriculumFile(): ?string
    {
        return $this->CuriculumFile;
    }

    public function setCuriculumFile(string $CuriculumFile): static
    {
        $this->CuriculumFile = $CuriculumFile;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
