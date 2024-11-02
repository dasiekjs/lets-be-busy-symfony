<?php

namespace LetsBeBusy\ProjectManager\Domain;

readonly class Comment
{
    public function __construct(
        private string $value
    )
    {
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
