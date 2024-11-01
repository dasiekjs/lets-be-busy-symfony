<?php

namespace LetsBeBusy\ProjectManager\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use LetsBeBusy\ProjectManager\Infrastructure\Repository\DbalProjectRepository;

#[ORM\Entity(repositoryClass: DbalProjectRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Project
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 8)]
    private string $id;

    #[ORM\Column(type: 'string', length: 64)]
    private string $name;

    #[ORM\Column(type: 'text', length: 255)]
    private string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeInterface $createdAt
    ;
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeInterface $updatedAt;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onUpdate(): void
    {
        if ($this->updatedAt === null) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        $this->updatedAt = $this->updatedAt->modify('now');
    }

}
