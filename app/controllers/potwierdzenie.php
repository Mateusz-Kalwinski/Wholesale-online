<?php
class Potwierdzenie extends Controller
{
    public function index()
    {
        if(!isset($_POST['orderMessage']))
        {
            header('Location:/');
            exit();
        }
        
        
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $apiDetailsModel = $this->model('api');
        $config = $this->model('config');

        $res = $menu->getTree();
        $res2 = $user->userData();
        $apiDetails = $apiDetailsModel->apiDetails(1);
        $configLogo = $config->getConfig(1);
        $configPhone = $config->getConfig(2);
        $configMail = $config->getConfig(3);

        

        $title = "Kontakt";
        $this->view('potwierdzenie/index', ['menu'=>$res, 'user'=>$res2,'title'=>$title,
                    'configPhone'=>$configPhone, 'configMail'=>$configMail,'configLogo'=>$configLogo,'orderNumber'=> html_entity_decode($_POST['orderMessage'])]);

    }
    }
