<?php

namespace Tests\LetsBeBusy\ProjectManager\Domain\Service;

use LetsBeBusy\ProjectManager\Application\DTO\CreateIssueDTO;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Model\Issue;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use LetsBeBusy\ProjectManager\Domain\Service\IssueService;
use PHPUnit\Framework\TestCase;
use Tests\LetsBeBusy\ProjectManager\Doubles\InMemoryIssueRepository;
use Tests\LetsBeBusy\ProjectManager\Doubles\InMemoryProjectRepository;

class IssueServiceTest extends TestCase
{
    public function test_ShouldCreateNewIssue()
    {
        $issueRepository = new InMemoryIssueRepository();
        $projectRepository = new InMemoryProjectRepository();

        $service = new IssueService($issueRepository, $projectRepository);

        $service->create(
            new CreateIssueDTO(
                title: 'Title',
                content: 'Content',
                projectId: new ProjectId(
                    'INMEM'
                )
            ),
            new IssueId('INMEM-2')
        );

        $newIssue = $issueRepository->getById(new IssueId('INMEM-2'));

        $this->assertInstanceOf(Issue::class, $newIssue);
        $this->assertEquals(
            'Title',
            $newIssue->getTitle(),
            'New Issue should have title `Title`'
        );
        $this->assertEquals(
            'Content',
            $newIssue->getContent(),
            'New Issue should have content `Content`'
        );
    }
}