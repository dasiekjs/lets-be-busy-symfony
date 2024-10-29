<?php

namespace LetsBeBusy\ProjectManager\Domain\Repository;

use LetsBeBusy\ProjectManager\Domain\Model\Project;
use LetsBeBusy\ProjectManager\Domain\ProjectId;

interface ProjectRepository
{
    public function save(Project $project);

    public function getById(ProjectId $id): ?Project;

    public function getAll(): array;
}
