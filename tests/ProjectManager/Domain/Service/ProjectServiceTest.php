<?php

namespace Tests\LetsBeBusy\ProjectManager\Domain\Service;

use LetsBeBusy\ProjectManager\Application\DTO\CreateProjectDTO;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Service\ProjectService;
use PHPUnit\Framework\TestCase;
use Tests\LetsBeBusy\ProjectManager\Doubles\InMemoryProjectRepository;

class ProjectServiceTest extends TestCase
{
    public function test_shouldCreateProject()
    {
        $inMemoryProjectRepository = new InMemoryProjectRepository();

        $projectService = new ProjectService($inMemoryProjectRepository);

        $createProjectDTO = new CreateProjectDTO(
            'In Memory Project',
            'Example project in memory'
        );

        $projectId = new ProjectId('INMEMPROJ');

        $projectService->create($createProjectDTO, $projectId);

        $newProject = $inMemoryProjectRepository->getById($projectId);

        $this->assertEquals($projectId, $newProject->getId(), 'New Project should have ID INMEMPROJ');
        $this->assertEquals('In Memory Project', $newProject->getName(), 'Name of new project should be In Memory Project');
        $this->assertEquals('Example project in memory', $newProject->getDescription(), 'Description of new project should be Example project in memory');
    }
    public function test_shouldCreateProjectWithoutDescription()
    {
        $inMemoryProjectRepository = new InMemoryProjectRepository();

        $projectService = new ProjectService($inMemoryProjectRepository);

        $createProjectDTO = new CreateProjectDTO(
            'In Memory Project',
        );

        $projectId = new ProjectId('INMEMPROJ');

        $projectService->create($createProjectDTO, $projectId);

        $newProject = $inMemoryProjectRepository->getById($projectId);

        $this->assertEquals($projectId, $newProject->getId());
        $this->assertEquals('In Memory Project', $newProject->getName());
        $this->assertNull($newProject->getDescription());
    }
}
