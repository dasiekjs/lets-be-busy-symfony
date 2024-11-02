<?php

namespace LetsBeBusy\ProjectManager\Domain\Repository;

use LetsBeBusy\ProjectManager\Domain\IssueId;
use LetsBeBusy\ProjectManager\Domain\Model\TimeReport;
use LetsBeBusy\ProjectManager\Domain\TimeReportId;

interface TimeReportRepository
{
    public function save(TimeReport $timeReport): TimeReportId;

    public function update(TimeReport $timeReport): void;

    public function getById(TimeReportId $id): ?TimeReport;

    public function getAllByIssue(IssueId $issueId): array;
}
