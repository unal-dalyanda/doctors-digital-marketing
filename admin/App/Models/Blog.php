<?php

namespace App\Models;

use DB;

class Blog
{

    public function getBlogsAdmin()
    {
        return DB::table('blogs as blogs')
            ->select('blogs.ID, blogs.title, blogs.status, blogs.publish_date, blogs.category_id, cat.category_name')
            ->leftJoin('categories as cat', 'cat.ID=blogs.category_id')
            ->getAll();
    }

    public function getBlogCount(int $categoryId = null)
    {
        if (!is_null($categoryId)) {
            return DB::table('blogs')
                ->select('COUNT(*) AS count')
                ->where('status', '=', 1)
                ->where('category_id', '=', $categoryId)
                ->getRow();
        } else {
            return DB::table('blogs')
                ->select('COUNT(*) AS count')
                ->where('status', '=', 1)
                ->getRow();
        }
    }

    /**
     * @return mixed
     */
    public function getStickyBlogs()
    {
        return DB::table('blogs')
            ->select('ID, title, slug, cover_image, seo_description, status, publish_date')
            ->where('status', '=', 1)
            ->where('type', '=', 0)
            ->orderBy('publish_date', 'asc')
            ->getAll();
    }

    /**
     * @param int $initial
     * @param int $limit
     * @return mixed
     */
    public function getBlogs(int $initial, int $limit)
    {
        return DB::table('blogs as blogs')
            ->select('blogs.ID, blogs.title, blogs.slug, blogs.status, blogs.cover_image, blogs.seo_description, blogs.publish_date, blogs.category_id, cat.category_name')
            ->leftJoin('categories as cat', 'cat.ID=blogs.category_id')
            ->where('blogs.status', '=', 1)
            ->limit($initial, $limit)
            ->orderBy('blogs.publish_date', 'asc')
            ->getAll();
    }

    /**
     * @param int $initial
     * @param int $limit
     * @param int $categoryId
     * @return mixed
     */
    public function getBlogsWithCategoryId(int $initial, int $limit, int $categoryId)
    {
        return DB::table('blogs as blogs')
            ->select('blogs.ID, blogs.title, blogs.slug, blogs.status, blogs.cover_image, blogs.seo_description, blogs.publish_date, blogs.category_id, cat.category_name')
            ->leftJoin('categories as cat', 'cat.ID=blogs.category_id')
            ->where('blogs.status', '=', 1)
            ->where('blogs.category_id', '=', $categoryId)
            ->limit($initial, $limit)
            ->orderBy('blogs.publish_date', 'asc')
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

    public function getCoverImage(int $blogId)
    {
        return DB::table('blogs')->select('cover_image')->where('ID', '=', $blogId)->getRow();
    }

    public function getCategories()
    {
        return DB::table('categories')->getAll();
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

    public function addCategory($data): int
    {
        return DB::table('categories')->insert($data);
    }

    public function deleteCategory(int $categoryId): int
    {
        return DB::table('categories')->where('ID', '=', $categoryId)->delete();
    }
}
