<?php

class General
{

    public static function DBtoThaiDate($d)
    {
        if($d == "0000-00-00" || $d == "00-00-0000" || $d == "" || is_null($d))
            return "";
        $x = explode("-", $d);

        if(intval($x[0]) < 2200) {
            $year = ((intval($x[0])) + 543);
        } else {
            $year = intval($x[0]);
        }
        return ($x[2] . "/" . $x[1] . "/" . $year);
    }

    public static function DBtoThaiDateDath($d)
    {
        if($d == "0000-00-00" || $d == "00-00-0000" || $d == "" || is_null($d))
            return "";
        $x = explode("-", $d);

        if(intval($x[0]) < 2200) {
            $year = ((intval($x[0])) + 543);
        } else {
            $year = intval($x[0]);
        }
        return ($x[2] . "-" . $x[1] . "-" . $year);
    }

    public static function DBtoThaiDateDathTime($d)
    {
        if($d == "0000-00-00" || $d == "00-00-0000" || $d == "" || is_null($d))
            return "";
        $da = explode(" ", $d);
        $x = explode("-", $da[0]);
        if(intval($x[0]) < 2200) {
            $year = ((intval($x[0])) + 543);
        } else {
            $year = intval($x[0]);
        }
        return ($x[2] . "-" . $x[1] . "-" . $year.' '.$da[1]);
    }


    public static function ThaitoDBDate($d)
    {
        if($d == "")
            return "";
        $x = explode("/", $d);

        if(intval($x[2]) > 2200) {
            $year = ((intval($x[2])) - 543);
        } else {
            $year = intval($x[2]);
        }
        return ($year . "-" . $x[1] . "-" . $x[0]);
    }

    public static function ThaitoDBDateDath($d)
    {
        if($d == "")
            return "";
        $x = explode("-", $d);

        if(intval($x[2]) > 2200) {
            $year = ((intval($x[2])) - 543);
        } else {
            $year = intval($x[2]);
        }
        return ($year . "-" . $x[1] . "-" . $x[0]);
    }


    public static function ThaitoDBDateDathTime($d)
    {
        if($d == "")
            return "";

        $da = explode(" ", $d);
        $x = explode("-", $da[0]);

        if(intval($x[2]) > 2200) {
            $year = ((intval($x[2])) - 543);
        } else {
            $year = intval($x[2]);
        }
        return ($year . "-" . $x[1] . "-" . $x[0].' '.$da[1]);
    }


    public static function dayThai($temp)
    {
        if($temp != "0000-00-00" && $temp > "") {
            $month = array("??????????????????", "??????????????????????????????", "??????????????????", "??????????????????", "?????????????????????", "????????????????????????", "?????????????????????", "?????????????????????", "?????????????????????", "??????????????????", "???????????????????????????", "?????????????????????");
            $num = explode("-", $temp);
            if($num[0] == "0000") {
                $date = "?????????????????????";
            } else {
                if($num[0] < 2400)
                    $num[0] += 543;
                $date = intval($num[2]) . " " . $month[$num[1] - 1] . " " . $num[0];
            }
        } else {
            $date = "";
        }
        return $date;
    }


    public static function dayThai2($temp)
    {
        $date = "?????????????????????";

        if($temp != "0000-00-00" && $temp != '') {
            $month = array("???.???.", "???.???.", "??????.???.", "??????.???.", "???.???.", "??????.???.", "???.???.", "???.???.", "???.???.", "???.???.", "???.???.", "???.???.");
            $num = explode("-", $temp);
            if($num[0] == "0000") {
                $date = "?????????????????????";
            } else {
                if($num[0] < 2200)
                    $num[0] += 543;
                @$date = intval($num[2]) . " " . $month[$num[1] - 1] . " " . $num[0];
            }
        } else {
            $date = "?????????????????????";
        }
        return $date;
    }


    public static function dayThai3($temp)
    {
        if($temp != "0000/00/00" && $temp != '') {
            $month = array("???.???.", "???.???.", "??????.???.", "??????.???.", "???.???.", "??????.???.", "???.???.", "???.???.", "???.???.", "???.???.", "???.???.", "???.???.");
            $num = explode("/", $temp);
            if($num[2] == "0000") {
                $date = "?????????????????????";
            } else {
                if($num[2] < 2200)
                    $num[2] += 543;
                $date = intval($num[0]) . " " . $month[$num[1] - 1] . " " . $num[2];
            }
        } else {
            $date = "?????????????????????";
        }
        return $date;
    }


    public static function dayEng($temp)
    {
        if($temp != "0000-00-00" && $temp != '') {
            $month = array("Jan", "Feb", "Mar", "Apr", "MAy", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
            $num = explode("-", $temp);
            if($num[0] == "0000") {
                $date = "No Time";
            } else {
                if($num[0] < 2200)
                    $num[0];
                $date = intval($num[2]) . " " . $month[$num[1] - 1] . " " . $num[0];
            }
        } else {
            $date = "?????????????????????";
        }
        return $date;
    }


    public static function dateTimeThai($temp)
    {
        if($temp == "0000-00-00 00:00:00" || $temp == '') {
            return '?????????????????????';
        } else {

            $tmp_arr = explode(' ', $temp);
            return self::dayThai2($tmp_arr[0]) . ' / ' . substr($tmp_arr[1], 0, -3) . ' ???.';
        }
    }


    public static function dateTimeThaiFull($temp)
    {

        if($temp == "0000-00-00 00:00:00" || $temp == '') {
            return '?????????????????????';
        } else {

            $tmp_arr = explode(' ', $temp);
            return self::dayThai($tmp_arr[0]) . ' / ' . substr($tmp_arr[1], 0, -3) . ' ???.';
        }
    }


    public static function timeThai($temp)
    {
        return substr($temp, 0, -3) . ' ???.';
    }


    public static function dateTime_th($temp)
    {
        $tmp_arr = explode(' ', $temp);
        return self::dayThai2($tmp_arr[0]) . ' / ' . substr($tmp_arr[1], 0, -3) . ' ???.';
    }


    public static function dateTime_en($temp)
    {
        $tmp_arr = explode(' ', $temp);
        return self::dayEng($tmp_arr[0]) . ' at  ' . substr($tmp_arr[1], 0, -3) . ' .';
    }


    /**
     * ????????????????????? Set ?????? ???.???
     */
    public static function set_year_thai($year)
    {
        if($year==''){
            return '?????????????????????';
        }


        if($year > 0 && $year<=date('Y')) {
            return $year = $year + 543;
        } else {
            return self::thainumDigit($year);
        }

    }

    public static function thainumDigit($num){
        return str_replace(
                           array( "o" , "???" , "???" , "???" , "???" , "???" , "???" , "???" , "???" , "???" ),
                           array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ),
                           $num);
    }


    public static function getSiteName($site)
    {
        $tmp = explode(('/'), $site);
        return $tmp['0'];
    }


    function set_mount($mount = false)
    {
        if($mount != false) {
            $mount = date('Y-' . $mount . '-' . '01');
            $strMonth = date("n", strtotime($mount));
            $strMonthCut = Array("", "??????????????????", "??????????????????????????????", "??????????????????", "??????????????????.", "?????????????????????", "????????????????????????", "?????????????????????", "?????????????????????", "?????????????????????", "??????????????????.", "???????????????????????????", "?????????????????????");
            $strMonthThai = $strMonthCut[$strMonth];
            return " $strMonthThai ";
        } else {
            return " - ";
        }
    }


    public static function getMonthName($num)
    {
        $strMonthCut = Array("", "??????????????????", "??????????????????????????????", "??????????????????", "??????????????????.", "?????????????????????", "????????????????????????", "?????????????????????", "?????????????????????", "?????????????????????", "??????????????????.", "???????????????????????????", "?????????????????????");
        return $strMonthCut[intval($num)];
    }

    public static function getDateFormatCMU($temp)
    {
        if (!empty($_SESSION['LANGUAGE'])) {
            $language = strtolower($_SESSION['LANGUAGE']);
        }else{
            $language = 'th';

        }
        
        $matchDay = [
            '1' => '???????????????????????????',
            '2' => '???????????????????????????',
            '3' => '??????????????????',
            '4' => '?????????????????????????????????',
            '5' => '????????????????????????',
            '6' => '????????????????????????',
            '7' => '??????????????????????????????'
        ];

        $month = [
            '01' => '??????????????????',
            '02' => '??????????????????????????????',
            '03' => '??????????????????',
            '04' => '??????????????????',
            '05' => '?????????????????????',
            '06' => '????????????????????????',
            '07' => '?????????????????????',
            '08' => '?????????????????????',
            '09' => '?????????????????????',
            '10' => '??????????????????',
            '11' => '???????????????????????????',
            '12' => '?????????????????????'
        ];

        $matchDayEn = [
            '1' => 'Monday',
            '2' => 'Thuesday',
            '3' => 'Wednesday',
            '4' => 'Thuresday',
            '5' => 'Friday',
            '6' => 'Saturday',
            '7' => 'Sunday'
        ];

        $monthEn = [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec'
        ];

        if ($language == 'th') {
            $time_update = new DateTime($temp);
            ##day##
            $old_date_timestamp = strtotime($temp);
            $new_date = date('Y-m-d', $old_date_timestamp); 
            $arrDate = explode('-', $new_date);
            $date_update = $arrDate[2].' '.$month[$arrDate[1]].' '.($arrDate[0] + 543).',';
            ##time
            $new_time = date('H.i'.' ???.', $old_date_timestamp); 
             // 17 ?????????????????????????????? 2564, 15.45 ???. 
            // return $matchDay[$time_update->format('N')].', '.$date_update.' '.$new_time;
            return $date_update.' '.$new_time;
        }else{
            $time_update = new DateTime($temp);
            ##day##
            $old_date_timestamp = strtotime($temp);
            $new_date = date('Y-m-d', $old_date_timestamp); 
            $arrDate = explode('-', $new_date);
            $date_update = $arrDate[2].' '.$monthEn[$arrDate[1]].' '.$arrDate[0].',';
            ##time
            $new_time = date('g.i A', $old_date_timestamp); 
            // 17 Feb 2021, 3 pm.
            // return $matchDayEn[$time_update->format('N')].', '.$date_update.' '.$new_time;
            return $date_update.' '.$new_time;
        }


    }
}
