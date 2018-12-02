<?php

class Licencja extends Controller
{
    private $responses=[];
    public function __construct()
    {
       $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $notifications = $this->model('notifications');

        $this->responses[0] = $menu->getTree();
        $this->responses[1] = $user->userData();
        $this->responses[2] = $notifications->notifications();
        
        $config = $this->model('config');
        $this->configLogo = $config->getConfig(1);
        $this->configPhone = $config->getConfig(2);
        $this->configMail = $config->getConfig(3);
    }
    
    public function index()
    {
        $this->view('brak_strony/index');
    }
    
    public function blad()
    {
        $this->view('konto_nieaktywne/index', ['menu'=>$this->responses[0],
            'user'=>$this->responses[1],
            'configLogo'=>$this->configLogo,
            'notification'=>$this->responses[2][13]]);
    }
    
    public function wygasla($date)
    {
        $this->view('konto_nieaktywne/index',
                ['menu'=>$this->responses[0],
                    'user'=>$this->responses[1],
                    'configLogo'=>$this->configLogo,
                    'notification'=>$this->responses[2][14]]); 
    }
}

