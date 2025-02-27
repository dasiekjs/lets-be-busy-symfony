<?php

namespace LetsBeBusy\ProjectManager\Application\DTO;

use LetsBeBusy\ProjectManager\Domain\Model\Project as DomainProject;

readonly class ProjectDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
    )
    {
    }

    public static function fromDomain(DomainProject $data): self
    {
        return new self(
            $data->getId()->value,
            $data->getName(),
            $data->getDescription()
        );
    }

    public static function fromArray(array $data): array
    {
        return array_map(function ($value) {
            return self::fromDomain($value);
        }, $data);
    }
}
