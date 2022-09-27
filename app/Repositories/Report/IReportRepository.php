<?php

namespace App\Repositories\Report;

interface IReportRepository
{
    public function getMyReport($request): array;
    public function doReport($request): bool;
}
