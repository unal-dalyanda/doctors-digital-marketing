<?php
namespace App\Models;

use DB;

class Page
{
    public function getPages(){
        return DB::table('pages')
            ->orderBy('ID')
            ->getAll();
    }

    public function getPage(int $pageId){
        return DB::table('pages')
            ->where('ID', '=', $pageId)
            ->getRow();
    }

    public function getCoverImage(int $pageId){
        return DB::table('pages')
            ->select('cover_image')
            ->where('ID', '=', $pageId)
            ->getRow();
    }

    public function updatePage($pageId, $data): int
    {
        return DB::table('pages')
            ->where('ID', '=', $pageId)
            ->update($data);
    }
}
