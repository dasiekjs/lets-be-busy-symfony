<?php

namespace LetsBeBusy\ProjectManager\Application\DTO;

readonly class CreateProjectDTO
{
    public function __construct(
        public string $name,
        public ?string $description = null
    )
    {
    }
}
