<?php

namespace LetsBeBusy\ProjectManager\Application\DTO;

use LetsBeBusy\ProjectManager\Infrastructure\Entity\Issue;

readonly class IssueDTO {

    public function __construct(
        public string $id,
        public string $title,
        public string $content,
        public string $createdAt,
        public ProjectDTO $project,
    )
    {
    }

    public static function from(Issue $issue): self {
        return new self(
            $issue->getId(),
            $issue->getTitle(),
            $issue->getContent(),
            $issue->getCreatedAt()->format(DATE_ATOM),
            new ProjectDTO($issue->getProject()->getId(), $issue->getProject()->getName(), $issue->getProject()->getDescription())
        );
    }
}
