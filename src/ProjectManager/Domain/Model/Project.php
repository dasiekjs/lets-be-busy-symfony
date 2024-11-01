<?php

namespace LetsBeBusy\ProjectManager\Domain\Model;

use LetsBeBusy\ProjectManager\Domain\ProjectId;

class Project
{
    private function __construct(
        private readonly ProjectId $id,
        private string $name,
        private int $issuesNum = 0,
        private string | null $description = null
    )
    {
    }

    public function getId(): ProjectId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getIssuesNum(): int
    {
        return $this->issuesNum;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function increaseIssuesNum(): void
    {
        $this->issuesNum++;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public static function create(
        ProjectId $id,
        string $name,
        string $description = null,
        ?int $issuesNum = 0,
    ) {
        // todo: validation
        return new self($id, $name, $issuesNum, $description);
    }
}
