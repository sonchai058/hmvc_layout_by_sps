<?php

class MDL_Controller extends MY_Controller
{

    protected $main_link;
    protected $action_link;
    private $active_app = [];
    private $priv = [];
    private $grop_tbl = 'um_app_group';
    private $app_tbl = 'um_app_info';

    public function __construct()
    {
        parent::__construct();

        $this->main_link = base_url() . $this->cur_module . '/';
        $this->action_link = $this->main_link . $this->cur_class . '/';
        $this->fnc_setAcitveApp();
    }


    public function view($view = null, $data = null)
    {
        # กำหนดค่า path ต่างๆ เข้าไปใน view
        $param['layout'] = "/views";
        $param['cur_module'] = $this->cur_module;
        $param['cur_class'] = $this->cur_class;
        $param['cur_method'] = $this->cur_method;
        $param['action_link'] = base_url() . $this->cur_module . '/' . $this->cur_class . '/';
        $param['session_data'] = $this->session->userdata($this->session_data);
        $param['getMenu'] = $this->fnc_getPriv($param['session_data']);
        $this->load->view('../modules/' . $this->cur_module . $param['layout'] . '/header', $param);

        $sub_view = explode(',', $view);
        if ($view != '') {
            foreach ($sub_view as $vv) {
                $this->load->view('../modules/' . $this->cur_module . $param['layout'] . '/' . $vv, $data);
            }
        }

        $this->load->view('../modules/' . $this->cur_module . $param['layout'] . '/footer');

    }

    private function fnc_setAcitveApp()
    {
        $tmp = explode('/', base_url());
        $tmp = array_filter($tmp);

        $this->active_app = [
            'module' => $this->cur_module,
            'class' => $this->cur_class,
            'method' => $this->cur_method,
            'param' => $this->uri->segment(4)
        ];

    }


    private function fnc_getPriv($session)
    {
        if(!empty($session) && !empty($session['priv'])) {
          $this->priv = $session['priv'];
          $this->checkApp();
          return $this->fnc_getApp();
        } else {
          return [];
        }
    }

    private function fnc_getApp()
    {
        $this->db->order_by('grp_id', 'asc');
        $data = $this->db->get($this->grop_tbl)->result_array();
        $app = [];
        foreach ($data as $value) {
            $menu = $this->fnc_getMenu($value['grp_id']);
            if(count($menu) > 0) {
                $app[] = [
                    'name' => $value['grp_name'],
                    'menu' => $menu
                ];
            }
        }
        // _print_r($app);
        return $app;
    }

    private function fnc_getMenu($grp_id)
    {
        $this->db->where('grp_id', $grp_id);
        $this->db->where('parent_id', 0);
        $this->db->order_by('menu_order asc');
        $data = $this->db->get($this->app_tbl)->result_array();
        $menu = [];
        $subMenuData = [];

        foreach ($data as $value) {
            $subDataMenu = $this->fnc_getSubMenu($value['app_id']);
            $submenu = $subDataMenu['submenu'];
            if(count($submenu) > 0 || in_array($value['app_id'], $this->priv)) {
                $link = $this->fnc_createLink($value);
                $active = false;
                if($link != '') {
                    $active = $this->fnc_isActive($value);
                }

                if(empty($active)) {
                  $active = $subDataMenu['active'];
                }

                if(!empty($submenu)) {
                  $subMenuData[] = [
                      'app_id' => $value['app_id'],
                      'name' => $value['app_name'],
                      'icon' => $value['icon'],
                      'link' => $link,
                      'active' => $active,
                      'submenu' => $submenu
                  ];
                } else {
                  $menu[] = [
                      'app_id' => $value['app_id'],
                      'name' => $value['app_name'],
                      'icon' => $value['icon'],
                      'link' => $link,
                      'active' => $active,
                      'submenu' => $submenu
                  ];
                }
            }

        }

        return array_merge($menu, $subMenuData);
    }

    private function fnc_getSubMenu($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('menu_order', 'asc');

        $data = $this->db->get($this->app_tbl)->result_array();
        $activeData = false;
        $submenu = [];
        foreach ($data as $value) {

            if(!in_array($value['app_id'], $this->priv)) continue;
            $active = $this->fnc_isActive($value);
            $submenu[] = [
                'app_id' => $value['app_id'],
                'name' => $value['app_name'],
                'link' => $this->fnc_createLink($value),
                'active' => $active
            ];

            if(empty($activeData) && $active) {
              $activeData = true;
            }
        }

        return [
          'submenu' => $submenu,
          'active' => $activeData
        ];
    }

    private function fnc_createLink($data)
    {

        $link = '';
        if($data['parent_id'] != 0 || $data['class'] != '') {

            if($data['method'] == '') {
                $data['method'] = 'index';
            }

            $link = $data['module'] . '/';
            $link .= $data['class'] . '/';
            $link .= $data['method'];

            if($data['param'] != '') {
                $link .= '/' . $data['param'];
            }

        }

        return $link;

    }


    private function fnc_isActive($data)
    {

        $active = false;
        if(
            $data['module'] == $this->active_app['module'] &&
            $data['class'] == $this->active_app['class'] &&
            ($data['param'] == '' || $data['param'] == $this->active_app['param'])
        ) {
            $active = true;
        }

        return $active;
    }

    private function fnc_getAppID()
    {
        $this->db->select('app_id,param');
        $this->db->where('module', $this->active_app['module']);
        $this->db->where('class', $this->active_app['class']);

        $rs = $this->db->get($this->app_tbl)->result_array();

        $app_id = 0;
        $num_rows = count($rs);

        if($num_rows == 1) {
            $app_id = $rs[0]['app_id'];
        } else if($num_rows > 1) {

            foreach ($rs as $value) {
                if(
                    $this->active_app['param'] != '' &&
                    $this->active_app['param'] == $value['param']
                ) {
                    $app_id = $value['app_id'];
                    break;
                }
            }

            if($app_id == 0) {

                if($this->active_app['param'] == '') {
                    $app_id = $rs[0]['app_id'];
                } else {
                    $app_id = -1;
                }
            }

        }

        return $app_id;
    }

    public function checkApp()
    {
        $app_id = $this->fnc_getAppID();
        if($app_id != 0 && !in_array($app_id, $this->priv)) {
            echo '<script>
            window.alert("ขออภัยท่านไม่มีสิทธิในการเข้าใช้เมนูนี้");
            window.location.href = "'.base_url().'management/Index";
            </script>';
        }
    }
}
