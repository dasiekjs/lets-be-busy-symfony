<?php

namespace LetsBeBusy\ProjectManager\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use LetsBeBusy\ProjectManager\Application\Repository\AppIssueRepository;
use LetsBeBusy\ProjectManager\Domain\Factory\IssueFactory;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Model\Issue as DomainIssue;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\IssueRepository;
use LetsBeBusy\ProjectManager\Infrastructure\Entity\Issue;

use LetsBeBusy\ProjectManager\Infrastructure\Entity\Project;

class DbalIssueRepository extends ServiceEntityRepository implements IssueRepository, AppIssueRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Issue::class);
    }

    public function save(DomainIssue $issue): void
    {
        $project = $this->getEntityManager()->getReference(Project::class, $issue->getProjectId()->value);

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
        $issues = $this->findBy([
            'project' => $this->getEntityManager()->getReference(Project::class, $projectId->value),
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
    
    public function findIssuesByProjectId(ProjectId $projectId, int $page = 1, int $perPage = 20, $filters = null): array
    {

        $queryBuilder = $this->createQueryBuilder('i')
            ->where('i.project = :projectId')
            ->setParameter('projectId', $projectId->value)
            ->orderBy('i.createdAt', 'DESC');

        if ($filters) {
            foreach ($filters as $field => $value) {
                $queryBuilder->andWhere(sprintf('i.%s = :%s', $field, $field))
                    ->setParameter($field, $value);
            }
        }

        $query = $queryBuilder->getQuery();

        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage);

        return [
            'data' => iterator_to_array($paginator),
            'total' => count($paginator),
            'currentPage' => $page,
            'perPage' => $perPage,
        ];
    }
}
