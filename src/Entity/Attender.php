<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttenderRepository")
 */
class Attender
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleNames;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\EmailAddress", inversedBy="attenders")
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PhoneNumber", inversedBy="attenders")
     */
    private $phone;

    /**
     * @ORM\Column(type="integer")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $countryOfLiving;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookLink;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProfileLinks", mappedBy="attender")
     */
    private $profileLinks;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\KnowFrom", inversedBy="attenders")
     */
    private $knowFrom;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $languages = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FieldOfWork", inversedBy="attenders")
     */
    private $fieldOfWork;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jobTitle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $allowToShare;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="attender")
     */
    private $applications;


    public function __construct()
    {
        $this->email = new ArrayCollection();
        $this->phone = new ArrayCollection();
        $this->profileLinks = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleNames(): ?string
    {
        return $this->middleNames;
    }

    public function setMiddleNames(?string $middleNames): self
    {
        $this->middleNames = $middleNames;

        return $this;
    }

    /**
     * @return Collection|EmailAddress[]
     */
    public function getEmail(): Collection
    {
        return $this->email;
    }

    public function addEmail(EmailAddress $email): self
    {
        if (!$this->email->contains($email)) {
            $this->email[] = $email;
        }

        return $this;
    }

    public function removeEmail(EmailAddress $email): self
    {
        if ($this->email->contains($email)) {
            $this->email->removeElement($email);
        }

        return $this;
    }

    /**
     * @return Collection|PhoneNumber[]
     */
    public function getPhone(): Collection
    {
        return $this->phone;
    }

    public function addPhone(PhoneNumber $phone): self
    {
        if (!$this->phone->contains($phone)) {
            $this->phone[] = $phone;
        }

        return $this;
    }

    public function removePhone(PhoneNumber $phone): self
    {
        if ($this->phone->contains($phone)) {
            $this->phone->removeElement($phone);
        }

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCountryOfLiving(): ?string
    {
        return $this->countryOfLiving;
    }

    public function setCountryOfLiving(?string $countryOfLiving): self
    {
        $this->countryOfLiving = $countryOfLiving;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getFacebookLink(): ?string
    {
        return $this->facebookLink;
    }

    public function setFacebookLink(?string $facebookLink): self
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    /**
     * @return Collection|ProfileLinks[]
     */
    public function getProfileLinks(): Collection
    {
        return $this->profileLinks;
    }

    public function addProfileLink(ProfileLinks $profileLink): self
    {
        if (!$this->profileLinks->contains($profileLink)) {
            $this->profileLinks[] = $profileLink;
            $profileLink->setAttender($this);
        }

        return $this;
    }

    public function removeProfileLink(ProfileLinks $profileLink): self
    {
        if ($this->profileLinks->contains($profileLink)) {
            $this->profileLinks->removeElement($profileLink);
            // set the owning side to null (unless already changed)
            if ($profileLink->getAttender() === $this) {
                $profileLink->setAttender(null);
            }
        }

        return $this;
    }

    public function getKnowFrom(): ?KnowFrom
    {
        return $this->knowFrom;
    }

    public function setKnowFrom(?KnowFrom $knowFrom): self
    {
        $this->knowFrom = $knowFrom;

        return $this;
    }

    public function getLanguages(): ?array
    {
        return $this->languages;
    }

    public function setLanguages(?array $languages): self
    {
        $this->languages = $languages;

        return $this;
    }

    public function getFieldOfWork(): ?FieldOfWork
    {
        return $this->fieldOfWork;
    }

    public function setFieldOfWork(?FieldOfWork $fieldOfWork): self
    {
        $this->fieldOfWork = $fieldOfWork;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getAllowToShare(): ?bool
    {
        return $this->allowToShare;
    }

    public function setAllowToShare(bool $allowToShare): self
    {
        $this->allowToShare = $allowToShare;

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $motivation): self
    {
        if (!$this->applications->contains($motivation)) {
            $this->applications[] = $motivation;
            $motivation->addAttender($this);
        }

        return $this;
    }

    public function removeMotivation(Application $motivation): self
    {
        if ($this->applications->contains($motivation)) {
            $this->applications->removeElement($motivation);
            $motivation->removeAttender($this);
        }

        return $this;
    }

    public function __toString()
    {
        return '#'.$this->id . ': '. $this->getFirstName() .' '.$this->getLastName();
    }
}
