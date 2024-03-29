<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\ApplicationRepository')]
#[ORM\HasLifecycleCallbacks]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Attender', inversedBy: 'applications', cascade: ['persist'])]
    private $attender;

    #[ORM\Column(type: 'text', nullable: true)]
    private $dietaryRequirements;

    #[ORM\Column(type: 'text', nullable: true)]
    private $accommodation;

    #[ORM\Column(type: 'text', nullable: true)]
    private $accommodationComments;

    #[ORM\Column(type: 'string', length: 255)]
    private $applicationStatus;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $transportation;

    #[ORM\Column(type: 'boolean')]
    private $isPayed;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $approvedAt;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Happening', inversedBy: 'applications')]
    private $happening;

    #[ORM\OneToMany(targetEntity: 'App\Entity\ApplicationComments', mappedBy: 'application', cascade: ['persist'])]
    private $comments;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dayOfArrival = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $wantToSupport = null;

    public const STATUS_NEW = 'new';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public function __construct()
    {
        $this->isPayed = false;
        $this->applicationStatus = self::STATUS_NEW;
        $this->createdAt = new \DateTime;
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttender(): ?Attender
    {
        return $this->attender;
    }

    public function setAttender(?Attender $attender): self
    {
        $this->attender = $attender;

        return $this;
    }


    public function getDietaryRequirements(): ?string
    {
        return $this->dietaryRequirements;
    }

    public function setDietaryRequirements(?string $dietaryRequirements): self
    {
        $this->dietaryRequirements = $dietaryRequirements;

        return $this;
    }

    public function getAccommodation(): ?string
    {
        return $this->accommodation;
    }

    public function setAccommodation(?string $accommodation): self
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    public function getAccommodationComments(): ?string
    {
        return $this->accommodationComments;
    }

    public function setAccommodationComments(?string $accommodationComments): self
    {
        $this->accommodationComments = $accommodationComments;

        return $this;
    }

    public function getApplicationStatus(): ?string
    {
        return $this->applicationStatus;
    }

    public function setApplicationStatus(string $applicationStatus): self
    {
        $this->applicationStatus = $applicationStatus;

        return $this;
    }

    public function getTransportation(): ?string
    {
        return $this->transportation;
    }

    public function setTransportation(?string $transportation): self
    {
        $this->transportation = $transportation;

        return $this;
    }

    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): self
    {
        $this->isPayed = $isPayed;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getApprovedAt(): ?\DateTimeInterface
    {
        return $this->approvedAt;
    }

    public function setApprovedAt(?\DateTimeInterface $approvedAt): self
    {
        $this->approvedAt = $approvedAt;

        return $this;
    }

    public function getHappening(): ?Happening
    {
        return $this->happening;
    }

    public function setHappening(?Happening $happening): self
    {
        $this->happening = $happening;

        return $this;
    }

    public function __toString()
    {
        if(null === $this->happening) {
            return 'unbinded application';
        }
        return 'Application for '.$this->getHappening();
    }

    #[ORM\PreUpdate]
    public function trackUpdateAt(): void
    {
        $this->setUpdatedAt(new \DateTime());
    }

    public function isPayed()
    {
        return (bool)$this->isPayed;
    }

    /**
     * @return Collection|ApplicationComments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(ApplicationComments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setApplication($this);
        }

        return $this;
    }

    public function removeComment(ApplicationComments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getApplication() === $this) {
                $comment->setApplication(null);
            }
        }

        return $this;
    }

    public function getDayOfArrival(): ?string
    {
        return $this->dayOfArrival;
    }

    public function setDayOfArrival(?string $dayOfArrival): self
    {
        $this->dayOfArrival = $dayOfArrival;

        return $this;
    }

    public function getWantToSupport(): ?string
    {
        return $this->wantToSupport;
    }

    public function setWantToSupport(?string $wantToSupport): self
    {
        $this->wantToSupport = $wantToSupport;

        return $this;
    }
}
