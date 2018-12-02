<?php

class Informacja_o_systemie extends Controller
{
    public function index()
    {
        $menu =  $this->model('menuTest');
        $user = $this->model('user');
        $config = $this->model('config');
        $clientsModel=$this->model('clients');
        $infoDetailsModel = $this->model('information');
        
        $configLogo = $config->getConfig(1);
        
        $infoModel=$this->model('information');
        $licenseInfo=$infoModel->infoLicense();
        
        $userData=$user->userData();
        $clientsQuanity=sizeof($clientsModel->listClients());
        

        $infoDetails = $infoDetailsModel->infoDetails();
        $this->view
        (
           'informacja_o_systemie/index',
           [
               'configLogo'=>$configLogo,
               'user'=>$userData,
               'clientsQuanity'=>$clientsQuanity,
               'licenseInfo'=>$licenseInfo,
               'infoDetails' => $infoDetails
           ]
        );
    }
}
