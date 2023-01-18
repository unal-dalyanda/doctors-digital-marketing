<?php

namespace App\Models;

use DB, Date;

class Application
{
    public function getApplications()
    {
        return DB::table('applications')
            ->orderBy('created_at', 'desc')
            ->getAll();
    }
    public function getApplicationsWithType(int $type)
    {
        return DB::table('applications')
            ->where('status', '=', $type)
            ->orderBy('created_at', 'desc')
            ->getAll();
    }

    public function getRecentApplications(int $limit = 5)
    {
        return DB::table('applications')->orderBy('ID', 'desc')->limit($limit)->getAll();
    }

    public function getApplicationCount()
    {
        return DB::table('applications')->select('COUNT(*) AS count')->getRow();
    }

    public function getUnreadApplicationCount()
    {
        return DB::table('applications')->select('COUNT(*) AS count')->where('status', '=', 0)->getRow();
    }

    public function getApplication(int $applicationId)
    {
        $application = DB::table('applications')->where('ID', '=', $applicationId)->getRow();

        if($application->status == 0){
            DB::table('applications')->where('ID', '=', $applicationId)->update(['status' => 1]);
        }
        return $application;
    }

    public function addApplication($data): bool
    {
        return DB::table('applications')->insert($data);
    }

    public function deleteApplication(int $applicationId): int
    {
        return DB::table('applications')->where('ID', '=', $applicationId)->delete();
    }

    public function applicationMark(int $applicationId, $data): int
    {
        return DB::table('applications')->where('ID', '=', $applicationId)->update($data);
    }

    public function applicationAdminSave(int $applicationId, $data): int
    {
        return DB::table('applications')->where('ID', '=', $applicationId)->update($data);
    }

}
