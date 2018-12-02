<?php
class Kontakt extends Controller
{
    public function index()
    {

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
        $configCode = $config->getConfig(4);
        $configPlace = $config->getConfig(5);
        $configAddress = $config->getConfig(6);
        $configCompanyName = $config->getConfig(11);
        $configAcountNumber = $config->getConfig(12);
        $configAcountData = $config->getConfig(13);
        
        $title = "Kontakt";
        $this->view('kontakt/index', ['menu'=>$res, 'user'=>$res2,'title'=>$title,
                    'configPhone'=>$configPhone, 'configMail'=>$configMail,'configLogo'=>$configLogo, 'configCode'=>$configCode, 'configPlace'=>$configPlace,
                    'configAddress'=>$configAddress, 'configCampanyName'=>$configCompanyName, 'configAcountNumber'=>$configAcountNumber,
                     'configAcountData'=>$configAcountData, 'apiDetails' => $apiDetails]);

    }
    }
