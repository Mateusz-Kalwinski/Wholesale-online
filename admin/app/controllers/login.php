<?php
//ini_set('display_errors',1);
class Login extends Controller
{
    public function index()
    {
        $notifications = $this->model('notifications');
        
        $res = $notifications->notifications();

        $this->view('home/login', ['notifications'=>$res]);
    }
}