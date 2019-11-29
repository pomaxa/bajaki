<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttenderCompanyRepository")
 */
class AttenderCompany
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyNameCanonical;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Attender", mappedBy="company")
     */
    private $attenders;

    public function __construct()
    {
        $this->attenders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCompanyNameCanonical(): ?string
    {
        return $this->companyNameCanonical;
    }

    public function setCompanyNameCanonical(?string $companyNameCanonical): self
    {
        $this->companyNameCanonical = $companyNameCanonical;

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
            $attender->setCompany($this);
        }

        return $this;
    }

    public function removeAttender(Attender $attender): self
    {
        if ($this->attenders->contains($attender)) {
            $this->attenders->removeElement($attender);
            // set the owning side to null (unless already changed)
            if ($attender->getCompany() === $this) {
                $attender->setCompany(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id ? (string)$this->getCompanyName() : ' new ';
    }
}
