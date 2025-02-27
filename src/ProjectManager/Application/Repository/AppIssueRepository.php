<?php

namespace LetsBeBusy\ProjectManager\Application\Repository;

use LetsBeBusy\ProjectManager\Domain\ProjectId;

interface AppIssueRepository
{
    public function findIssuesByProjectId(ProjectId $projectId, int $page = 1, int $perPage = 10, $filters = null): array;
}
