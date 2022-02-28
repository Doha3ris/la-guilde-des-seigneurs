<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 40)]
    #[Assert\Length(
        min: 40,
        max: 40,
    )]
    private string $identifier;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 16,
    )]
    #[ORM\Column(type: 'string', length: 50)]
    private string $firstname;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 16,
    )]
    #[ORM\Column(type: 'string', length: 50)]
    private string $lastname;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 255,
    )]
    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $mirian;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $creation;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $modification;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getMirian(): ?int
    {
        return $this->mirian;
    }

    public function setMirian(?int $mirian): self
    {
        $this->mirian = $mirian;

        return $this;
    }

    public function getCreation(): ?\DateTime
    {
        return $this->creation;
    }

    public function setCreation(\DateTime $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getModification(): ?\DateTime
    {
        return $this->modification;
    }

    public function setModification(\DateTime $modification): self
    {
        $this->modification = $modification;

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
