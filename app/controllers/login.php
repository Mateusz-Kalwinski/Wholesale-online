<?php
class Login extends Controller
{
    public function index()
    {
        $notifications = $this->model('notifications');
        
        $res = $notifications->notifications();

        $this->view('home/login', ['notifications'=>$res]);
    }
}