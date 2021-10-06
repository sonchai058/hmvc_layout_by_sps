<?php
class MY_Controller extends CI_Controller
{

    protected $cur_module;
    protected $cur_class;
    protected $cur_method;
    protected $val_lang = 'th';

    protected $session_data = APP_SESSION;

    public function __construct()
    {
        parent::__construct();
        // error_reporting(E_ERROR | E_PARSE);
        $this->cur_module = $this->router->module;
        $this->cur_class = $this->router->class;
        $this->cur_method = $this->router->method;

        $this->load->helper('counter_helper');

        $this->load->library('pagination');
        $this->load->library('CreateTable');
        $this->fnc_createTable();
        # start session
        $this->fnc_startCasSession();

        # load default model
        $this->fnc_loadDefaultModel();

        if(empty($this->start_no)) {
            $this->start_no = 0;
        }

        $Counter = new Counter;
        $Counter->counterMain();
    }

    private function fnc_startCasSession()
    {

        if($this->cur_class != 'Cas') {

            if(phpversion() >= 5.4) {
                if(session_status() == PHP_SESSION_NONE) session_start();
            } else {
                if(session_id() == '') session_start();
            }
        }
    }

    private function fnc_fileExists($path)
    {
        $exists = false;
        $arr = glob($path . "models/*.php");

        $arr = array_map(function ($ele) {
            $tmp = explode('/', $ele);
            return str_replace('.php', '', end($tmp));
        }, $arr);

        if(in_array($this->cur_class . '_model', $arr)) {
            $exists = true;
        }

        return $exists;
    }


    private function fnc_loadDefaultModel()
    {

        if($this->fnc_fileExists(APPPATH) || $this->fnc_fileExists(APPPATH . 'modules/' . $this->cur_module . '/')) {
            $this->load->model($this->cur_class . '_model', 'model');
        }
    }


    protected function view($views = null, $param = null)
    {

        $this->load->model('Index_model');

        $param['layout'] = "default";
        $param['cur_module'] = $this->cur_module;
        $param['cur_class'] = $this->cur_class;
        $param['cur_method'] = $this->cur_method;
        $param['action_link'] = base_url() . $this->cur_class . '/';
        $val_lang = $this->session->userdata('LANGUAGE');

        if ($val_lang == 'US')
           $val_lang = 'en';

        if (!empty($val_lang)) {
           $this->val_lang = strtolower($val_lang);
        }

        $this->config->set_item('lang', $this->val_lang);
        $param['val_lang'] = $this->val_lang;

        // _print_r($param['category_news']);
        $this->load->view($param['layout'] . '/header', $param);
        // _print_r($this->load->view($param['layout'] . '/header', $param));
        if($views != null) {
            $view_arr = explode(',', $views);

            if(file_exists(APPPATH . 'views/' . $param['layout'] . '/' . $view_arr[0] . '.php')) {
                foreach ($view_arr as $key => $view) {
                    if($view != '')
                        $this->load->view($param['layout'] . '/' . $view, $param);
                }
            } else {
                $this->load->view($param['layout'] . '/' . '404');
            }
        }

        $font_size = $this->session->userdata('font_size');
        if(!empty($font_size)) {
            $paramFooter['font_size'] = $font_size;
        } else {
            $paramFooter['font_size'] = 0;
        }
        $paramFooter['val_lang'] = $this->val_lang;
        $this->load->view($param['layout'] . '/' . 'footer', $paramFooter);
    }


    protected function createToken()
    {
        $this->load->library('user_agent');
        $agent = trim($this->agent->agent_string());

        $combine = array(
            session_id(),
            microtime(),
            $agent,
            base_url(),
            $this->cur_module,
            $this->cur_class,
            $this->cur_method,
            $this->input->ip_address(),
            sprintf('%05d', rand(0, 99999)),
            sprintf('%05d', rand(0, 99999)),
            sprintf('%05d', rand(0, 99999))
        );

        $str = json_encode($combine);

        return sha1($str);
    }


    protected function pagination($page, $total_rows, $per_page, $uri_segment, $url = false)
    {
        if($url == false)
            $config['base_url'] = base_url();
        else
            $config['base_url'] = $url;

        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $uri_segment;

        if($page == '' or $page <= '1') {
            $this->start_no = 0;
        } else {
            $this->start_no = (($page * $per_page) - $per_page);
        }

        $this->pagination->initialize($config);
        $this->my_pagination = $this->pagination->create_links();
    }


    protected function setSearchSession()
    {

        if($this->cur_method=='csv'){ //export API
                return;
        }
        ## ข้ามเมื่อมีการเรียน API ที่มี class เรียก setSearchSession ทำให้ค่าถูกเคลีย
        // $ignoredMethode = array('User.setUserExpired');
        // if(in_array($this->cur_class.'.'.$this->cur_method,$ignoredMethode)){
        //     return;
        // }

        if(!isset($_SESSION['form_search_element'])) {
            $_SESSION['form_search_element'] = array();
        }

        $form_search_element = $this->input->post('form_search_element');
        $reset = $this->input->post('reset');

        $config = array(
            'class' => $this->cur_class,
            'method' => $this->cur_method
        );

        if(is_array($form_search_element)) {
            $config['element'] = $form_search_element;
            $_SESSION['form_search_element'] = $config;

        }

        ## ดึงจากของเดิมที่เคยเก็บไว้
        // if(isset($_SESSION['all'][$this->cur_class][$this->cur_method])){
        //     $_SESSION['form_search_element'] =  $_SESSION['all'][$this->cur_class][$this->cur_method];
        // }


        $form_search_element = @$_SESSION['form_search_element'];

        if(is_array($form_search_element) && !empty($form_search_element)) {

            if(
                (isset($form_search_element['class']) && isset($form_search_element['method']))
                &&
                (
                    $this->cur_class != @$form_search_element['class']
                    || $this->cur_method != @$form_search_element['method']
                )
            ){

                $_SESSION['form_search_element'] = array();
            }
        }

        if($reset == 'clear') {
            $_SESSION['form_search_element'] = array();
            // $_SESSION['all'][$this->cur_class][$this->cur_method] = array();

        }

        // echo "<pre>".var_dump($_SESSION[APP_SESSION]['form_search_element'] )."</pre><br>";



    }

    private function fnc_getVisitor()
    {
      $this->db->select('SUM(num) as Total');
      $data = $this->db->get('counter_main')->row_array();

      if(!empty($data) && !empty($data['Total'])) {
        return number_format($data['Total']);
      } else {
        return 0;
      }
    }

    private function fnc_createTable()
    {
        $this->load->library('CreateTable');
        $this->createtable->createTable('um_app_group', '
          `grp_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `grp_name` varchar(250) DEFAULT NULL,
          PRIMARY KEY (`grp_id`)
        ');

        $this->createtable->createTable('um_app_info', '
          `app_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `grp_id` tinyint(3) unsigned DEFAULT "1",
          `app_name` varchar(250) DEFAULT NULL,
          `parent_id` int(11) unsigned DEFAULT "0",
          `module` varchar(250) DEFAULT NULL,
          `class` varchar(250) DEFAULT NULL,
          `method` varchar(250) DEFAULT NULL,
          `param` varchar(250) DEFAULT NULL,
          `icon` varchar(250) DEFAULT NULL,
          `menu_order` int(11) unsigned DEFAULT "1",
          `show_menu` tinyint(2) unsigned DEFAULT "1",
          PRIMARY KEY (`app_id`)
        ');

        $this->createtable->createTable('um_app_priv', '
          `usys_id` int(11) unsigned NOT NULL,
          `app_id` int(11) unsigned NOT NULL,
          PRIMARY KEY (`usys_id`,`app_id`)
        ');

        $this->createtable->createTable('um_app_priv_group', '
          `usys_id` int(11) unsigned NOT NULL,
          `app_id` int(11) unsigned NOT NULL,
          PRIMARY KEY (`usys_id`,`app_id`)
        ');

        $this->createtable->createTable('users', '
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `username` varchar(250) DEFAULT NULL,
          `password` varchar(250) DEFAULT NULL,
          `prename` varchar(250) DEFAULT NULL,
          `fname` varchar(250) DEFAULT NULL,
          `lname` varchar(250) DEFAULT NULL,
          `grp_id` int(11) unsigned DEFAULT "99",
          `status` int(1) unsigned DEFAULT "1",
          `email` varchar(250) DEFAULT NULL,
          `tel` varchar(250) DEFAULT NULL,
          `idcard` varchar(13) DEFAULT NULL,
          `sex` varchar(10) DEFAULT NULL,
          `position` varchar(250) DEFAULT NULL,
          `time_create` datetime DEFAULT NULL,
          PRIMARY KEY (`id`) USING BTREE
        ');

        $this->createtable->addColumn('news', 's_order', 'INT(11)');
        $this->createtable->addColumn('category_news', 's_order', 'INT(11)');

        $this->createtable->createTable('cookie_text','
          `id` INT NOT NULL AUTO_INCREMENT,
          `detail` TEXT,
          `detail_en` TEXT,
          `time_create` DATETIME,
          `show_status` INT(1) DEFAULT 1,
          PRIMARY KEY (id)'
        );

        $this->createtable->addColumn('users', 'is_ad', 'INT(1) DEFAULT 0');
        $this->createtable->addColumn('bg_search', 'file_path_night', 'varchar(255) DEFAULT NULL');
        $this->createtable->addColumn('bg_search', 'file_name_night', 'text');
        $this->createtable->addColumn('bg_search', 'file_name_original_night', 'varchar(255) DEFAULT NULL');
        $this->createtable->addColumn('bg_search', 'file_name_original_night', 'varchar(255) DEFAULT NULL');
        $this->createtable->addColumn('bg_search', 'time_night', 'time DEFAULT NULL');

        $this->createtable->addColumn('news_doc', 's_order', 'INT(11) DEFAULT 0');
        $this->createtable->addColumn('news_doc', 'is_cover', 'INT(1) DEFAULT 0');

        $this->createtable->addColumn('cookie_text', 'type_menu', 'int(1) DEFAULT NULL');
        $this->createtable->addColumn('cookie_text', 'url', 'VARCHAR(250)');
        $this->createtable->addColumn('cookie_text', 'file_path', 'VARCHAR(250)');
        $this->createtable->addColumn('cookie_text', 'file_name', 'VARCHAR(250)');

        $this->createtable->createTable('manage_related_agencies','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(250),
          `title_en` VARCHAR(250),
          `url` TEXT,
          `image` TEXT,
          `img_path` TEXT,
          `show_status` TEXT,
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id)'
        );

        $this->createtable->addColumn('pop_up', 'type_date_show', 'INT(1) DEFAULT 1');
        $this->createtable->addColumn('pop_up', 'date_show_start', 'DATETIME');
        $this->createtable->addColumn('pop_up', 'date_show_end', 'DATETIME');

        $this->createtable->createTable('manage_database_store','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(250),
          `title_en` VARCHAR(250),
          `description` TEXT,
          `description_en` TEXT,
          `url` TEXT,
          `show_status` TEXT,
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id)'
        );

        $this->createtable->createTable('manage_database_store_type','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `fld_value` VARCHAR(250),
          `fld_value_en` VARCHAR(250),
          `type_store` TEXT,
          `time_create` DATETIME,
          `user_create` INT(11),
          PRIMARY KEY (id)'
        );

        $this->createtable->createTable('manage_database_store_data','
          `id` INT(11),
          `id_store` INT(11),
          `type_store` TEXT,
          PRIMARY KEY (id, id_store)'
        );

        $this->createtable->createTable('manage_resume','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `prename` VARCHAR(100),
          `prename_en` VARCHAR(100),
          `first_name` VARCHAR(250),
          `first_name_en` VARCHAR(250),
          `last_name` VARCHAR(250),
          `last_name_en` VARCHAR(250),
          `position` TEXT,
          `position_en` TEXT,
          `email` VARCHAR(250),
          `affiliated` TEXT,
          `affiliated_en` TEXT,
          `tel_private` VARCHAR(50),
          `tel_work` VARCHAR(50),
          `short_history` MEDIUMTEXT,
          `short_history_en` MEDIUMTEXT,
          `education` MEDIUMTEXT,
          `education_en` MEDIUMTEXT,
          `subject_librarian` MEDIUMTEXT,
          `subject_librarian_en` MEDIUMTEXT,
          `experience` MEDIUMTEXT,
          `experience_en` MEDIUMTEXT,
          `academic` MEDIUMTEXT,
          `academic_en` MEDIUMTEXT,
          `award` MEDIUMTEXT,
          `award_en` MEDIUMTEXT,
          `file_path` TEXT,
          `file_name` TEXT,
          `file_name_original` TEXT,
          `time_upload` DATETIME,
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id)'
        );


        $this->createtable->createTable('manage_director','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `id_resume` INT(11),
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id, id_resume)'
        );

        $this->createtable->addColumn('manage_director', 'prename', 'VARCHAR(100)');
        $this->createtable->addColumn('manage_director', 'prename_en', 'VARCHAR(100)');
        $this->createtable->addColumn('manage_director', 'position', 'TEXT');
        $this->createtable->addColumn('manage_director', 'position_en', 'TEXT');

        $this->createtable->createTable('manage_executive','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `id_resume` INT(11),
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id, id_resume)'
        );

        $this->createtable->createTable('manage_executive_director','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `id_resume` INT(11),
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id, id_resume)'
        );

        $this->createtable->createTable('manage_expert','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `id_resume` INT(11),
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id, id_resume)'
        );

        $this->createtable->createTable('manage_faction_personnel','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `faction` TEXT,
          `faction_en` TEXT,
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id)'
        );

        $this->createtable->createTable('manage_personnel','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `id_faction` INT(11),
          `id_resume` INT(11),
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id, id_faction, id_resume)'
        );

        $this->createtable->createTable('manage_expert','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `id_resume` INT(11),
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id, id_resume)'
        );

        $this->createtable->createTable('manage_expert_topic','
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `id_expert` INT(11),
          `topic` TEXT,
          `topic_en` TEXT,
          `url` TEXT,
          `show_status` INT(1),
          `time_create` DATETIME,
          `s_order` INT(11) DEFAULT 0,
          PRIMARY KEY (id, id_expert)'
        );
    }
}
