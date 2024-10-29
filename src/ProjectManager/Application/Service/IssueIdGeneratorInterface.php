<?php

namespace LetsBeBusy\ProjectManager\Application\Service;

use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Model\Project;

interface IssueIdGeneratorInterface
{
    public function generate(Project $project): IssueId;
}
