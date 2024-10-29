<?php

namespace LetsBeBusy\ProjectManager\Domain\Service;

use LetsBeBusy\ProjectManager\Application\DTO\CreateProjectDTO;
use LetsBeBusy\ProjectManager\Domain\Exception\ProjectNotFoundException;
use LetsBeBusy\ProjectManager\Domain\Model\Project;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\ProjectRepository;

class ProjectService
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    )
    {
    }

    public function create(CreateProjectDTO $createProjectDTO, ProjectId $projectId): void
    {
        $selectedProject = $this->projectRepository->getById($projectId);

        if ($selectedProject !== null) {
            throw new ProjectNotFoundException("Project with id {$projectId->value} already exist");
        }

        $project = Project::create(
            id: $projectId,
            name: $createProjectDTO->name,
            description: $createProjectDTO->description,
        );

        $this->projectRepository->save($project);
    }
}
