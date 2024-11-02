<?php

namespace LetsBeBusy\ProjectManager\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use LetsBeBusy\ProjectManager\Infrastructure\Repository\DbalIssueRepository;

#[ORM\Entity(repositoryClass: DbalIssueRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Issue
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 16)]
    private string $id;

    #[ORM\Column(type: 'string', length: 128)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeInterface $createdAt;
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: Project::class)]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id', nullable: false)]
    private Project $project;


    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
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
        $this->updatedAt->modify('now');
    }

}
