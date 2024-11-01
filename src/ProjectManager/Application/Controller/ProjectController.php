<?php

declare(strict_types=1);

namespace LetsBeBusy\ProjectManager\Application\Controller;

use LetsBeBusy\ProjectManager\Application\DTO\IssuePreviewDTO;
use LetsBeBusy\ProjectManager\Application\DTO\ProjectDTO;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;
use LetsBeBusy\ProjectManager\Domain\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/project', name: 'app_project')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
        private readonly IssueRepository $issueRepository
    )
    {
    }

    #[Route('/{id}', name: '_find', methods: ['GET'])]
    public function getProjectById(string $id): Response
    {
        $project = $this->projectRepository->getById(new ProjectId($id));

        if ($project === null) {
            throw $this->createNotFoundException("Project {$id} not found");
        }

        return $this->json(
            ProjectDTO::fromDomain($project)
        );
    }

    #[Route('/{id}/issues', name: '_find_issues', methods: ['GET'])]
    public function getProjectIssuesById(string $id): Response
    {
        $project = $this->projectRepository->getById(new ProjectId($id));

        if ($project === null) {
            throw $this->createNotFoundException("Project {$id} not found");
        }

        $issues = $this->issueRepository->getAllByProject($project->getId());

        return $this->json(
            array_map(function ($i) {
                return IssuePreviewDTO::fromIssue($i);
            }, $issues)
        );
    }
}
