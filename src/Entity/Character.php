<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: "characters")]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 40, name: "gls_identifier")]
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
    #[ORM\Column(type: 'string', length: 16, name: "gls_kind")]
    private string $kind;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 16,
    )]
    #[ORM\Column(type: 'string', length: 16, name: "gls_name")]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 64,
    )]
    #[ORM\Column(type: 'string', length: 64, name: "gls_surname")]
    private string $surname;

    #[Assert\Length(
        min: 3,
        max: 16,
    )]
    #[ORM\Column(type: 'string', length: 16, nullable: true, name: "gls_caste")]
    private ?string $caste = null;

    #[Assert\Length(
        min: 3,
        max: 16,
    )]
    #[ORM\Column(type: 'string', length: 16, nullable: true, name: "gls_knowledge")]
    private ?string $knowledge = null;

    #[ORM\Column(type: 'integer', nullable: true, name: "gls_intelligence")]
    private ?int $intelligence = null;

    #[ORM\Column(type: 'integer', nullable: true, name: "gls_life")]
    private ?int $life = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 128,
    )]
    #[ORM\Column(type: 'string', length: 128, nullable: true, name: "gls_image")]
    private ?string $image = null;

    #[ORM\Column(type: 'datetime', name: "gls_creation")]
    private \DateTime $creation;

    #[ORM\Column(type: 'datetime', name: "gls_modification")]
    private \DateTime $modification;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'characters')]
    private $player;

    public function getId(): int
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

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
