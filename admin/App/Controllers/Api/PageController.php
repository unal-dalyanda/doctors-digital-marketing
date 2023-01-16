<?php

namespace App\Controllers\Api;

use View, Model;

class PageController extends BaseController
{

    public function index()
    {
        $page_data = Model::run('page')->getPage(1);
        $page_title = !empty($page_data->seo_title) ? $page_data->seo_title : 'Home';

        $this->pageDataGenerator($page_title, $page_data);
        $this->pageData['about'] = Model::run('page')->getPage(2);
        $this->pageData['members'] = Model::run('team')->getMembers();

        View::theme($this->appTheme)->render('index', $this->pageData);
    }

    public function about()
    {
        $page_data = Model::run('page')->getPage(2);
        $page_title = !empty($page_data->seo_title) ? $page_data->seo_title : 'About Us';

        $this->pageDataGenerator($page_title, $page_data);

        View::theme($this->appTheme)->render('pages.about', $this->pageData);
    }

    public function service()
    {
        $page_data = Model::run('page')->getPage(3);
        $page_title = !empty($page_data->seo_title) ? $page_data->seo_title : 'Our Services';

        $this->pageDataGenerator($page_title, $page_data);
        $this->pageData['services'] = Model::run('service')->getServices();

        View::theme($this->appTheme)->render('pages.service', $this->pageData);
    }

    public function team()
    {
        $this->pageDataGenerator('Doctors', null);
        $this->pageData['members'] = Model::run('team')->getMembers();

        View::theme($this->appTheme)->render('pages.team', $this->pageData);
    }

    public function contact()
    {
        $this->pageDataGenerator('Contact', null);
        $this->pageData['other_offices'] = $this->contact_settings->office_address;
        $this->pageData['other_phone'] = $this->contact_settings->phone_numbers;

        View::theme($this->appTheme)->render('pages.contact', $this->pageData);
    }

    public function appointment()
    {
        $this->pageDataGenerator('Appointment', null);

        View::theme($this->appTheme)->render('pages.appointment', $this->pageData);
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
