<?php

class Mail extends Controller
{
    public function index()
    {   
        $notifications= $this->model('notifications');
        
        $res = $notifications->notifications();
        $this->view('home/mail', ['notifications'=>$res]);

    }
}