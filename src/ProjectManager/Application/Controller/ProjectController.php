<?php

declare(strict_types=1);

namespace LetsBeBusy\ProjectManager\Application\Controller;

use LetsBeBusy\ProjectManager\Application\DTO\CreateIssueDTO;
use LetsBeBusy\ProjectManager\Application\DTO\IssuePreviewDTO;
use LetsBeBusy\ProjectManager\Application\DTO\ProjectDTO;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;
use LetsBeBusy\ProjectManager\Domain\Repository\ProjectRepository;
use LetsBeBusy\ProjectManager\Domain\Service\IssueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/project', name: 'app_project')]
class ProjectController extends AbstractController
{

    #[Route('/{id}', name: '_find', methods: ['GET'])]
    public function getProjectById(string $id, ProjectRepository $projectRepository): Response
    {
        $project = $projectRepository->getById(new ProjectId($id));

        if ($project === null) {
            throw $this->createNotFoundException("Project {$id} not found");
        }

        return $this->json(
            ProjectDTO::fromDomain($project)
        );
    }

    #[Route('/{id}/issues', name: '_find_issues', methods: ['GET'])]
    public function getProjectIssuesById(
        string $id,
        ProjectRepository $projectRepository,
        IssueRepository $issueRepository,
    ): Response
    {
        $project = $projectRepository->getById(new ProjectId($id));

        if ($project === null) {
            throw $this->createNotFoundException("Project {$id} not found");
        }

        $issues = $issueRepository->getAllByProject($project->getId());

        return $this->json(
            array_map(function ($i) {
                return IssuePreviewDTO::fromIssue($i);
            }, $issues)
        );
    }

    #[Route('/{id}/create', name: '_create_issue', methods: ['POST'])]
    public function createIssueForProject(
        string $id,
        #[MapRequestPayload] CreateIssueDTO $createIssue,
        IssueService $issueService
    )
    {
        $projectId = new ProjectId($id);
        $issueId = $issueService->create($projectId, $createIssue);

        return $this->json([
            'issueId' => $issueId->getValue()
        ]);
    }
}
