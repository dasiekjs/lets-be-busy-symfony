<?php

namespace LetsBeBusy\ProjectManager\Domain\Service;

use LetsBeBusy\ProjectManager\Application\DTO\CreateIssueDTO;
use LetsBeBusy\ProjectManager\Domain\Exception\ProjectNotFoundException;
use LetsBeBusy\ProjectManager\Domain\Factory\IssueFactory;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;
use LetsBeBusy\ProjectManager\Domain\Repository\ProjectRepository;

class IssueService
{
    public function __construct(
        private readonly IssueRepository $issueRepository,
        private readonly ProjectRepository $projectRepository,
    )
    {
    }

    public function create(CreateIssueDTO $createIssueDTO, IssueId $issueId): void
    {
        $selectedProject = $this->projectRepository->getById($createIssueDTO->projectId);

        if ($selectedProject === null) {
            throw new ProjectNotFoundException("Project with id {$createIssueDTO->projectId->value} not found");
        }

        $issue = IssueFactory::create(
            id: $issueId,
            project: $selectedProject->getId(),
            title: $createIssueDTO->title,
            content: $createIssueDTO->content,
        );

        $this->issueRepository->save($issue);
    }
}
