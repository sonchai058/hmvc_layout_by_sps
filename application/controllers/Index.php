<?php
/**
 * Created by PhpStorm.
 * User: Sarawut
 * Date: 27/6/2018 AD
 * Time: 10:36
 */

class Index extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
        $data['csrfmiddlewaretoken'] = $this->createToken();
        $_SESSION['csrfmiddlewaretoken'] = $data['csrfmiddlewaretoken'];
        parent::view('login', $data);
        
    }
}
