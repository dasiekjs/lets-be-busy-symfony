<?php

namespace LetsBeBusy\ProjectManager\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
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

    #[ORM\Column(type: 'date_immutable')]
    private \DateTimeInterface $createdAt
    ;
    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeInterface $updatedAt;

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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
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
        $this->updatedAt->modify('now');
    }

}
