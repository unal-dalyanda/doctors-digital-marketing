<?php

namespace App\Controllers\Backend;

use Model, Request, Upload, Date, Session, DB, View;

class BlogController extends BaseController
{

    public function index()
    {
        $this->pageData['title'] = 'Blog Posts | Core-Page';
        $this->pageData['page_title'] = 'Blogs';
        $this->pageData['blogs'] = Model::run('blog')->getBlogsAdmin();

        View::theme($this->appTheme)->render('pages.blog.blogs', $this->pageData);
    }

    public function add()
    {
        $this->pageData['title'] = 'Blog Add | Core-Page';
        $this->pageData['page_title'] = 'Add New Blog';

        View::theme($this->appTheme)->render('pages.blog.blog-add', $this->pageData);
    }

    public function save()
    {
        $imageName = null;
        $file = Request::files('cover_image');

        if (!empty($file['name'])) {
            if ($this->uploadImage($file)) {
                $imageName = $file['name'];
            } else {
                $flash['code'] = 0;
                $flash['text'] = 'The operation is invalid because the blog image is not uploaded. Error output: <br />' . Upload::errorMessage();

                Session::setFlash($flash, route('blogs'));
            }
        }

        $insertData = [
            'title' => Request::post('title'),
            'slug' => slug(Request::post('title')),
            'content' => Request::post('content'),
            'cover_image' => $imageName,
            'seo_title' => Request::post('seo_title'),
            'seo_description' => !empty(Request::post('seo_description')) ? Request::post('seo_description') : substr(strip_tags(Request::post('content')), 0, 150),
            'seo_keyword' => !empty(Request::post('seo_keywords')) ? Request::post('seo_keywords') : null,
            'status' => Request::post('submit') == 'publish' ? 1 : 0,
            'publish_date' => Date::now()->get('Y-m-d')
        ];

        $add_blog = Model::run('blog')->addBlog($insertData);

        if ($add_blog) {
            $flash['code'] = 1;
            $flash['text'] = 'The blog has been successfully added.';
        } else {
            $flash['code'] = 0;
            $flash['text'] = 'Add blog failed! Try again later. <br />' . DB::getError();
        }

        Session::setFlash($flash, route('blogs'));
    }

    public function edit(int $blogId)
    {
        $this->pageData['title'] = 'Blog Edit | Core-Page';
        $this->pageData['page_title'] = 'Blog Edit';
        $this->pageData['blog'] = Model::run('blog')->getBlog($blogId);
        $this->pageData['blog_id'] = $blogId;

        View::theme($this->appTheme)->render('pages.blog.blog-edit', $this->pageData);
    }

    public function editAction(int $blogId)
    {
        $imageName = null;
        $file = Request::files('cover_image');
        if (!empty($file['name'])) {
            $cover_image = Model::run('blog')->getCoverImage($blogId);

            if (!empty($cover_image->cover_image)) {
                if(file_exists(public_path('uploads/blogs/' . $cover_image->cover_image))){
                    unlink(public_path('uploads/blogs/' . $cover_image->cover_image));
                }
            }

            if ($this->uploadImage($file)) {
                $imageName = $file['name'];
            } else {
                $flash['code'] = 0;
                $flash['text'] = 'The operation is invalid because the blog image is not uploaded. Error output: <br />' . Upload::errorMessage();

                Session::setFlash($flash, route('blog_edit', ['blogId' => $blogId]));
            }
        }else{
            $cover_image = Model::run('blog')->getCoverImage($blogId);
            if (!empty($cover_image->cover_image)) {
                $imageName = $cover_image->cover_image;
            }
        }

        $updateData = [
            'title' => Request::post('title'),
            'slug' => slug(Request::post('title')),
            'content' => Request::post('content', true),
            'cover_image' => $imageName,
            'seo_title' => Request::post('seo_title'),
            'seo_description' => Request::post('seo_description'),
            'seo_keyword' => !empty(Request::post('seo_keywords')) ? Request::post('seo_keywords') : null,
            'status' => Request::post('submit') == 'publish' ? 1 : 0,
            'publish_date' => Date::now()->get('Y-m-d')
        ];

        $update_blog = Model::run('blog')->updateBlog($blogId, $updateData);

        if ($update_blog) {
            $flash['code'] = 1;
            $flash['text'] = 'The blog has been successfully updated.';
        } else {
            $flash['code'] = 0;
            $flash['text'] = 'Update blog failed! Try again later. <br />' . DB::getError();
        }

        Session::setFlash($flash, route('blog_edit', ['blogId' => $blogId]));
    }

    public function delete(int $blogId)
    {
        $cover_image = Model::run('blog')->getCoverImage($blogId);

        if (!empty($cover_image->cover_image)) {
            if(file_exists(public_path('uploads/blogs/' . $cover_image->cover_image))){
                if (unlink(public_path('uploads/blogs/' . $cover_image->cover_image))) {
                    if (Model::run('blog')->deleteBlog($blogId)) {
                        $flash['code'] = 1;
                        $flash['text'] = 'The blog post was successfully deleted.';
                    } else {
                        $flash['code'] = 0;
                        $flash['text'] = 'Blog post deletion failed. Try again later.';
                    }
                } else {
                    $flash['code'] = 0;
                    $flash['text'] = 'The operation is invalid because the blog image is not deleted.';
                }
            }else{
                if (Model::run('blog')->deleteBlog($blogId)) {
                    $flash['code'] = 1;
                    $flash['text'] = 'The blog post was successfully deleted.';
                } else {
                    $flash['code'] = 0;
                    $flash['text'] = 'Blog post deletion failed. Try again later.';
                }
            }
        }else{
            if (Model::run('blog')->deleteBlog($blogId)) {
                $flash['code'] = 1;
                $flash['text'] = 'The blog post was successfully deleted.';
            } else {
                $flash['code'] = 0;
                $flash['text'] = 'Blog post deletion failed. Try again later.';
            }
        }

        Session::setFlash($flash, route('blogs'));
    }

    private function uploadImage($file): bool
    {
        Upload::allowedTypes(['jpg', 'png', 'webp']);
        Upload::maxSize(2000);
        Upload::uploadPath(public_path('uploads/blogs'));
        Upload::file($file);

        if (Upload::handle()) {
            return true;
        } else {
            return false;
        }
    }
}
