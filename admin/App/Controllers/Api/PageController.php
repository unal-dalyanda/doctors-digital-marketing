<?php

namespace App\Controllers\Api;

use Model, Response;

class PageController extends BaseController
{

    public function index()
    {
        $page_data = Model::run('page')->getPage(1);
        $page_title = !empty($page_data->seo_title) ? $page_data->seo_title : 'Home';

        $this->pageDataGenerator($page_title, $page_data);

        $content = [
            'title' => $this->pageData['title'],
            'description' => $this->pageData['description'],
            'keywords' => $this->pageData['keywords'],
            'services' => Model::run('service')->getServices(),
            'about' => Model::run('page')->getPage(2),
            'home_blog' => Model::run('blog')->getStickyBlogs(),
            'faq' => Model::run('faq')->getFaqs(),
            'contact_email' => $this->pageData['main_email'],
            'social_phone' => $this->pageData['main_phone'],
            'social_media' => $this->pageData['social_media'],

        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($content);
    }

    private function pageTitleGenerator($page_title): string
    {
        return $page_title . ' - ' . $this->general_site_title;
    }

    /**
     * @param string $page_title
     * @param $page_data
     * @return void
     */
    private function pageDataGenerator(string $page_title, $page_data)
    {
        $this->pageData['title'] = $this->pageTitleGenerator($page_title);
        $this->pageData['description'] = !empty($page_data->seo_description) ? $page_data->seo_description : $this->general_settings->site_description;
        $this->pageData['keywords'] = !empty($page_data->seo_keyword) ? json_decode($page_data->seo_keyword) : json_decode($this->seo_settings->seo_keywords);

        if (!is_null($page_data)) {
            $this->pageData['page'] = $page_data;
        }

    }
}
