<?php

namespace LetsBeBusy\ProjectManager\Domain\Factory;

use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Model\Issue;
use LetsBeBusy\ProjectManager\Domain\ProjectId;

class IssueFactory
{
    /**
     * Create new Issue based on information
     * @param IssueId $id
     * @param ProjectId $project
     * @param string $title
     * @param string $content
     * @return Issue
     */
    public static function create(
        IssueId   $id,
        ProjectId $project,
        string    $title,
        ?string   $content = null
    )
    {
        // todo validation!
        return new Issue(
            id: $id,
            projectId: $project,
            title: $title,
            content: $content ?? null,
            createdAt: new \DateTimeImmutable(),
        );
    }
}
