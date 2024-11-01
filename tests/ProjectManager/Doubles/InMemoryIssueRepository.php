<?php

namespace Tests\LetsBeBusy\ProjectManager\Doubles;

use LetsBeBusy\ProjectManager\Domain\Exception\InvalidIssueException;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\IssueIdGeneratorInterface;
use LetsBeBusy\ProjectManager\Domain\Model\Issue;
use LetsBeBusy\ProjectManager\Domain\Model\Project;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;

class InMemoryIssueRepository implements IssueRepository
{
    private $issues = [ ];

    public function __construct()
    {
        $this->issues['INMEM-1'] = new Issue(
            id: new IssueId('INMEM-1'),
            projectId: new ProjectId('INMEM'),
            title: 'In memory issue 1',
            content: 'content',
            createdAt: new \DateTimeImmutable(),
            updatedAt: null
        );
    }

    public function save(Issue $issue)
    {
        if (array_key_exists($issue->getId()->getValue(), $this->issues)) {
            throw new InvalidIssueException(
                sprintf('Issue with id "%s" already exists', $issue->getId()->getValue()),
            );
        }

        $this->issues[$issue->getId()->getValue()] = $issue;
    }

    public function getById(IssueId $id): ?Issue
    {
        return $this->issues[$id->getValue()] ?? null;
    }

    public function getAllByProject(ProjectId $projectId): array
    {
       return array_filter($this->issues, function (Issue $issue) use ($projectId) {
           return $issue->getProjectId()->value == $projectId->value;
       });
    }

}
