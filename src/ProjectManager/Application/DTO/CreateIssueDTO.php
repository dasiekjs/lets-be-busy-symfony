<?php

namespace LetsBeBusy\ProjectManager\Application\DTO;

use LetsBeBusy\ProjectManager\Domain\ProjectId;

readonly class CreateIssueDTO
{
    public function __construct(
        public string $title,
        public string $content,
        public ProjectId $projectId
    )
    {
    }
}
