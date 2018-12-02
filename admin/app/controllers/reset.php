<?php

class Reset extends Controller
{
    public function index($idAdmin=false,$resetKey=false)
    {
        $notifications = $this->model('notifications');
        if(!$idAdmin || !$resetKey)
        {
            $this->view('reset/index',['notification'=>$notifications->notifications()[11]]);
        }
        else
        {
            $userModel=$this->model('admin');
            $properReset=$userModel->checkUserReset($idAdmin,$resetKey);

            $notification=$notifications->notifications()[10];
            if($properReset)
            {
                $userModel->changePassword($idAdmin);
            }
            else
            {
                $notification=$notifications->notifications()[11];
            }
            $this->view('reset/index',['notification'=>$notification]);
        }
    }
}