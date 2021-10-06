<?php

/**
 *
 */
class Index_model extends CI_model
{
    private $users_tbl = 'users';
    private $session_data = 'cmu_web_session';
    private $prev_tbl = 'um_app_priv';
    private $prev_group_tbl = 'um_app_priv_group';

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');

    }
}

?>
