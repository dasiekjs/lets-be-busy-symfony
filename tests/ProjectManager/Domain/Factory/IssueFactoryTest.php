<?php

namespace Tests\LetsBeBusy\ProjectManager\Domain\Factory;

use LetsBeBusy\ProjectManager\Domain\Factory\IssueFactory;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Model\Issue;
use LetsBeBusy\ProjectManager\Domain\ProjectId;
use PHPUnit\Framework\TestCase;

class IssueFactoryTest extends TestCase
{
    public function test_issue_should_be_created() {

        $issue = IssueFactory::create(
            new IssueId('ABC123'),
            new ProjectId('ABC'),
            'Title',
            'Description',
        );

        $this->assertInstanceOf(Issue::class, $issue, '$issue should be an instance of Issue');
        $this->assertEquals(
            new IssueId('ABC123'),
            $issue->getId(),
            'IssueId should be ABC123 '
        );
        $this->assertEquals(
            new ProjectId('ABC'),
            $issue->getProjectId(),
            'ProjectId should be ABC'
        );
        $this->assertEquals(
            'Title',
            $issue->getTitle(),
            'Title should be `Title`'
        );
        $this->assertEquals(
            'Description',
            $issue->getContent(),
            'Issue content should be `Description`'
        );
        $this->assertNotNull($issue->getCreatedAt(), 'Issue created at should not be null');
        $this->assertNull($issue->getUpdatedAt(), 'Issue updated at shoulds be null');
    }

    public function test_issue_should_be_created_without_description()
    {

        $issue = IssueFactory::create(
            new IssueId('ABC123'),
            new ProjectId('ABC'),
            'Title',
        );

        $this->assertInstanceOf(Issue::class, $issue, '$issue should be an instance of Issue');
        $this->assertEquals(
            new IssueId('ABC123'),
            $issue->getId(),
            'IssueId should be ABC123 '
        );
        $this->assertEquals(
            new ProjectId('ABC'),
            $issue->getProjectId(),
            'ProjectId should be ABC'
        );
        $this->assertEquals(
            'Title',
            $issue->getTitle(),
            'Title should be `Title`'
        );
        $this->assertNull($issue->getContent(), 'Issue content should be null');
        $this->assertNotNull($issue->getCreatedAt(), 'Issue created at should not be null');
        $this->assertNull($issue->getUpdatedAt(), 'Issue updated at shoulds be null');
    }
}
