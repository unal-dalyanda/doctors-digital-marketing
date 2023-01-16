<?php

namespace App\Models;

use DB;

class Team
{
    public function getMembers()
    {
        return DB::table('team_members as members')
            ->select('members.ID, members.department_id, members.member_name, members.member_image, members.member_detail, members.social_accounts, members.status, departments.department_name')
            ->leftJoin('departments as departments', 'departments.ID=members.department_id')
            ->getAll();
    }

    public function getDepartments()
    {
        return DB::table('departments')->orderBy('department_name', 'asc')->getAll();
    }

    public function getMember(int $memberID){
        return DB::table('team_members')->where('ID', '=', $memberID)->getRow();
    }

    public function getMemberCount()
    {
        DB::table('team_members')->where('status', '=', 1)->getAll();
        return DB::numRows();
    }

    public function getMemberImage(int $memberID){
        return DB::table('team_members')->select('member_image')->where('ID', '=', $memberID)->getRow();
    }

    public function addMember($data): int
    {
        return DB::table('team_members')->insert($data);
    }

    public function addDepartment($data): int
    {
        return DB::table('departments')->insert($data);
    }

    public function editMember($memberId, $data): int
    {
        return DB::table('team_members')->where('ID', '=', $memberId)->update($data);
    }

    public function deleteMember($memberId): int
    {
        return DB::table('team_members')->where('ID', '=', $memberId)->delete();
    }

    public function deleteDepartment($departmentId): int
    {
        return DB::table('departments')->where('ID', '=', $departmentId)->delete();
    }
}
