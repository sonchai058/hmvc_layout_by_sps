<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends MDL_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        parent::view('index', []);
    }

}
