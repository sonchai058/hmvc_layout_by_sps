<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateTable
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function createTable($table, $structure)
    {

        $this->ci->db->query("
            CREATE TABLE IF NOT EXISTS ".$table." (".$structure.") ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
        ");
    }

    public function addColumn($table, $filed, $type)
    {
        $exist = ($this->ci->db->field_exists($filed, $table)) ? false : true;
        if ($exist) {
            $this->ci->db->query("ALTER TABLE ".$table." ADD COLUMN ".$filed." ".$type."");
        }
    }

}

/* End of file ExportCSV.php */
/* Location: ./application/libraries/ExportCSV.php */
