<?php

namespace App\Controllers\Api;

use Model, Response;

class PageController extends BaseController
{

    public function index()
    {
        $services = array();
        $home_blogs = array();
        $home_about = array();
        $page_data = Model::run('page')->getPage(1);
        $page_title = !empty($page_data->seo_title) ? $page_data->seo_title : 'Home';

        $this->pageDataGenerator($page_title, $page_data);

        $services_data = Model::run('service')->getServices();
        $blogs_data = Model::run('blog')->getStickyBlogs();
        $about_data = Model::run('page')->getPage(2);

        if($services_data){
            foreach ($services_data as $service){
                $services[] = [
                    'ID' => intval($service->ID),
                    'service_name' => $service->service_name,
                    'service_detail' => $service->service_detail,
                    'service_link' => $service->service_link,
                    'service_image' => base_url('Public/uploads/services/') . $service->service_image
                ];
            }
        }

        if($blogs_data){
            foreach ($blogs_data as $blog){
                $home_blogs[] = [
                    'ID' => intval($blog->ID),
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'item_id' => $blog->item_id,
                    'cover_image' => base_url('Public/uploads/blogs/') . $blog->cover_image,
                    'seo_description' => $blog->seo_description,
                    'status' => $blog->status,
                    'publish_date' => $blog->publish_date,
                ];
            }
        }

        if($about_data){
            foreach ($about_data as $data){
                $home_blogs[] = [
                    'ID' => intval($data->ID),
                    'title' => $data->title,
                    'sub_title' => $data->sub_title,
                    'page_content' => $data->page_content,
                    'cover_image' => base_url('Public/uploads/pages/') . $data->cover_image,
                    'seo_title' => $data->seo_title,
                    'seo_description' => $data->seo_description
                ];
            }
        }

        $content = [
            'title' => $this->pageData['title'],
            'description' => $this->pageData['description'],
            'keywords' => $this->pageData['keywords'],
            'services' => $services,
            'about' => $home_about,
            'home_blog' => $home_blogs,
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
