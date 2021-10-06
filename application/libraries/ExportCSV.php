<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportCSV
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
        $this->path = 'file_upload/temp_export_csv/';
		@mkdir($this->path);

	}

  	public function exportTocsv($curent_file, $data,$page=1)
    {

        $file_creat = $this->path.basename($curent_file, '.php') . '.csv';

        if ($page == 1) {
            @unlink($file_creat);
            fopen($file_creat, "w");
        	chmod($file_creat,0777);
        }

        if(!empty($data)){
        	foreach ($data as $line => $vv) {
	            foreach ($vv as $kk => $value_data) {

                    $value_data = str_replace("'",'',$value_data);
//                    $value_data = iconv("utf-8", "tis-620//TRANSLIT", $value_data);
	                $data_csv[$line][$kk] = (string)$value_data;
	            }
	        }

	        $this->exportPutCSV($file_creat, $data_csv);
        }

        return $file_creat;
    }


    function exportPutCSV($filepath, $data, $header = array())
    {
        if ($fp = fopen($filepath, 'a')) {
            fputs($fp, "\xEF\xBB\xBF");
            // fopen a : เขียนต่อท้าย โดยเปิดขึ้นมาแล้วเขียนต่อท้ายไฟล์ ถ้าไม่มีไฟล์จะสร้างไฟล์
            foreach ($data as $line) {
                fputcsv($fp, $line);
                fseek($fp, -1, SEEK_CUR);
                fwrite($fp, "");
            }
            fclose($fp);
        } else {
            return false;
        }
        return true;
    }

    public function getPercent($num_row, $all_row, $page)
    {
        $data = array();
        $num_row = $page > 1 ? ceil($page * $num_row) : $num_row;
        $percent = ceil(($num_row / $all_row) * 100);

        if($percent > 100){
            $percent = 100;
        }

        $data['percent'] = $percent;
        $data['page'] = ++$page;
        return $data;
    }

}

/* End of file ExportCSV.php */
/* Location: ./application/libraries/ExportCSV.php */
