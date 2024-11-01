<?php

namespace LetsBeBusy\ProjectManager\Domain\Service;

use LetsBeBusy\ProjectManager\Application\DTO\CreateIssueDTO;
use LetsBeBusy\ProjectManager\Domain\Exception\ProjectNotFoundException;
use LetsBeBusy\ProjectManager\Domain\Factory\IssueFactory;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\IssueIdGeneratorInterface;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;
use LetsBeBusy\ProjectManager\Domain\Repository\ProjectRepository;

readonly class IssueService
{
    public function __construct(
        private IssueRepository $issueRepository,
        private ProjectRepository $projectRepository,
        private IssueIdGeneratorInterface $issueIdGenerator
    )
    {
    }

    public function create(
        ProjectId $projectId,
        CreateIssueDTO $createIssueDTO
    ): IssueId
    {
        $selectedProject = $this->projectRepository->getById($projectId);

        if ($selectedProject === null) {
            throw new ProjectNotFoundException("Project with id {$projectId->value} not found");
        }

        $issueId = $this->issueIdGenerator->generate($selectedProject);

        $issue = IssueFactory::create(
            id: $issueId,
            project: $selectedProject->getId(),
            title: $createIssueDTO->title,
            content: $createIssueDTO->content,
        );

        $this->issueRepository->save($issue);

        $selectedProject->increaseIssuesNum();
        $this->projectRepository->update($selectedProject);

        return $issueId;
    }
}
