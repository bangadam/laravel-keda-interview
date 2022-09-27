<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\CreateReportRequest;
use App\Repositories\Report\IReportRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportRepo;

    public function __construct(IReportRepository $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }

    public function getMyReport(Request $request)
    {
        try {
            $response = $this->reportRepo->getMyReport($request);

            return $this->successResponse($response, 'Reports retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function doReport(CreateReportRequest $request)
    {
        try {
            $response = $this->reportRepo->doReport($request);

            if ($response) {
                return $this->successResponse([], 'Reported successfully');
            }

            return $this->errorResponse('Report failed', [], 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
