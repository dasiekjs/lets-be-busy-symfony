<?php

namespace LetsBeBusy\ProjectManager\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Repository\ProjectRepository;
use LetsBeBusy\ProjectManager\Infrastructure\Entity\Project;

use LetsBeBusy\ProjectManager\Domain\Model\Project as DomainProject;

class DbalProjectRepository extends ServiceEntityRepository implements ProjectRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function save(DomainProject $project): void
    {
        $project = (new Project($project->getId()->value))
            ->setName($project->getName())
            ->setDescription($project->getDescription())
        ;

        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();
    }

    public function update(DomainProject $project): void
    {
        $projectId = $project->getId();
        /**
         * @var Project $updated
         */
        $updated = $this->findOneBy([
            'id' => $projectId->value,
        ]);

        $updated->setName($project->getName());
        $updated->setDescription($project->getDescription());
        $updated->setIssuesNum($project->getIssuesNum());

        $this->getEntityManager()->persist($updated);
        $this->getEntityManager()->flush();
    }

    public function getById(ProjectId $id): ?DomainProject
    {
        /**
         * @var Project | null $project
         */
        $project = $this->findOneBy([
            'id' => $id->value,
        ]);

        if (null === $project) {
            return null;
        }

        return DomainProject::create(
            new ProjectId($project->getId()),
            $project->getName(),
            $project->getDescription(),
            $project->getIssuesNum()
        );
    }

    public function getAll(): array
    {
        $projects = $this->findAll();
        return array_map(function (Project $project) {
            return DomainProject::create(
                new ProjectId($project->getId()),
                $project->getName(),
                $project->getDescription(),
                $project->getIssuesNum()
            );
        }, $projects);
    }
}
