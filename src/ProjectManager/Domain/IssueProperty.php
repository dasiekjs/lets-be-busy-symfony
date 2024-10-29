<?php

namespace LetsBeBusy\ProjectManager\Domain;

class IssueProperty
{
    public function __construct(
        public string $name,
        public $value,
    )
    {
    }
}
