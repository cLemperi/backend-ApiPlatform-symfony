<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\MetaData\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
#[Get(normalizationContext:['groups' => ['user:read']])]
#[GetCollection(normalizationContext:['groups' => ['user:read']])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['formation:list', 'user:read'])]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Article::class)]
    private Collection $articles;

    #[ORM\OneToMany(mappedBy: 'userFrom', targetEntity: UserFrom::class)]
    private Collection $userFroms;

    #[ORM\OneToMany(mappedBy: 'userMessage', targetEntity: UserMessage::class, orphanRemoval: true)]
    private Collection $userMessages;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FormationsUser::class, orphanRemoval: true)]
    private Collection $formationsUsers;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->userFroms = new ArrayCollection();
        $this->userMessages = new ArrayCollection();
        $this->formationsUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserMessage>
     */
    public function getUserMessages(): Collection
    {
        return $this->userMessages;
    }

    public function addUserMessage(UserMessage $userMessage): static
    {
        if (!$this->userMessages->contains($userMessage)) {
            $this->userMessages->add($userMessage);
            $userMessage->setUserMessage($this);
        }

        return $this;
    }

    public function removeUserMessage(UserMessage $userMessage): static
    {
        if ($this->userMessages->removeElement($userMessage)) {
            // set the owning side to null (unless already changed)
            if ($userMessage->getUserMessage() === $this) {
                $userMessage->setUserMessage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormationsUser>
     */
    public function getFormationsUsers(): Collection
    {
        return $this->formationsUsers;
    }

    public function addFormationsUser(FormationsUser $formationsUser): static
    {
        if (!$this->formationsUsers->contains($formationsUser)) {
            $this->formationsUsers->add($formationsUser);
            $formationsUser->setUser($this);
        }

        return $this;
    }

    public function removeFormationsUser(FormationsUser $formationsUser): static
    {
        if ($this->formationsUsers->removeElement($formationsUser)) {
            // set the owning side to null (unless already changed)
            if ($formationsUser->getUser() === $this) {
                $formationsUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserFrom>
     */
    public function getUserFroms(): Collection
    {
        return $this->userFroms;
    }

    public function addUserFrom(UserFrom $userFrom): static
    {
        if (!$this->userFroms->contains($userFrom)) {
            $this->userFroms->add($userFrom);
            $userFrom->setUserFrom($this);
        }

        return $this;
    }

    public function removeUserFrom(UserFrom $userFrom): static
    {
        if ($this->userFroms->removeElement($userFrom)) {
            // set the owning side to null (unless already changed)
            if ($userFrom->getUserFrom() === $this) {
                $userFrom->setUserFrom(null);
            }
        }

        return $this;
    }
}
