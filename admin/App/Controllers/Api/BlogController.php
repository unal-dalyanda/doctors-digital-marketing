<?php

namespace App\Controllers\Api;

use Model, Response;

class BlogController extends BaseController
{
    public function blogs(int $blogPage = null)
    {
        $limit = 20;
        $page_number = is_null($blogPage) ? 1 : ($blogPage == 0 ? 1 : $blogPage);
        $blog_count = intval(Model::run('blog')->getBlogCount()->count);
        $total_page = ceil($blog_count / $limit);
        $initial_page = ($page_number - 1) * $limit;

        $content = [
            'title' => 'Blogs - ' . $this->general_site_title,
            'description' => $this->general_settings->site_description,
            'keywords' => json_decode($this->seo_settings->seo_keywords),
            'current_page' => $page_number,
            'total_page' => $total_page,
            'post' => Model::run('blog')->getBlogs($initial_page, $limit),
            'contact_email' => $this->pageData['main_email'],
            'social_phone' => $this->pageData['main_phone'],
            'social_media' => $this->pageData['social_media'],
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($content);
    }

    public function blogDetail(int $blogId)
    {
        $blog_data = Model::run('blog')->getBlog($blogId);

        if ($blog_data) {

            $title = !empty($blog_data->seo_title) ? $blog_data->seo_title : $blog_data->title;

            $this->pageData['title'] = $title . ' | ' . $this->general_site_title;
            $this->pageData['description'] = !empty($blog_data->seo_description) ? $blog_data->seo_description : $this->general_settings->site_description;
            $this->pageData['keywords'] = !empty($blog_data->seo_keyword) ? json_decode($blog_data->seo_keyword) : json_decode($this->seo_settings->seo_keywords);
            $this->pageData['post'] = $blog_data;

            $content = [
                'title' => $this->pageData['title'],
                'description' => $this->pageData['description'],
                'keywords' => $this->pageData['keywords'],
                'post' => $blog_data,
                'contact_email' => $this->pageData['main_email'],
                'social_phone' => $this->pageData['main_phone'],
                'social_media' => $this->pageData['social_media'],
            ];
        } else {
            header('HTTP/1.1 404 Not Found');

            $content = [
                'status' => 'error',
                'message' => 'The blog you requested was not found!'
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($content);
    }
}
