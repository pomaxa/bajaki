<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\PhoneNumberRepository')]
class PhoneNumber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $phone;

    #[ORM\Column(type: 'string', length: 255)]
    private $normalizedPhone;

    #[ORM\Column(type: 'string', length: 80)]
    private $hash;

    #[ORM\ManyToMany(targetEntity: 'App\Entity\Attender', mappedBy: 'phone')]
    private $attenders;

    public function __construct()
    {
        $this->attenders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        $this->setNormalizedPhone($phone);

        return $this;
    }

    public function getNormalizedPhone(): ?string
    {
        return $this->normalizedPhone;
    }

    public function setNormalizedPhone(string $normalizedPhone): self
    {
        $normalizedPhone = str_replace([' ', '+', '#', '(', ')'], '', $normalizedPhone);
        $this->normalizedPhone  = $normalizedPhone;
        $this->setHash(md5($normalizedPhone)); //todo: move to listener

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

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
        return $this->phone;
    }
}
