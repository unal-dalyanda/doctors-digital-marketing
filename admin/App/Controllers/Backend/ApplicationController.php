<?php

namespace App\Controllers\Backend;

use View, Model, Session, Request;

class ApplicationController extends BaseController
{
    public function applicationList(string $applicationType)
    {
        if ($applicationType == 'all') {
            $this->pageData['title'] = 'Appointment List | Core-Page';
            $this->pageData['page_title'] = 'Appointments';
            $this->pageData['applications'] = Model::run('application')->getApplications();
        } elseif ($applicationType == 'unread') {
            $this->pageData['title'] = 'Unread Appointments | Core-Page';
            $this->pageData['page_title'] = 'Unread Appointments';
            $this->pageData['applications'] = Model::run('application')->getApplicationsWithType(0);
        } elseif ($applicationType == 'approved') {
            $this->pageData['title'] = 'Approved Appointments | Core-Page';
            $this->pageData['page_title'] = 'Approved Appointments';
            $this->pageData['applications'] = Model::run('application')->getApplicationsWithType(2);
        }

        View::theme($this->appTheme)->render('pages.application-list', $this->pageData);
    }

    public function detail($applicationId)
    {
        $this->pageData['title'] = 'Appointment Details | Core-Page';
        $this->pageData['page_title'] = 'Appointment Details';
        $this->pageData['application'] = Model::run('application')->getApplication($applicationId);

        View::theme($this->appTheme)->render('pages.application-detail', $this->pageData);
    }

    public function delete($applicationId)
    {
        if (Model::run('application')->deleteApplication($applicationId)) {
            $flash['code'] = 1;
            $flash['text'] = 'The appointment was successfully deleted.';
        } else {
            $flash['code'] = 0;
            $flash['text'] = 'Appointment deletion failed. Try again later.';
        }

        Session::setFlash($flash, route('application_list', ['applicationType' => 'all']));
    }

    public function markApplication(string $markType, int $applicationId)
    {
        $status = null;

        if ($markType == 'unread') {
            $status = 0;
        } elseif ($markType == 'approved') {
            $status = 2;
        }

        $application_update = Model::run('application')->applicationMark($applicationId, ['status' => $status]);

        if ($application_update) {
            $flash['code'] = 1;
            $flash['text'] = 'The appointment is marked as '.$markType.'.';
        } else {
            $flash['code'] = 0;
            $flash['text'] = 'The appointment status could not be changed. Try again later.';
        }

        Session::setFlash($flash, route('application_list', ['applicationType' => 'all']));
    }

    public function save(int $applicationId)
    {
        $application_save = Model::run('application')->applicationAdminSave($applicationId, [
            'appointment_date' => Request::post('appointment_date'),
            'appointment_note' => Request::post('appointment_note'),
            'status' => 2
        ]);

        if ($application_save) {
            $flash['code'] = 1;
            $flash['text'] = 'Appointment details updated successfully.';
        } else {
            $flash['code'] = 0;
            $flash['text'] = 'Appointment details could not be updated!';
        }

        Session::setFlash($flash, route('application_detail', ['applicationId' => $applicationId]));
    }
}
