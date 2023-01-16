<?php
namespace App\Controllers\Backend;

use Model, Session, Request, Upload, DB, View;

class TeamController extends BaseController
{

	public function index()
	{
        $this->pageData['title'] = 'Team Members | Core-Page';
        $this->pageData['members'] = Model::run('team')->getMembers();

        View::theme($this->appTheme)->render('pages.members', $this->pageData);
	}

	public function add()
	{
        $this->pageData['title'] = 'Add New Team Member | Core-Page';
        $this->pageData['departments'] = Model::run('team')->getDepartments();

        View::theme($this->appTheme)->render('pages.member-add', $this->pageData);
	}

    public function addAction(){
        $socialArray = array();
        $social = $_POST['social'];
        $imageName = null;

        if(!empty($social)){
            foreach (array_keys($social) as $fieldKey) {
                foreach ($social[$fieldKey] as $key=>$value) {
                    if(!empty($value))
                        $socialArray[$key][$fieldKey] = $value;
                }
            }
        }

        $file = Request::files('member_image');

        if(!empty($file['name'])){
            if($this->uploadImage($file)){
                $imageName = $file['name'];
            }else{
                $flash['code'] = 0;
                $flash['text'] = 'The operation is invalid because the member image is not uploaded. Error output: <br />' . Upload::errorMessage();

                Session::setFlash($flash, route('members'));
            }
        }

        $insertData = [
            'department_id' => Request::post('department_id'),
            'member_name' => Request::post('member_name'),
            'member_image' => $imageName,
            'member_detail' => Request::post('member_detail'),
            'social_accounts' => !empty($socialArray) ? json_encode($socialArray) : null,
        ];

        if (Request::post('submit') == 'publish') {
            $insertData['status'] = 1;
        } else {
            $insertData['status'] = 0;
        }

        $add_member = Model::run('team')->addMember($insertData);

        if($add_member){
            $flash['code'] = 1;
            $flash['text'] = 'The member has been successfully added.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Add member failed! Try again later.';
        }

        Session::setFlash($flash, route('members'));
    }

	public function edit(int $memberId)
	{
        $this->pageData['title'] = 'Edit Member | Core-Page';
        $this->pageData['departments'] = Model::run('team')->getDepartments();
        $this->pageData['member'] = Model::run('team')->getMember($memberId);
        $this->pageData['member_id'] = $memberId;

        View::theme($this->appTheme)->render('pages.member-edit', $this->pageData);
	}

    public function editAction(int $memberId)
    {
        $socialArray = array();
        $social = $_POST['social'];
        $imageName = null;

        if(!empty($social)){
            foreach (array_keys($social) as $fieldKey) {
                foreach ($social[$fieldKey] as $key=>$value) {
                    if(!empty($value))
                        $socialArray[$key][$fieldKey] = $value;
                }
            }
        }

        $file = Request::files('member_image');
        if(!empty($file['name'])){
            $member_image = Model::run('team')->getMemberImage($memberId);

            if(!empty($member_image)){
                unlink(public_path('uploads/members/' . $member_image->member_image));
            }

            if($this->uploadImage($file)){
                $imageName = $file['name'];
            }else{
                $flash['code'] = 0;
                $flash['text'] = 'The operation is invalid because the member image is not uploaded. Error output: <br />' . Upload::errorMessage();

                Session::setFlash($flash, route('member_edit', ['memberId' => $memberId]));
            }
        }

        $insertData = [
            'department_id' => Request::post('department_id'),
            'member_name' => Request::post('member_name'),
            'member_detail' => Request::post('member_detail'),
            'social_accounts' => !empty($socialArray) ? json_encode($socialArray) : null,
        ];

        if($imageName != null){
            $insertData['member_image'] = $imageName;
        }

        if (Request::post('submit') == 'publish') {
            $insertData['status'] = 1;
        } else {
            $insertData['status'] = 0;
        }

        $update_member = Model::run('team')->editMember($memberId, $insertData);

        if($update_member){
            $flash['code'] = 1;
            $flash['text'] = 'The member has been successfully updated.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Update member failed! Try again later.';
        }

        Session::setFlash($flash, route('member_edit', ['memberId' => $memberId]));
    }

	public function delete(int $memberId)
	{
        $delete = Model::run('team')->deleteMember($memberId);

        if($delete){
            $flash['code'] = 1;
            $flash['text'] = 'The member was successfully deleted.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Member deletion failed. Try again later.';
        }

        Session::setFlash($flash, route('members'));
	}

	public function departments()
	{
        $this->pageData['title'] = 'Departments | Core-Page';
        $this->pageData['departments'] = Model::run('team')->getDepartments();

        View::theme($this->appTheme)->render('pages.departments', $this->pageData);
	}

	public function departmentAdd()
	{
        $departmentName = Request::post('department_name', true);
        $addDepartment  = Model::run('team')->addDepartment([
            'department_name' => $departmentName
        ]);

        if($addDepartment){
            $flash['code'] = 1;
            $flash['text'] = 'Department has been successfully added.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Adding department failed.';
        }

        Session::setFlash($flash, route('departments'));
	}

	public function departmentDelete(int $departmentId)
	{
        $delete = Model::run('team')->deleteDepartment($departmentId);

        if($delete){
            $flash['code'] = 1;
            $flash['text'] = 'The department was successfully deleted.';
        }else{
            $flash['code'] = 0;
            $flash['text'] = 'Department deletion failed. Try again later.';
        }

        Session::setFlash($flash, route('departments'));
	}

    private function uploadImage($file): bool
    {
        Upload::allowedTypes(['jpg', 'png']);
        Upload::maxSize(2000);
        Upload::uploadPath(public_path('uploads/members'));
        Upload::file($file);

        if(Upload::handle()){
            return true;
        }else{
            return false;
        }
    }

}
