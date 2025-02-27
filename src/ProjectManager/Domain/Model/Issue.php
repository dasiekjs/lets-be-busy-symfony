<?php

namespace LetsBeBusy\ProjectManager\Domain\Model;

use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\ProjectId;

class Issue
{
    public function __construct(
        private readonly IssueId $id,
        private ProjectId $projectId,
        private string $title,
        private IssueStatus $issueStatus,
        private string | null $content,
        private \DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt = null,
    )
    { }

    public function getId(): IssueId
    {
        return $this->id;
    }

    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getIssueStatus(): IssueStatus
    {
        return $this->issueStatus;
    }

    public function setIssueStatus(IssueStatus $issueStatus): void
    {
        $this->issueStatus = $issueStatus;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
