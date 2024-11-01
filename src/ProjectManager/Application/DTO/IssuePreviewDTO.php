<?php

namespace LetsBeBusy\ProjectManager\Application\DTO;

use LetsBeBusy\ProjectManager\Domain\Model\Issue;

readonly class IssuePreviewDTO
{
    public function __construct(
        public string $id,
        public string $title,
        public string $createdAt,
    )
    {
    }

    public static function fromIssue(Issue $issue): self {
        return new self(
            $issue->getId()->getValue(),
            $issue->getTitle(),
            $issue->getCreatedAt()->format(\DateTime::ATOM),
        );
    }
}
