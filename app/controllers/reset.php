<?php

class Reset extends Controller
{
    public function index($idUser=false,$resetKey=false)
    {
        $notifications = $this->model('notifications');
        if(!$idUser || !$resetKey)
        {
            $this->view('reset/index',['notification'=>$notifications->notifications()[11]]);
        }
        else
        {
            $userModel=$this->model('user');
            $properReset=$userModel->checkUserReset($idUser,$resetKey);

            $notification=$notifications->notifications()[10];
            if($properReset)
            {
                $userModel->changePassword($idUser);
            }
            else
            {
                $notification=$notifications->notifications()[11];
            } 
            $this->view('reset/index',['notification'=>$notification]);
        }

        
        


    }
}