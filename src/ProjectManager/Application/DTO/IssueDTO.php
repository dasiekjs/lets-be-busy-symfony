<?php

namespace LetsBeBusy\ProjectManager\Application\DTO;

use LetsBeBusy\ProjectManager\Domain\Model\Issue;

readonly class IssueDTO {

    public function __construct(
        public string $id,
        public string $title,
        public string $content,
        public string $createdAt,
    )
    {
    }

    public static function fromDomain(Issue $issue): self {
        return new self(
            $issue->getId()->getValue(),
            $issue->getTitle(),
            $issue->getContent(),
            $issue->getCreatedAt()->format(DATE_ATOM),
        );
    }
}
