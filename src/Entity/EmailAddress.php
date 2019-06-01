<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailAddressRepository")
 */
class EmailAddress
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailCanonical;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $hash;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Attender", mappedBy="email")
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        $this->createCanonicalForm($email);
        $this->recalculateHash();

        return $this;
    }

    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    public function setEmailCanonical(string $emailCanonical): self
    {
        $this->emailCanonical = $emailCanonical;

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
            $attender->addEmail($this);
        }

        return $this;
    }

    public function removeAttender(Attender $attender): self
    {
        if ($this->attenders->contains($attender)) {
            $this->attenders->removeElement($attender);
            $attender->removeEmail($this);
        }

        return $this;
    }

    private function createCanonicalForm(string $email)
    {
        $email = trim($email);
        $email = strtolower($email);
        $this->setEmailCanonical($email);
    }

    private function recalculateHash()
    {
        $hash = sha1($this->getEmailCanonical());
        $this->setHash($hash);
    }
}
