<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Friend
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column()]
    private string $userName;

    #[ORM\Column(type: 'float')]
    private float $kilometrage = 0;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'friends')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKilometrage(): ?float
    {
        return $this->kilometrage;
    }

    public function setKilometrage(float $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }
}
