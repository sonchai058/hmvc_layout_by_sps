<?php

class MDL_Controller extends MY_Controller
{

    protected $main_link;
    protected $action_link;

    public function __construct()
    {
        parent::__construct();

        $this->main_link = base_url().$this->cur_module.'/';
        $this->action_link = $this->main_link.$this->cur_class.'/';
    }


    public function view($view = null, $data = null)
    {
        # กำหนดค่า path ต่างๆ เข้าไปใน view
        $param['layout'] = "/views";
        $param['cur_module'] = $this->cur_module;
        $param['cur_class'] = $this->cur_class;
        $param['cur_method'] = $this->cur_method;
        $param['action_link'] = base_url() . $this->cur_module . '/' . $this->cur_class . '/';

        $this->load->view('../modules/' . $this->cur_module . $param['layout'] . '/header', $param);

        $sub_view = explode(',', $view);
        if ($view != '') {
            foreach ($sub_view as $vv) {
                $this->load->view('../modules/' . $this->cur_module . $param['layout'] . '/' . $vv, $data);
            }
        }

        $this->load->view('../modules/' . $this->cur_module . $param['layout'] . '/footer');

    }
}
