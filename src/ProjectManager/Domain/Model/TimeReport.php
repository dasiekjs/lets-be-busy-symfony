<?php

namespace LetsBeBusy\ProjectManager\Domain\Model;

use LetsBeBusy\ProjectManager\Domain\Comment;
use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\TimeReportId;
use LetsBeBusy\ProjectManager\Domain\WorkingTime;

class TimeReport
{
    public function __construct(
        private TimeReportId $id,
        private IssueId $issueId,
        private Comment $comment,
        private WorkingTime $workingTime
    ) {

    }

    public function getId(): TimeReportId
    {
        return $this->id;
    }

    public function setId(TimeReportId $id): void
    {
        $this->id = $id;
    }

    public function getIssueId(): IssueId
    {
        return $this->issueId;
    }

    public function setIssueId(IssueId $issueId): void
    {
        $this->issueId = $issueId;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function setComment(Comment $comment): void
    {
        $this->comment = $comment;
    }

    public function getWorkingTime(): WorkingTime
    {
        return $this->workingTime;
    }

    public function setWorkingTime(WorkingTime $workingTime): void
    {
        $this->workingTime = $workingTime;
    }

}
