<?php

namespace App\Controllers\Backend;

use Model, Request, Date, DB, Session, Upload, View;

class PageController extends BaseController
{

    public function index()
    {
        $this->pageData['title'] = 'Pages | Core-Page';
        $this->pageData['pages'] = Model::run('page')->getPages();

        View::theme($this->appTheme)->render('pages.pages', $this->pageData);
    }

    public function edit(int $pageId)
    {
        $this->pageData['title'] = 'Page Edit | Core-Page';
        $this->pageData['page_title'] = 'Page Edit';
        $this->pageData['page_id'] = $pageId;
        $this->pageData['page'] = Model::run('page')->getPage($pageId);

        View::theme($this->appTheme)->render('pages.page-edit', $this->pageData);
    }

    public function editAction(int $pageId)
    {
        $imageName = null;
        $file = Request::files('cover_image');
        if (!empty($file['name'])) {
            $cover_image = Model::run('page')->getCoverImage($pageId);

            if (!empty($cover_image->cover_image)) {
                if(file_exists(public_path('uploads/pages/' . $cover_image->cover_image))){
                    unlink(public_path('uploads/pages/' . $cover_image->cover_image));
                }
            }

            if ($this->uploadImage($file)) {
                $imageName = $file['name'];
            } else {
                $flash['code'] = 0;
                $flash['text'] = 'The operation is invalid because the page cover image is not uploaded. Error output: <br />' . Upload::errorMessage();

                Session::setFlash($flash, route('page_edit', ['pageId' => $pageId]));
            }
        }

        $update_data = [
            'title' => Request::post('title'),
            'sub_title' => Request::post('sub_title'),
            'page_content' => Request::post('content', true),
            'seo_title' => Request::post('seo_title'),
            'seo_description' => Request::post('seo_description'),
            'seo_keyword' => !empty(Request::post('seo_keywords')) ? Request::post('seo_keywords') : null,
            'status' => Request::post('submit') == 'publish' ? 1 : 0,
            'updated_at' => Date::now()->get('Y-m-d')
        ];

        if(!is_null($imageName)){
            $update_data['cover_image'] = $imageName;
        }

        $update_page = Model::run('page')->updatePage($pageId, $update_data);

        if ($update_page) {
            $flash['code'] = 1;
            $flash['text'] = 'The page has been successfully updated.';
        } else {
            $flash['code'] = 0;
            $flash['text'] = 'Update page failed! Try again later. <br />' . DB::getError();
        }

        Session::setFlash($flash, route('page_edit', ['pageId' => $pageId]));
    }

    private function uploadImage($file): bool
    {
        Upload::allowedTypes(['jpg', 'png']);
        Upload::maxSize(2000);
        Upload::uploadPath(public_path('uploads/pages'));
        Upload::file($file);

        if (Upload::handle()) {
            return true;
        } else {
            return false;
        }
    }
}
