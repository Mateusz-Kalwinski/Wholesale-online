<?php

class Kategorie extends Controller
{
    public function index()
    {
        $user = $this->model('user');
        $config = $this->model('config');

        $configLogo = $config->getConfig(1);
        $userData=$user->userData();

        $categoriesModel=$this->model('category');
        $categories=$categoriesModel->listCategory();






        $this->view('kategorie/index',
        ['configLogo'=>$configLogo,'user'=>$userData,'news'=>$news,'categories'=>$categories]);
    }
}
