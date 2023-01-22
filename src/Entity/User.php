<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Table(name: '`user`')]
#[ORM\Entity(repositoryClass: 'App\Repository\UserRepository')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [
        'ROLE_ADMIN'
    ];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\OneToMany(targetEntity: 'App\Entity\ApplicationComments', mappedBy: 'createdBy')]
    private $applicationComments;
    private $plainPassword;

    public function __construct()
    {
        $this->applicationComments = new ArrayCollection();
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

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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

    public function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->getRoles());
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setPlainPassword(string $password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
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
     * @return Collection|ApplicationComments[]
     */
    public function getApplicationComments(): Collection
    {
        return $this->applicationComments;
    }

    public function addApplicationComment(ApplicationComments $applicationComment): self
    {
        if (!$this->applicationComments->contains($applicationComment)) {
            $this->applicationComments[] = $applicationComment;
            $applicationComment->setCreatedBy($this);
        }

        return $this;
    }

    public function removeApplicationComment(ApplicationComments $applicationComment): self
    {
        if ($this->applicationComments->contains($applicationComment)) {
            $this->applicationComments->removeElement($applicationComment);
            // set the owning side to null (unless already changed)
            if ($applicationComment->getCreatedBy() === $this) {
                $applicationComment->setCreatedBy(null);
            }
        }

        return $this;
    }
}
