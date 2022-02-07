<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id = 1;

    #[ORM\Column(type: 'string', length: 16)]
    private string $kind;

    #[ORM\Column(type: 'string', length: 16)]
    private string $name = "Eldalote";

    #[ORM\Column(type: 'string', length: 64)]
    private string $surname = "Fleur elfique";

    #[ORM\Column(type: 'string', length: 16, nullable: true)]
    private ?string $caste = "Elfe";

    #[ORM\Column(type: 'string', length: 16, nullable: true)]
    private ?string $knowledge = "Arts";

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $intelligence = 120;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $life = 12;

    #[ORM\Column(type: 'string', length: 128, nullable: true)]
    private ?string $image = "https://www.fete-en-folie.fr/272553-large_default/perruque-elfe.jpg";

    #[ORM\Column(type: 'datetime')]
    private DateTime $creation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKind(): ?string
    {
        return $this->kind;
    }

    public function setKind(string $kind): self
    {
        $this->kind = $kind;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCaste(): ?string
    {
        return $this->caste;
    }

    public function setCaste(?string $caste): self
    {
        $this->caste = $caste;

        return $this;
    }

    public function getKnowledge(): ?string
    {
        return $this->knowledge;
    }

    public function setKnowledge(?string $knowledge): self
    {
        $this->knowledge = $knowledge;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(?int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getLife(): ?int
    {
        return $this->life;
    }

    public function setLife(?int $life): self
    {
        $this->life = $life;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function getCreation(): ?DateTime
    {
        return $this->creation;
    }

    public function setCreation(DateTime $creation): self
    {
        $this->creation = $creation;

        return $this;
    }
}
