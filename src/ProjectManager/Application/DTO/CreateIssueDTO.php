<?php

namespace LetsBeBusy\ProjectManager\Application\DTO;

readonly class CreateIssueDTO
{
    public function __construct(
        public string $title,
        public string $content
    )
    {
    }
}
