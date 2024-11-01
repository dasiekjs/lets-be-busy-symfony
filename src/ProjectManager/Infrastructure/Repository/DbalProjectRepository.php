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

    public function getById(ProjectId $id): ?DomainProject
    {
        $project = $this->findOneBy([
            'id' => $id->value,
        ]);

        if (null === $project) {
            return null;
        }

        return DomainProject::create(
            new ProjectId($project->getId()),
            $project->getName(),
            $project->getDescription()
        );
    }

    public function getAll(): array
    {
        $projects = $this->findAll();
        return array_map(function (DomainProject $project) {
            return DomainProject::create(
                new ProjectId($project->getId()),
                $project->getName(),
                $project->getDescription()
            );
        }, $projects);
    }
}
