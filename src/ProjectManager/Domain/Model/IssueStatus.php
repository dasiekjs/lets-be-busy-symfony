<?php

namespace LetsBeBusy\ProjectManager\Domain\Model;

use LetsBeBusy\ProjectManager\Domain\IssueStatusId;

readonly class IssueStatus
{
    public function __construct(
        public IssueStatusId $id,
        public string $name,
    )
    {
    }
}
