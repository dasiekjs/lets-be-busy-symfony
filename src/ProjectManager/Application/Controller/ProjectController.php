<?php

declare(strict_types=1);

namespace LetsBeBusy\ProjectManager\Application\Controller;

use LetsBeBusy\ProjectManager\Application\DTO\CreateIssueDTO;
use LetsBeBusy\ProjectManager\Application\DTO\IssueDTO;
use LetsBeBusy\ProjectManager\Application\DTO\IssuePreviewDTO;
use LetsBeBusy\ProjectManager\Application\DTO\PaginatedDataDTO;
use LetsBeBusy\ProjectManager\Application\DTO\ProjectDTO;
use LetsBeBusy\ProjectManager\Application\Repository\AppIssueRepository;
use LetsBeBusy\ProjectManager\Infrastructure\Entity\Issue;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\ProjectRepository;
use LetsBeBusy\ProjectManager\Domain\Service\IssueService;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/project', name: 'app_project')]
#[OA\Tag(name: 'Projects', description: 'Manage Projects')]
class ProjectController extends AbstractController
{

    #[Route( name: '_find_all', methods: ['GET'])]
    #[OA\Get(
        description: 'Find from all projects',
        summary: 'Find from all projects',
    )]
    #[OA\Response(
        response: 200,
        description: 'Return selected Project',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ProjectDTO::class))
        )
    )]
    public function findAll(ProjectRepository $projectRepository): Response
    {
        $project = $projectRepository->getAll();

        return $this->json([
            'data' => ProjectDTO::fromArray($project),
            // TODO add pagination data?
        ]);
    }

    #[Route('/{id}', name: '_find_one', methods: ['GET'])]
    #[OA\Get(
        description: 'Get a single project',
        summary: 'Get a single project',
    )]
    #[OA\Response(
        response: 200,
        description: 'Return selected Project',
        content: new Model(type: ProjectDTO::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Project not found'
    )]
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
    #[OA\Get(
        description: 'Return all issues for project',
        summary: 'Get all issues for project',
    )]
    #[OA\Response(
        response: 200,
        description: 'Return issues for selected Project',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: IssuePreviewDTO::class))
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Project not found'
    )]
    public function getProjectIssuesById(
        string $id,
        Request $request,
        ProjectRepository $projectRepository,
        AppIssueRepository $appIssueRepository,
    ): Response
    {
        // TODO Move this into parameter resolver
        $project = $projectRepository->getById(new ProjectId($id));

        if ($project === null) {
            throw $this->createNotFoundException("Project {$id} not found");
        }

        $page = $request->query->getInt('page', 1);
        $perPage = $request->query->getInt('perPage', 10);
        $issuesPaginated = $appIssueRepository->findIssuesByProjectId(
            $project->getId(),
            $page,
            $perPage
        );

        $response = new PaginatedDataDTO(
            array_map(function (Issue $issue) {
                return IssueDTO::from($issue);
            }, $issuesPaginated['data']),
            $issuesPaginated['total'],
            $issuesPaginated['currentPage'],
            $issuesPaginated['perPage']
        );

        return $this->json($response);
    }

    #[Route('/{id}/create', name: '_create_issue', methods: ['POST'])]
    #[OA\Post(
        description: 'Create a new issue for project',
        summary: 'Create a new issue for project',
    )]
    #[OA\Response(
        response: 200,
        description: 'Issue was created',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'issueId', title: 'Issue ID'),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Project not found'
    )]
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
