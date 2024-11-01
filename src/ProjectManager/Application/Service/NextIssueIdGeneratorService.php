<?php

namespace LetsBeBusy\ProjectManager\Application\Service;

use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\IssueIdGeneratorInterface;
use LetsBeBusy\ProjectManager\Domain\Model\Project;

class NextIssueIdGeneratorService implements IssueIdGeneratorInterface
{
    public function generate(Project $project): IssueId
    {
        // TODO lock Project object in database
        $issueIdStr = sprintf('%s-%s', $project->getId()->value, $project->getIssuesNum() + 1);
        return new IssueId($issueIdStr);
    }
}
