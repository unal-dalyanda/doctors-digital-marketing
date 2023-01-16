<?php

namespace App\Controllers\Frontend;

use System\Kernel\Controller;

use Model;

class BaseController extends Controller
{
    protected $appTheme = 'default';
    protected $pageData = [];

    protected $general_settings;
    protected $seo_settings;
    protected $contact_settings;

    protected $general_site_title;
    protected $recent_blogs;

    public function __construct()
    {
        $this->pageData['css_version'] = '14012023';
        $this->pageData['js_version'] = '14012023';

        $generalConfig = config('app.general');
        $this->appTheme = $generalConfig['theme'];
        $this->general_settings = json_decode(Model::run('base')->getSetting('general')->settings_value);
        $this->seo_settings = json_decode(Model::run('base')->getSetting('seo')->settings_value);
        $this->contact_settings = json_decode(Model::run('base')->getSetting('contact')->settings_value);
        $this->general_site_title = $this->general_settings->site_name . ' | ' . $this->general_settings->site_slogan;
        $this->recent_blogs = Model::run('blog')->getRecentBlogs(2);

        $this->pageData['site_logo'] = $this->general_settings->site_logo;
        $this->pageData['site_name'] = $this->general_settings->site_name;
        $this->pageData['opening_hours'] = $this->contact_settings->opening_hours;
        $this->pageData['main_email'] = $this->contact_settings->main_email;
        $this->pageData['main_phone'] = $this->contact_settings->phone_number;
        $this->pageData['main_office_address'] = $this->contact_settings->main_office_address;
        $this->pageData['fax_number'] = $this->contact_settings->fax_number;
        $this->pageData['social_media'] = $this->contact_settings->social;
        $this->pageData['recent_blogs'] = $this->recent_blogs;
    }
}
