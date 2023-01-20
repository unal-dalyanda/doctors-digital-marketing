<?php
namespace App\Controllers\Backend;

use System\Kernel\Controller;
use View, Request, Model;

class BaseController extends Controller
{
    protected $appTheme = 'admin';
    protected $pageData = [];

    public function __construct()
    {
        $sidebarMenu = array(
            'group1'    => array(
                'items' => array(
                    'dashboard' => array(
                        'title'     => 'Dashboard',
                        'link'      => route('admin_dashboard'),
                        'is_active' => $this->isActive(route('admin_dashboard')),
                        'icon'      => 'fas fa-tachometer-alt'
                    ),
                    'applications' => array(
                        'title'     => 'Contact Requests',
                        'link'      => route('application_list', ['applicationType' => 'all']),
                        'is_active' => $this->isOpen(['applications', 'application']),
                        'icon'      => 'fab fa-wpforms',
                        'badge'     => Model::run('application')->getUnreadApplicationCount(),
                        'submenu'   => array(
                            'applications' => array(
                                'title'     => 'All Requests',
                                'link'      => route('application_list', ['applicationType' => 'all']),
                                'is_active' => $this->isActive(route('application_list', ['applicationType' => 'all'])),
                                'custom_css'=> 'text-info'
                            ),
                            'unread_applications' => array(
                                'title'     => 'Unread Requests',
                                'link'      => route('application_list', ['applicationType' => 'unread']),
                                'is_active' => $this->isActive(route('application_list', ['applicationType' => 'unread'])),
                                'custom_css'=> 'text-danger'
                            ),
                            'approved_applications' => array(
                                'title'     => 'Approved Requests',
                                'link'      => route('application_list', ['applicationType' => 'approved']),
                                'is_active' => $this->isActive(route('application_list', ['applicationType' => 'approved'])),
                                'custom_css'=> 'text-success'
                            )
                        )
                    )
                )
            ),
            'group2'    => array(
                'title' => 'Web Management',
                'items' => array(
                    'pages' => array(
                        'title'     => 'Sections',
                        'link'      => route('pages'),
                        'is_active' => $this->isOpen(['pages', 'page']),
                        'icon'      => 'fas fa-th-list'
                    ),
                    'blogs' => array(
                        'title'     => 'Blogs',
                        'link'      => route('blogs'),
                        'is_active' => $this->isOpen(['blogs', 'blog']),
                        'icon'      => 'fas fa-blog',
                        'submenu'   => array(
                            'pages' => array(
                                'title'     => 'All Blogs',
                                'link'      => route('blogs'),
                                'is_active' => $this->isActive(route('blogs')),
                            ),
                            'page_add' => array(
                                'title'     => 'Add Blog',
                                'link'      => route('blog_add'),
                                'is_active' => $this->isActive(route('blog_add')),
                            ),
                            'category' => array(
                                'title'     => 'Categories',
                                'link'      => route('categories'),
                                'is_active' => $this->isActive(route('categories')),
                            )
                        )
                    ),
                    'services' => array(
                        'title'     => 'Services',
                        'link'      => route('services'),
                        'is_active' => $this->isActive(route('services')),
                        'icon'      => 'fas fa-columns'
                    ),
                    'faq' => array(
                        'title'     => 'FAQ',
                        'link'      => route('faq'),
                        'is_active' => $this->isActive(route('faq')),
                        'icon'      => 'fas fa-question-circle'
                    )
                )
            ),
            'group3'    => array(
                'title' => 'System',
                'items' => array(
                    'settings' => array(
                        'title'     => 'Settings',
                        'link'      => route('settings'),
                        'is_active' => $this->isActive(route('settings')),
                        'icon'      => 'fas fa-cog'
                    )
                )
            ),
            'group4'    => array(
                'title' => 'Operations',
                'items' => array(
                    'profile_edit' => array(
                        'title'     => 'Edit profile',
                        'link'      => route('profile_edit'),
                        'is_active' => $this->isActive(route('profile_edit')),
                        'icon'      => 'fa fa-user-alt',
                        'custom_css'=> 'text-info'
                    ),
                    'logout' => array(
                        'title'     => 'Sign out',
                        'link'      => route('logout'),
                        'is_active' => $this->isActive(route('logout')),
                        'icon'      => 'fa fa-sign-out-alt',
                        'custom_css'=> 'text-danger'
                    )
                )
            )
        );

        $this->pageData['sidebar_menu'] = $sidebarMenu;
    }

    /**
     * @param $route (string)
     * @return bool
     */
    private function isActive($route): bool
    {
        $currentRoute = current_url();
        $route = base_url() . $route;

        if($route === $currentRoute)
            return true;

        return false;
    }

    /**
     * @param $segments (array|string)
     * @return bool
     */
    private function isOpen($segments): bool
    {
        $current_segment = 'dashboard';

        if(!empty(Request::getSegment(1)))
            $current_segment = Request::getSegment(1);

        if(is_array($segments))
            if(in_array($current_segment, $segments))
                return true;

            if($current_segment === $segments)
                return true;

        return false;
    }
}
