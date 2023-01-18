<?php
namespace App\Models;

use DB;

class Faq
{

    public function getFaqs()
    {
        return DB::table('faq')->getAll();
    }

    public function getFaq(int $faqId)
    {
        return DB::table('faq')->where('ID', '=', $faqId)->getRow();
    }

    public function addFaq($data): int
    {
        return DB::table('faq')->insert($data);
    }

    public function updateFaq(int $faqId, $data): int
    {
        return DB::table('faq')->where('ID', '=', $faqId)->update($data);
    }

    public function deleteFaq(int $faqId): int
    {
        return DB::table('faq')->where('ID', '=', $faqId)->delete();
    }
}
