<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\UserMessageRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserMessageRepository::class)]
#[ApiResource(
    // Les opérations disponibles pour les administrateurs incluent toutes les opérations CRUD.
    // Veuillez adapter les chemins et les méthodes en fonction de votre conception API.
    operations: [
        'get' => new Get(),
        'get_collection' => new GetCollection(security:"is_granted('ROLE_ADMIN')"),
        'post' => new Post(denormalizationContext: ['groups' => ['userMessage:write']], security: "is_granted('ROLE_ADMIN')"),
        'put' => new Put(security: "is_granted('ROLE_ADMIN')"),
        'delete' => new Delete(security: "is_granted('ROLE_ADMIN')")
    ]
)]
class UserMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('userMessage:write')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('userMessage:write')]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isArchived = null;

    #[ORM\ManyToOne(inversedBy: 'userMessages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userMessage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function isIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): static
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getUserMessage(): ?User
    {
        return $this->userMessage;
    }

    public function setUserMessage(?User $userMessage): static
    {
        $this->userMessage = $userMessage;

        return $this;
    }
}
