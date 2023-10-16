<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\FormationsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: FormationsRepository::class)]
#[ApiResource(
    // Les opérations disponibles pour les administrateurs incluent toutes les opérations CRUD.
    // Veuillez adapter les chemins et les méthodes en fonction de votre conception API.
    operations: [
        'post' => new Post(denormalizationContext: ['groups' => ['formation:write']], normalizationContext:['groups' => ['formation:read']]),
    ]
)]
#[Post(security:"is_granted('ROLE_ADMIN')")]     
#[Get(security: "is_granted('ROLE_USER')")]
#[GetCollection(security:"is_granted('ROLE_USER')")]
#[Delete(security:"is_granted('ROLE_ADMIN')")]
class Formations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['formation:read'],['formation:write'])]  
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $forWho = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $prerequisite = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $dateFormation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $durationFormation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Category $Category = null;

    #[ORM\OneToMany(mappedBy: 'formations', targetEntity: ProgrammeFormation::class, cascade: ['persist'])]
    #[Groups(['formation:read'],['formation:write'])]
    private Collection $programmeFormation;

    #[ORM\OneToMany(mappedBy: 'formations', targetEntity: ObjectifFormation::class, cascade: ['persist'])]
    #[Groups(['formation:read'],['formation:write'])]
    private Collection $objectifFormation;

    #[ORM\Column(length: 255)]
    
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $intervenant = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $evaluation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $publicAccesAndCondition = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['formation:read'],['formation:write'])]
    private ?string $programmePedagoFile = null;

    #[ORM\ManyToMany(targetEntity: UserFrom::class, mappedBy: 'formationRegistration')]
    #[Groups(['formation:read'])]
    private Collection $userFroms;

    #[ORM\OneToMany(mappedBy: 'formations', targetEntity: FormationsUser::class, orphanRemoval: true)]
    private Collection $formationsUsers;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->programmeFormation = new ArrayCollection();
        $this->objectifFormation = new ArrayCollection();
        $this->userFroms = new ArrayCollection();
        $this->formationsUsers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function computeSlug(SluggerInterface $slugger) 
    {
        $this->slug = $slugger->slug($this)->lower();
    }

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getForWho(): ?string
    {
        return $this->forWho;
    }

    public function setForWho(?string $forWho): static
    {
        $this->forWho = $forWho;

        return $this;
    }

    public function getPrerequisite(): ?string
    {
        return $this->prerequisite;
    }

    public function setPrerequisite(?string $prerequisite): static
    {
        $this->prerequisite = $prerequisite;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDateFormation(): ?string
    {
        return $this->dateFormation;
    }

    public function setDateFormation(?string $dateFormation): static
    {
        $this->dateFormation = $dateFormation;

        return $this;
    }

    public function getDurationFormation(): ?string
    {
        return $this->durationFormation;
    }

    public function setDurationFormation(?string $durationFormation): static
    {
        $this->durationFormation = $durationFormation;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return Collection<int, ProgrammeFormation>
     */
    public function getProgrammeFormation(): Collection
    {
        return $this->programmeFormation;
    }

    public function addProgrammeFormation(ProgrammeFormation $programmeFormation): static
    {
        if (!$this->programmeFormation->contains($programmeFormation)) {
            $this->programmeFormation->add($programmeFormation);
            $programmeFormation->setFormations($this);
        }

        return $this;
    }

    public function removeProgrammeFormation(ProgrammeFormation $programmeFormation): static
    {
        if ($this->programmeFormation->removeElement($programmeFormation)) {
            // set the owning side to null (unless already changed)
            if ($programmeFormation->getFormations() === $this) {
                $programmeFormation->setFormations(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ObjectifFormation>
     */
    public function getObjectifFormation(): Collection
    {
        return $this->objectifFormation;
    }

    public function addObjectifFormation(ObjectifFormation $objectifFormation): static
    {
        if (!$this->objectifFormation->contains($objectifFormation)) {
            $this->objectifFormation->add($objectifFormation);
            $objectifFormation->setFormations($this);
        }

        return $this;
    }

    public function removeObjectifFormation(ObjectifFormation $objectifFormation): static
    {
        if ($this->objectifFormation->removeElement($objectifFormation)) {
            // set the owning side to null (unless already changed)
            if ($objectifFormation->getFormations() === $this) {
                $objectifFormation->setFormations(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIntervenant(): ?string
    {
        return $this->intervenant;
    }

    public function setIntervenant(?string $intervenant): static
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    public function getEvaluation(): ?string
    {
        return $this->evaluation;
    }

    public function setEvaluation(?string $evaluation): static
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getPublicAccesAndCondition(): ?string
    {
        return $this->publicAccesAndCondition;
    }

    public function setPublicAccesAndCondition(?string $publicAccesAndCondition): static
    {
        $this->publicAccesAndCondition = $publicAccesAndCondition;

        return $this;
    }

    public function getProgrammePedagoFile(): ?string
    {
        return $this->programmePedagoFile;
    }

    public function setProgrammePedagoFile(?string $programmePedagoFile): static
    {
        $this->programmePedagoFile = $programmePedagoFile;

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
            $userFrom->addFormationRegistration($this);
        }

        return $this;
    }

    public function removeUserFrom(UserFrom $userFrom): static
    {
        if ($this->userFroms->removeElement($userFrom)) {
            $userFrom->removeFormationRegistration($this);
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
            $formationsUser->setFormations($this);
        }

        return $this;
    }

    public function removeFormationsUser(FormationsUser $formationsUser): static
    {
        if ($this->formationsUsers->removeElement($formationsUser)) {
            // set the owning side to null (unless already changed)
            if ($formationsUser->getFormations() === $this) {
                $formationsUser->setFormations(null);
            }
        }

        return $this;
    }
}
