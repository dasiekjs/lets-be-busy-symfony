<?php

declare(strict_types=1);

namespace LetsBeBusy\ProjectManager\Application\Controller;

use LetsBeBusy\ProjectManager\Application\DTO\IssueDTO;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/issue', name: 'app_issue')]
class IssueController extends AbstractController
{
    public function __construct(
        private readonly IssueRepository $issueRepository,
    )
    {
    }

    #[Route('/{id}', name: '_issue_show', methods: ['GET'])]
    public function getIssueById(string $id): Response
    {
        $issue = $this->issueRepository->getById(new IssueId($id));
        if ($issue === null) {
            throw $this->createNotFoundException("Issue with id {$id} not found");
        }

        return $this->json(
            IssueDTO::fromDomain($issue)
        );
    }
}
