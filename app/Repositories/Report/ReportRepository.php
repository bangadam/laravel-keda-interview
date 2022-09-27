<?php

namespace App\Repositories\Report;

use App\Models\Report;
use App\Models\User;

class ReportRepository implements IReportRepository
{
    public function getMyReport($request): array {
        $report = new Report();

        // staff only
        if (auth()->user()->user_type_id != 2) {
            throw new \Exception('You are not allowed to view reports');
        }

        $report = $report->where('staff_id', $request->user()->id)->with('customer');

        $report = $report->orderBy('created_at', 'desc')->get();

        return $report->toArray();
    }

    public function doReport($request): bool {
        try {
            $report = new Report();
            $report->customer_id = auth()->user()->id;

            // check if staff is user type staff
            $staff = User::find($request->staff_id);
            if ($staff->user_type_id != 2) {
                throw new \Exception('Staff is not user type staff');
            }

            $report->staff_id  = $request->staff_id;
            $report->reason = $request->reason;
            $report->type = $request->type;

            return $report->save();
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }
}
