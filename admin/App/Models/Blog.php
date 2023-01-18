<?php

namespace App\Models;

use DB;

class Blog
{

    public function getBlogsAdmin()
    {
        return DB::table('blogs')->select('ID, title, status, publish_date')->orderBy('ID', 'desc')->getAll();
    }

    public function getBlogCount()
    {
        return DB::table('blogs')->select('COUNT(*) AS count')->where('status', '=', 1)->getRow();
    }

    public function getStickyBlogs()
    {
        return DB::table('blogs')
            ->select('ID, title, slug, cover_image, seo_description, status, publish_date')
            ->where('status', '=', 1)
            ->where('type', '=', 0)
            ->orderBy('publish_date', 'asc')
            ->getAll();
    }

    public function getBlogs(int $initial, int $limit)
    {
        return DB::table('blogs')
            ->select('ID, title, slug, cover_image, seo_description, status, publish_date')
            ->where('status', '=', 1)
            ->where('type', '!=', 0)
            ->limit($initial, $limit)
            ->orderBy('publish_date', 'asc')
            ->getAll();
    }

    public function getBlog(int $blogId)
    {
        return DB::table('blogs')->where('ID', '=', $blogId)->getRow();
    }

    public function getBlogFromSlug($blogSlug)
    {
        return DB::table('blogs')->where('slug', '=', $blogSlug)->getRow();
    }

    public function getCoverImage(int $blogId){
        return DB::table('blogs')->select('cover_image')->where('ID', '=', $blogId)->getRow();
    }

    public function addBlog($data): int
    {
        return DB::table('blogs')->insert($data);
    }

    public function updateBlog($blogId, $data): int
    {
        return DB::table('blogs')->where('ID', '=', $blogId)->update($data);
    }

    public function deleteBlog(int $blogId): int
    {
        return DB::table('blogs')->where('ID', '=', $blogId)->delete();
    }
}
