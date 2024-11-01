<?php

namespace LetsBeBusy\ProjectManager\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LetsBeBusy\ProjectManager\Domain\Factory\IssueFactory;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Model\Issue as DomainIssue;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;
use LetsBeBusy\ProjectManager\Infrastructure\Entity\Issue;

use LetsBeBusy\ProjectManager\Infrastructure\Entity\Project;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DbalIssueRepository extends ServiceEntityRepository implements IssueRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Issue::class);
    }

    public function save(DomainIssue $issue): void
    {
        $project = $this->getEntityManager()
            ->getRepository(Project::class)
            ->find($issue->getProjectId()->value);

        $issue = (new Issue($issue->getId()->getValue()))
            ->setTitle($issue->getTitle())
            ->setContent($issue->getContent())
            ->setProject($project)
        ;

        $this->getEntityManager()->persist($issue);
        $this->getEntityManager()->flush();
    }

    public function getById(IssueId $id): ?DomainIssue
    {
        $issue = $this->findOneBy([
            'id' => $id->getValue(),
        ]);

        if (null === $issue) {
            return null;
        }

        return IssueFactory::create(
            new IssueId($issue->getId()),
            new ProjectId($issue->getProject()->getId()),
            $issue->getTitle(),
            $issue->getContent(),
        );
    }

    public function getAllByProject(ProjectId $projectId): array
    {

        $projectIdValue = $projectId->value;

        $project = $this->getEntityManager()
            ->getRepository(Project::class)
            ->find($projectIdValue);

        if (null === $project) {
            throw new NotFoundHttpException("Project {$projectIdValue} not found");
        }

        $issues = $this->findBy([
            'project' => $project,
        ], ['createdAt' => 'DESC']);

        return array_map(function (Issue $issue) {
            return IssueFactory::create(
                new IssueId($issue->getId()),
                new ProjectId($issue->getProject()->getId()),
                $issue->getTitle(),
                $issue->getContent()
            );
        }, $issues);
    }
}
