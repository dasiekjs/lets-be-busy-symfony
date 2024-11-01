<?php

namespace LetsBeBusy\ProjectManager\Domain;

use LetsBeBusy\ProjectManager\Domain\Model\Project;

interface IssueIdGeneratorInterface
{
    public function generate(Project $project): IssueId;
}
