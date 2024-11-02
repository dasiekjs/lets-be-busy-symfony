<?php

namespace LetsBeBusy\ProjectManager\Domain;

readonly class WorkingTime
{
    public function __construct(
        private int $value,
    )
    {
    }

    public function getMinutes(): int {
        return $this->value;
    }
}
