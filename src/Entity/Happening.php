<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\HappeningRepository')]
class Happening
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    private $updatedAt;

    #[ORM\Column(type: 'datetime')]
    private $startsAt;

    #[ORM\Column(type: 'datetime')]
    private $endsAt;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'boolean')]
    private $isRegistrationOpen;

    #[ORM\Column(type: 'boolean')]
    private $isPaid;

    #[ORM\ManyToMany(targetEntity: 'App\Entity\Attender', mappedBy: 'email')]
    private $attenders;

    #[ORM\OneToMany(targetEntity: 'App\Entity\Application', mappedBy: 'happening')]
    private $applications;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable;
        $this->updatedAt = new \DateTimeImmutable;
        $this->attenders = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTimeInterface $startsAt): self
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTimeInterface $endsAt): self
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsRegistrationOpen(): ?bool
    {
        return $this->isRegistrationOpen;
    }

    public function setIsRegistrationOpen(bool $isRegistrationOpen): self
    {
        $this->isRegistrationOpen = $isRegistrationOpen;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    /**
     * @return Collection|Attender[]
     */
    public function getAttenders(): Collection
    {
        return $this->attenders;
    }

    public function addAttender(Attender $attender): self
    {
        if (!$this->attenders->contains($attender)) {
            $this->attenders[] = $attender;
            $attender->addPhone($this);
        }

        return $this;
    }

    public function removeAttender(Attender $attender): self
    {
        if ($this->attenders->contains($attender)) {
            $this->attenders->removeElement($attender);
            $attender->removePhone($this);
        }

        return $this;
    }

    public function __toString()
    {
        if(!$this->id) {
            return 'New Happening';
        }

        $name = $this->getTitle() .' |';
        if($this->isRegistrationOpen) {
            $name.= ' open | ' ;
        }

        if( $this->getStartsAt() instanceof \DateTimeInterface
        && $this->getEndsAt() instanceof \DateTimeInterface) {
            $name .= sprintf("%s - %s",
                $this->getStartsAt()->format('d/m/Y'),
                $this->getEndsAt()->format('d/m/Y')
            );
        }

        return $name;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setHappening($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getHappening() === $this) {
                $application->setHappening(null);
            }
        }

        return $this;
    }


    public function exportData()
    {
        return [
            'title' => $this->getTitle(),
            'id' => $this->getId(),
            'starts_at' => $this->getStartsAt(),
            'ends_at' => $this->getEndsAt(),
            'description' => $this->getDescription(),
            'is_registration_open' => $this->isRegistrationOpen(),
            'is_paid' => $this->getIsPaid(),

        ];
    }

    public function isRegistrationOpen(): bool
    {
        return (bool)$this->getIsRegistrationOpen();
    }
}
