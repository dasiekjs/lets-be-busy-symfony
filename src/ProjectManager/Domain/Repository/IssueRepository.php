<?php

namespace LetsBeBusy\ProjectManager\Domain\Repository;

use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Model\Issue;
use LetsBeBusy\ProjectManager\Domain\ProjectId;

interface IssueRepository
{
    public function save(Issue $issue);

    public function getById(IssueId $id): ?Issue;

    public function getAllByProject(ProjectId $projectId): array;
}
