<?php

namespace Tests\LetsBeBusy\ProjectManager\Doubles;

use LetsBeBusy\ProjectManager\Domain\Exception\InvalidProjectException;
use LetsBeBusy\ProjectManager\Domain\Model\Project;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\ProjectRepository;

class InMemoryProjectRepository implements ProjectRepository
{
    private $projects = [ ];

    public function __construct()
    {
        $this->projects['INMEM'] = Project::create(
            new ProjectId('INMEM'),
            'InMemoryProject',
        );
    }

    public function save(Project $project)
    {
        if (array_key_exists($project->getId()->value, $this->projects)) {
            throw new InvalidProjectException(
                sprintf('Project with id "%s" already exists', $project->getId()->value),
            );
        }

        $this->projects[$project->getId()->value] = $project;
    }

    public function getById(ProjectId $id): ?Project
    {
        return $this->projects[$id->value] ?? null;
    }

    public function getAll(): array
    {
       return array_values($this->projects);
    }

}
