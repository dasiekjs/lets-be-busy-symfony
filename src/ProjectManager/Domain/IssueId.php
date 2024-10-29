<?php

namespace LetsBeBusy\ProjectManager\Domain;

readonly class IssueId
{
    public function __construct(
        private string $value
    )
    {
    }

    public function getValue(): string {
        return $this->value;
    }
}
