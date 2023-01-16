<?php

namespace App\Controllers\Api;

use View, Model, Response;

class BlogController extends BaseController
{
    public function blogs(int $blogPage = null){
        $this->pageData['title'] = 'Blogs - ' . $this->general_site_title;
        $this->pageData['description'] = $this->general_settings->site_description;
        $this->pageData['keywords'] = json_decode($this->seo_settings->seo_keywords);
        $this->pageData['blog_posts'] = Model::run('blog')->getBlogs();

        View::theme($this->appTheme)->render('blog.blogs', $this->pageData);
    }

    public function blogDetail($blogSlug){
        $blog_data = Model::run('blog')->getBlogFromSlug($blogSlug);

        if($blog_data){

            $title = !empty($blog_data->seo_title) ? $blog_data->seo_title : $blog_data->title;

            $this->pageData['title'] = $title . ' | ' . $this->general_site_title;
            $this->pageData['description'] = !empty($blog_data->seo_description) ? $blog_data->seo_description : $this->general_settings->site_description;
            $this->pageData['keywords'] = !empty($blog_data->seo_keyword) ? json_decode($blog_data->seo_keyword) : json_decode($this->seo_settings->seo_keywords);
            $this->pageData['post'] = $blog_data;

            View::theme($this->appTheme)->render('blog.blog-detail', $this->pageData);
        }else{
            redirect(route('fr_blogs'));
        }
    }
}
