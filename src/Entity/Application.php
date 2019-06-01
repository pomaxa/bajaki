<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 */
class Application
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Attender", inversedBy="applications")
     */
    private $attender;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $dietaryRequirements;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $accommodation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $accommodationComments;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $applicationStatus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $transportation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPayed;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $approvedAt;

    public const STATUS_NEW = 'new';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public function __construct()
    {
        $this->attender = new ArrayCollection();
        $this->isPayed = false;
        $this->createdAt = new \DateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Attender[]
     */
    public function getAttender(): Collection
    {
        return $this->attender;
    }

    public function addAttender(Attender $attender): self
    {
        if (!$this->attender->contains($attender)) {
            $this->attender[] = $attender;
        }

        return $this;
    }

    public function removeAttender(Attender $attender): self
    {
        if ($this->attender->contains($attender)) {
            $this->attender->removeElement($attender);
        }

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
}
