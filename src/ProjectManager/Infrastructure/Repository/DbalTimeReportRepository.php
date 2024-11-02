<?php

namespace LetsBeBusy\ProjectManager\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LetsBeBusy\ProjectManager\Domain\Comment;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Repository\TimeReportRepository;
use LetsBeBusy\ProjectManager\Domain\TimeReportId;
use LetsBeBusy\ProjectManager\Domain\WorkingTime;
use LetsBeBusy\ProjectManager\Infrastructure\Entity\Issue;

use LetsBeBusy\ProjectManager\Domain\Model\TimeReport as DomainTimeReport;
use LetsBeBusy\ProjectManager\Infrastructure\Entity\TimeReport;

class DbalTimeReportRepository extends ServiceEntityRepository implements TimeReportRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeReport::class);
    }

    public function save(DomainTimeReport $timeReport): TimeReportId
    {
        $issue = $this->getEntityManager()->getRepository(Issue::class)
            ->find($timeReport->getIssueId()->getValue());

        $newTimeReport = (new TimeReport())
            ->setIssue($issue)
            ->setComment($timeReport->getComment()->getValue())
            ->setWorkingTime($timeReport->getWorkingTime()->getMinutes())
        ;

        $this->getEntityManager()->persist($newTimeReport);
        $this->getEntityManager()->flush();

        return new TimeReportId($newTimeReport->getId());
    }

    public function update(DomainTimeReport $timeReport): void
    {
        $timeReportEntity = $this->find($timeReport->getId()->value);

        $timeReportEntity
            ->setComment($timeReport->getComment()->getValue())
            ->setWorkingTime($timeReport->getWorkingTime()->getMinutes());

        $this->getEntityManager()->persist($timeReportEntity);
        $this->getEntityManager()->flush();
    }

    public function getById(TimeReportId $id): ?DomainTimeReport
    {
        /**
         * @var TimeReport | null $timeReport
         */
        $timeReport = $this->findOneBy([
            'id' => $id->value,
        ]);

        if (null === $timeReport) {
            return null;
        }

        return new DomainTimeReport(
            new TimeReportId($timeReport->getId()),
            new IssueId($timeReport->getIssue()->getId()),
            new Comment($timeReport->getComment()),
            new WorkingTime($timeReport->getWorkingTime()),
        );
    }

    public function getAllByIssue(IssueId $issueId): array
    {
        $issue = $this->getEntityManager()
            ->getRepository(Issue::class)
            ->find($issueId->getValue());

        $timeReports = $this->findBy([
            'issue' => $issue,
        ]);

        return array_map(function (TimeReport $timeReport) {
            return new DomainTimeReport(
                new TimeReportId($timeReport->getId()),
                new IssueId($timeReport->getIssue()->getId()),
                new Comment($timeReport->getComment()),
                new WorkingTime($timeReport->getWorkingTime()),
            );
        }, $timeReports);

    }
}
