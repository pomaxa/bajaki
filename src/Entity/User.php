<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ApplicationComments", mappedBy="createdBy")
     */
    private $applicationComments;

    public function __construct()
    {
        parent::__construct();
        $this->applicationComments = new ArrayCollection();
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
