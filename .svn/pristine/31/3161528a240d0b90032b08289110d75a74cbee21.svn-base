<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Codeigniter PHP framework library class for dealing with gettext.
 *
 * @package     CodeIgniter
 * @subpackage    Libraries
 * @category    Language
 * @author    Marko Martinović <marko@techytalk.info>
 * @link    https://github.com/Marko-M/codeigniter-gettext
 */
class Gettext
{

    /**
     * Initialize gettext inside Codeigniter PHP framework.
     *
     * @param array $config Override default configuration
     */
    public function __construct()
    {

        $locale = "th_TH";
        $CI = &get_instance();
        
        // $val_lang = $CI->session->userdata('LANGUAGE');
        $val_lang = @$_SESSION['LANGUAGE'];



        if(isset($val_lang)) {
            if($val_lang == '') {
                $val_lang = 'TH'; // set Default
            }
        } else {
            $val_lang = 'TH'; // no valiable val_lang set to TH
        }

        if($val_lang == 'TH' || $val_lang == '') {
            $locale = "th_TH";
        } else {
            $locale = "en_US";
        }

        $locale = $locale . ".utf8";

        // define constants
        define('PROJECT_DIR', realpath('./'));
        define('LOCALE_DIR', PROJECT_DIR . '/locale');
        define('DEFAULT_LOCALE', $locale);
        //die(LOCALE_DIR);

        require_once(realpath('./') . '/application/libraries/php_gettext/gettext.inc');

        $encoding = 'UTF-8';

        T_setlocale(LC_MESSAGES, $locale);

        $domain = 'msg';
        _bindtextdomain($domain, LOCALE_DIR);

        _bind_textdomain_codeset($domain, $encoding);
        _textdomain($domain);
    }

}

/* End of file Gettext.php */
