<?php

class Counter
{

    private $cook_prename = '';
    private $cook_time = 7200;  // 2 ชั่วโมง
    private $ci;


#============================================================

    function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->library('CreateTable');
    }

#============================================================

#============================================================

    private function genCookies($name_type)
    {

        $name = $this->cook_prename . '_counter_' . $name_type;

        if(empty($_COOKIE[$name])) {

            return setcookie($name, "1", time() + $this->cook_time);

        } else {

            return false;

        }

        exit;

    }

#============================================================

#============================================================

    public function counterMain($cook_name = 'main')
    {

        $table = 'counter_main';

        $this->ci->createtable->createTable($table, '
        c_date date NOT NULL,
        num int,
        PRIMARY KEY(c_date)');

        if($this->genCookies($cook_name)) {

            $c_date = date('Y-m-d');

            $sql = "insert into {$table} (c_date,num) values ('$c_date','1') on duplicate key update num=num+1";

            $this->ci->db->query($sql);

        }

    }

#============================================================

#============================================================

    public function counterPage($table, $pk, $cook_name = 'main')
    {

        $table1 = 'counter_' . $table;

        $this->ci->createtable->createTable($table1, '
        c_date date NOT NULL,
        record_id int,
        num int,
        PRIMARY KEY(c_date,record_id)');

        $table2 = 'counter_' . $table . '_all';###ใช้ในหน้า Analysis/top10 เฉพาะ dfc

        $this->ci->createtable->createTable($table2, '
        record_id int,
        num int,
        PRIMARY KEY(record_id,site_id)');

        if($this->genCookies($table . $pk)) {

            $c_date = date('Y-m-d');

            $sql = "insert into {$table1} (c_date,record_id,num) values ('$c_date','{$pk}','1') on duplicate key update num=num+1";

            $this->ci->db->query($sql);

            ###ไม่เก็บวัน

            $sql2 = "insert into {$table2} (record_id,num) values ('{$pk}','1') on duplicate key update num=num+1";

            $this->ci->db->query($sql2);

        }

    }

#============================================================

#============================================================

    public function counterDownload($table, $record_id, $doc_id)
    {

        $table1 = 'counter_' . $table;

        $this->ci->createtable->createTable($table1, '
        c_date date NOT NULL,
        record_id int,
        doc_id int,
        num int,
        PRIMARY KEY(c_date,record_id,doc_id)');


        $c_date = date('Y-m-d');

        $sql = "insert into {$table1} (c_date, record_id, doc_id, num) values ('{$c_date}','{$record_id}', '{$doc_id}','1') on duplicate key update num=num+1";

        $this->ci->db->query($sql);

        $table2 = 'counter_' . $table . '_all';

        $this->ci->createtable->createTable($table2, '
        record_id int,
        doc_id int,
        num int,
        PRIMARY KEY(c_date,record_id,doc_id)');

        $sql2 = "insert into {$table2} (record_id, num) values ('{$record_id}','1') on duplicate key update num=num+1";

        $this->ci->db->query($sql2);

    }

#============================================================

#============================================================

    public function logDownload($table, $record_id, $doc_id, $user_id = false)
    {
        $ip = "";
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $ip = ($ip > "") ? $_SERVER['REMOTE_ADDR'] . "/$ip" : $_SERVER['REMOTE_ADDR'];

        $table1 = 'log_' . $table;

        $this->ci->createtable->createTable($table1, '
        c_date date NOT NULL,
        c_date_time datetime NOT NULL,
        record_id int,
        doc_id int,
        user_id int,
        ip varchar(100) default NULL,
        num int,
        PRIMARY KEY(c_date,record_id,doc_id,ip,user_id)');

        $c_date = date('Y-m-d');
        $c_date_time = date('Y-m-d H:i:s');
        $sql = "insert into {$table1} (c_date,c_date_time,record_id, doc_id, num,ip,user_id) values ('{$c_date}','{$c_date_time}','{$record_id}', '{$doc_id}','1','$ip','$user_id') on duplicate key update c_date_time='{$c_date_time}',num=num+1";
        $this->ci->db->query($sql);

    }

#============================================================
#============================================================

    public function counterKeyword($keyword)
    {

        $table = 'counter_keyword';

        $this->ci->createtable->createTable($table, '
        c_date date NOT NULL,
        keyword varchar(250),
        num int,
        PRIMARY KEY(c_date,keyword)');

        $c_date = date('Y-m-d');

        $keyword = trim($keyword);

        $sql = "insert into {$table} (c_date,keyword,num) values ('{$c_date}','{$keyword}','1') on duplicate key update num=num+1";

        $this->ci->db->query($sql);

    }

#============================================================

#============================================================

    public function getClientIP()
    {
        $ipaddress = '';

        if(isset($_SERVER['HTTP_CLIENT_IP']))

            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];

        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))

            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

        else if(isset($_SERVER['HTTP_X_FORWARDED']))

            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];

        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))

            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

        else if(isset($_SERVER['HTTP_FORWARDED']))

            $ipaddress = $_SERVER['HTTP_FORWARDED'];

        else if(isset($_SERVER['REMOTE_ADDR']))

            $ipaddress = $_SERVER['REMOTE_ADDR'];

        else

            $ipaddress = 'UNKNOWN';

        return $ipaddress;

    }

    public function logAction($title, $pk, $category_pk, $type_module, $type_action, $user_id = false)
    {
        $ip = $this->getClientIP();
        $table1 = 'log_action';
        $this->ci->createtable->createTable($table1, 'c_date date NOT NULL,
        c_date_time datetime NOT NULL,
        title VARCHAR(255),
        pk int,
        category_pk int,
        type_module VARCHAR(255),
        type_action int,
        user_id int,
        name VARCHAR(250),
        ip varchar(100) default NULL');

        $c_date = date('Y-m-d');
        $c_date_time = date('Y-m-d H:i:s');

        $this->ci->db->select('CONCAT(prename, fname, " ", lname) as name');
        $this->ci->db->where('id', $user_id);
        $setData = $this->ci->db->get('users')->row_array();

        $name = 'บุคคลภายนอก';
        if(!empty($setData) && !empty($setData['name'])) {
          $name = $setData['name'];
        }

        $sql = "insert into {$table1}(c_date, c_date_time, title, pk, category_pk,type_module, type_action, user_id, name, ip)values('{$c_date}','{$c_date_time}','".$this->ci->db->escape_str($title)."', '{$pk}', '{$category_pk}','{$type_module}', '{$type_action}' ,'$user_id', '".$this->ci->db->escape_str($name)."', '$ip')";
        $this->ci->db->query($sql);

    }

    public function counterPageInfo($type, $pk, $site_id, $cook_name = 'main')
    {


        $table1 = 'counter_page_info';

        // $this->ci->createtable->createTable($table1, 'c_date date NOT NULL,
        //                             type varchar,
        //                             record_id int,
        //                             site_id int,
        //                             num int,
        //                              PRIMARY KEY(c_date,record_id,site_id,type)');

        $this->ci->createtable->createTable($table1, '
        c_date date NOT NULL,
        type varchar(255),
        record_id int,
        site_id int,
        num int,
        PRIMARY KEY(c_date,type,record_id,site_id)');

        $table2 = 'counter_page_info_all';###ใช้ในหน้า Analysis/top10 เฉพาะ dfc

        $this->ci->createtable->createTable($table2, 'record_id int,

                                type varchar(255),

                                site_id int,

                                num int,

                                 PRIMARY KEY(record_id,site_id,type)');

        if ($this->genCookies($type . $pk . $site_id)) {

            $c_date = date('Y-m-d');

            $sql = "insert into {$table1}(c_date,record_id,num,site_id,type)values('$c_date','{$pk}','1','$site_id','$type') on duplicate key update num=num+1";

            $this->ci->db->query($sql);

            ###ไม่เก็บวัน

           $sql2 = "insert into {$table2}(record_id,num,site_id,type)values('{$pk}','1','$site_id','$type') on duplicate key update num=num+1";

            $this->ci->db->query($sql2);

        }

    }

}



# END CLASS =======================================================================

?>
