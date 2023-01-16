<?php
namespace App\Models;

use DB;

class Service
{

	public function getServices()
    {
        return DB::table('services')->getAll();
    }

    public function getService(int $serviceId)
    {
        return DB::table('services')->where('ID', '=', $serviceId)->getRow();
    }

    public function addService($data): int
    {
        return DB::table('services')->insert($data);
    }

    public function deleteService(int $serviceId): int
    {
        return DB::table('services')->where('ID', '=', $serviceId)->delete();
    }
}
