<?php
namespace App\Controllers\Backend;

use Model, Request, Session, View;

class FaqController extends BaseController
{

    public function index()
    {
        $this->pageData['title'] = 'FAQ | Core-Page';
        $this->pageData['faqs'] = Model::run('faq')->getFaqs();

        View::theme($this->appTheme)->render('pages.faq', $this->pageData);
    }

    public function edit(int $faqId)
    {
        $faqData = Model::run('faq')->getFaq($faqId);
        $this->pageData['title'] = $faqData->title . 'Edit | Core-Page';
        $this->pageData['faq'] = $faqData;

        View::theme($this->appTheme)->render('pages.faq-edit', $this->pageData);
    }

    public function add()
    {
        $insertData = [
            'title'         => Request::post('faq_title'),
            'description'   => Request::post('faq_detail'),
        ];

        $add_faq = Model::run('faq')->addFaq($insertData);

        if($add_faq){
            $flash['code'] = 1;
            $flash['text'] = 'The FAQ has been successfully added.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Add FAQ failed! Try again later.';
        }

        Session::setFlash($flash, route('faq'));
    }

    public function update(int $faqId)
    {
        $update_faq = Model::run('faq')->updateFaq($faqId, [
            'title'         => Request::post('faq_title'),
            'description'   => Request::post('faq_detail'),
        ]);

        if($update_faq){
            $flash['code'] = 1;
            $flash['text'] = 'The FAQ has been successfully added.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Add FAQ failed! Try again later.';
        }

        Session::setFlash($flash, route('faq_edit', ['faqId' => $faqId]));
    }

    public function delete(int $faqId)
    {
        if(Model::run('faq')->deleteFaq($faqId)){
            $flash['code'] = 1;
            $flash['text'] = 'The FAQ was successfully deleted.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'FAQ deletion failed. Try again later.';
        }

        Session::setFlash($flash, route('faq'));
    }
}
