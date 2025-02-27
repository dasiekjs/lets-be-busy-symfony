<?php

declare(strict_types=1);

namespace LetsBeBusy\ProjectManager\Application\Controller;

use LetsBeBusy\ProjectManager\Application\DTO\IssueDTO;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;
use LetsBeBusy\ProjectManager\Infrastructure\Repository\DbalIssueRepository;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/issue', name: 'app_issue')]
#[OA\Tag(name: 'Issue', description: 'Manage Issues')]
class IssueController extends AbstractController
{

    #[Route('/{id}', name: '_issue_show', methods: ['GET'])]
    #[OA\Get(
        description: 'Get a single issue',
        summary: 'Get a single issue',
    )]
    #[OA\Response(
        response: 200,
        description: 'Return selected Issue',
        content: new Model(type: IssueDTO::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Issue not found'
    )]
    public function getIssueById(
        string $id,
        DbalIssueRepository $issueRepository,
    ): Response
    {
        $issue = $issueRepository->findOneBy([
            'id' => $id
        ]);
        if ($issue === null) {
            throw $this->createNotFoundException("Issue with id {$id} not found");
        }

        return $this->json(
            IssueDTO::from($issue)
        );
    }
}
