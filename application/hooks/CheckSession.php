<?php

if(!defined('BASEPATH'))
    exit('No direct script access allowed');

class CheckSession
{

    private $ci;


    public function __construct()
    {
        $this->ci = &get_instance();
    }


    public function checkLogin()
    {
        $controller = $this->ci->router->class;
        $module = $this->ci->router->module;

        if($module == 'management' && !isset($_SESSION[APP_SESSION]['id'])) {
            // redirect(base_url() . 'Login/');
        }

    }

}
