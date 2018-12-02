<?php

class App
{
    
    protected $controller='home';
    protected $method='index';
    protected $params=[];
    
    public function __construct()
    {
        $url=$this->parseUrl();
        
        $_SESSION['lang']=$url[0];

        unset($url[0]);
        
        if(!isset($url[1]))
        {
            $url[1]='';
        }
        
        if(file_exists('../app/controllers/'.$url[1].'.php'))
        {
            $this->controller=$url[1];
            unset($url[1]);
        }
        
        require_once '../app/controllers/'.$this->controller.'.php';
        $this->controller=new $this->controller;
        
        if(isset($url[2]))
        {
            if(method_exists($this->controller,$url[2]))
            {
                $this->method=$url[2];
                unset($url[2]);
            }
        }
        
       $this->params= $url ? array_values($url): [];
       
       call_user_func_array([$this->controller, $this->method],$this->params);
    }
    
    public function parseUrl()
    {
        if(isset($_GET['url']))
        {
            $url=rtrim($_GET['url'],'/'); 
            $url=filter_var($url,FILTER_SANITIZE_URL);
            $url=str_replace('-','_',$url);
            $url=explode('/',$url);

            return $url;   
        }
    }
}
