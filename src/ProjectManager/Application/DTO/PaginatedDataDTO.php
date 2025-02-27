<?php

namespace LetsBeBusy\ProjectManager\Application\DTO;

readonly class PaginatedDataDTO {

    public function __construct(
        public array $data,
        public int $total,
        public int $page,
        public int $perPage,
    ) {

    }
}
