<?php

namespace App\Repositories;

use App\Contracts\PostReport;
use App\Models\PostReport as ModelsPostReport;
use Exception;

class PostReportRepository extends BaseRepository implements PostReport
{
    public function __construct(ModelsPostReport $model)
    {
        parent::__construct($model);
    }

    public function createReport(array $attributes): mixed
    {
        try {
            return $this->create($attributes);
        } catch (Exception $e) {
            throw $e;
        }
    }
}