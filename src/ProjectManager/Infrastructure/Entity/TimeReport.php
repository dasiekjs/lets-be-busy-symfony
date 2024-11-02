<?php

namespace LetsBeBusy\ProjectManager\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class TimeReport
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private string $id;

    #[ORM\Column(type: 'integer')]
    private int $workingTime;

    #[ORM\Column(type: 'text')]
    private string $comment;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeInterface $createdAt;
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: Issue::class)]
    #[ORM\JoinColumn(name: 'issue_id', referencedColumnName: 'id', nullable: false)]
    private Issue $issue;

    public function getId(): string
    {
        return $this->id;
    }

    public function getWorkingTime(): int
    {
        return $this->workingTime;
    }

    public function setWorkingTime(int $workingTime): self
    {
        $this->workingTime = $workingTime;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getIssue(): Issue
    {
        return $this->issue;
    }

    public function setIssue(Issue $issue): self
    {
        $this->issue = $issue;
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
