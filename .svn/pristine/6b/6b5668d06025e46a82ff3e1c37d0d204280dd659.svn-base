<?php

/** MAKE SURE TO HAVE THE INCLUDES RUNNING PROPERLY */
ob_start();
require_once('alpha_pdf.php');
require_once('FPDI_Protection.php');
require_once('fpdi.php');

class WaterMark {

    public $image, $alpha, $pdf, $file, $newFile, $wmText = "";
    private $exif_data;


    /** $file and $newFile have to include the full path. */
    public function __construct($file, $newFile, $alpha = 0.3, $wm_image = "") {
        //$this->pdf = new FPDI();
        $this->pdf = new FPDI_Protection();

        $this->file = $file;
        $this->newFile = $newFile;
        $this->image = $wm_image;
        $this->alpha = $alpha;
    }

    function toMM($v) {
        return ($v / $this->pdf->k);
    }

     public function setExifData($data = array()) {
        $this->exif_data = $data;
    }

    /** @todo Make the text nicer and add to all pages */
    public function doWaterMark($text, $dayexp = 0, $owner_pwd = "") {


        $alpha = $this->alpha;
        $currentFile = $this->file;
        $newFile = $this->newFile;
//	$lines = explode("\n",$this->wmText);
        $lines = explode("\n", $text);
        $maxlen = 0;
        for ($i = 0; $i < count($lines); $i++) {
            if (strlen($lines[$i]) > $maxlen) {
                $maxlen = strlen($lines[$i]);
            }
        }

        if ($maxlen > 100) {
            $txtsize = 20;
        } elseif ($maxlen > 50) {
            $txtsize = 30;
        } elseif ($maxlen > 30) {
            $txtsize = 40;
        } elseif ($maxlen > 20) {
            $txtsize = 60;
        } else {
            $txtsize = 72;
        }

        // $txtsize = 20;
        // $txtsize = 18;
        $txtsize = 12;

        //font :  THSarabun PSK
        $this->pdf->AddFont('THSarabun', '', 'THSarabun.php');
        $this->pdf->AddFont('THSarabun', 'B', 'THSarabunb.php'); //Bold
        $this->pdf->AddFont('THSarabun', 'I', 'THSarabuni.php'); //Italic
        $this->pdf->AddFont('THSarabun', 'Z', 'THSarabunz.php'); //Bold and Italic

        $GLOBALS['pdf_error'] = "";
        $pagecount = $this->pdf->setSourceFile($currentFile);

//        if ($pagecount == 0) {
//
//            // num page by pdfinfo
//            $cmd = "pdfinfo " . realpath($currentFile) . " | grep Page";
//            exec($cmd, $pdfDataInfo);
//
//            $pagecount = 0;
//            if (count($pdfDataInfo) > 0 && isset($pdfDataInfo[0])) {
//                $count = @$pdfDataInfo[0];
//                $count = str_replace('Pages: ', '', $count);
//                $count = trim($count);
//
//                $pagecount = intval($count);
//            }
//
//            if ($pagecount > 0) {
//                $GLOBALS['pdf_error'] = '';
//            }
//        }

        if ($GLOBALS['pdf_error'] > "") {
            return;
        }

        if ($pagecount == 0) {
            $GLOBALS['pdf_error'] = 'can not read page';
            return;
        }


        for ($i = 1; $i <= $pagecount; $i++) {

            $tplidx = $this->pdf->importPage($i);

            # ไฟล์มีปัญหา
            if (trim($tplidx) == '') {
                $GLOBALS['pdf_error'] = 'can not read page';
                return;
            }


            //find page orientation
            // $size = $this->pdf->getTemplateSize($tplidx, $_w, $_h);
            $size = $this->pdf->getTemplateSize($tplidx);
            $orientation = $size['w'] > $size['h'] ? 'L' : 'P';


            if ($orientation == "P") {
                // $xstart = 30;
                // $ystart = 220 - (count($lines) * 10);

                $xstart = 50;
                // $ystart = 250 - (count($lines) * 10);
                // $ystart = $size['h'] - (count($lines) * 50);
                $ystart = $size['h'] - (count($lines) * 85);
            } else {
                $xstart = 70;
                // $ystart = 190 - (count($lines) * 10);
                $ystart = $size['h'] - (count($lines) * 60);
            }


            $size_type = 'A4';
            if (isset($size['w']) && $size['w'] < 180) {
                $size_type = 'A5';
                $xstart = 15;
                $ystart = 150 - (count($lines) * 10);
                $txtsize = 20;
            }


            // $this->pdf->addPage($orientation,$size_type);
            // $pageSize[0] = $this->pdf->GetPageWidth();
            // $pageSize[1] = $this->pdf->GetPageHeight();
            // rewite page size
            $pageSize[0] = $size['w'];
            $pageSize[1] = $size['h'];

            $this->pdf->addPage($orientation, $pageSize);



            $this->pdf->SetAlpha(1);
            $this->pdf->useTemplate($tplidx, 0, 0, 0, 0, true);

            //add watermark image
            if (strlen($this->image) > 0) {
                $img_size = getimagesize($this->image);
                ### max_size img size
                $max_size = 300;
                if ($size_type == 'A5') {
                    $max_size = 200;
                }

                if ($img_size[0] > $max_size) {
                    $img_size[0] = $max_size;
                }

                if ($img_size[1] > $max_size) {
                    $img_size[1] = $max_size;
                }
                $iwd = $this->toMM($img_size[0]);
                $ihg = $this->toMM($img_size[1]);


                $ix = ( $size['w'] / 2 ) - ($iwd / 2);
                // $iy = ( $size['h'] / 2 ) - ($ihg / 2);
                $iy = ( $size['h'] / 4 ) - ($ihg / 2);

                if ($size_type == 'A5') {
                    // $ix = ( $size['w'] / 4 ) - ($iwd / 2);
                    $iy = ( $size['h'] / 4 ) - ($ihg / 2);
                }

                // _print_r($alpha);
                // $this->pdf->SetAlpha($alpha);
                $this->pdf->SetAlpha(0.2);
                $this->pdf->Image($this->image, $ix, $iy, $iwd, $ihg);
            }

            $this->pdf->SetAlpha(1);
//		$this->pdf->useTemplate($tplidx,0,0,0,0,true);
            // text
            if ($maxlen > 0) {
                // now write some text above the imported page
                $this->pdf->SetFont('THSarabun', '', $txtsize); //old=40
                $this->pdf->SetTextColor(150, 150, 150);

                for ($j = 0; $j < count($lines); $j++) {
                    // $this->pdf->SetAlpha(0.3);
                    $this->pdf->SetAlpha($alpha);
                    // $this->pdf->SetXY($xstart + ($j *10), $ystart + ($j * 10));
                    // $this->_rotate(40);
                    // echo $ystart + ($j * 20).'<br>';
                    // $this->pdf->SetXY($xstart, $ystart + ($j * 10));
                    $this->pdf->SetXY($xstart, $ystart + ($j * 15));
                    $this->_rotate(0);

                    $this->pdf->Write(0, $lines[$j]);
                    $this->_rotate(0); //<-added
                    // _print_r($xstart);
                }
            }

            // _print_r($size_type);

            $this->pdf->SetAlpha(1);
        }




        if ($owner_pwd > "") {
            $this->pdf->SetProtection(array('print'), "", $owner_pwd);
        }

        ## set ExifFile
        if(!empty($this->exif_data)){
            foreach ($this->exif_data as $key_ef => $value_ef) {
                $text = $value_ef;

                $this->exif_data[$key_ef] = ($text);

            }
        }
        // _print_r($this->exif_data);

        $this->pdf->SetTitle(@$this->exif_data['title'],1);
        $this->pdf->SetAuthor(@$this->exif_data['author'],1);
        $this->pdf->SetCreator(@$this->exif_data['author'],1);
        $this->pdf->SetSubject(@$this->exif_data['subject'],1);
        $this->pdf->SetKeywords(@$this->exif_data['keywords'],1);


        //do expire
        if ($dayexp > 0) {
            if (strpos($dayexp, '-') !== false) { // ระบุวันวันเวลา
                $exptime = strtotime($dayexp);
                list($yy, $mm, $dd) = explode("-", date("Y-m-d", $exptime));
                list($hh, $ii, $ss) = explode(":", date("H:i:s", $exptime));
            } else { //ระบุแค่จำนวนวัน
                $exptime = mktime(23, 59, 59, date("m"), date("d") + $dayexp, date("Y")); //next xxx days
                list($yy, $mm, $dd) = explode("-", date("Y-m-d", $exptime));
                list($hh, $ii, $ss) = explode(":", date("H:i:s", $exptime));
            }


            $script = <<<EOT
function CheckExpiration(LastYear, LastMonth, LastDate, LastHour, LastMin, LastSec, LastMS) {
	if (isNaN(LastYear) ) LastYear = 1900;
	if (isNaN(LastMonth) ) LastMonth = 1;
	if (isNaN(LastDate) ) LastDate = 1;
	if (isNaN(LastHour) ) LastHour = 0;
	if (isNaN(LastMin) ) LastMin = 0;
	if (isNaN(LastSec) ) LastSec= 0;
	if (isNaN(LastMS) ) LastMS = 0;

	LastMonth = LastMonth - 1;
	var myDate = new Date( Number(LastYear), Number(LastMonth), Number(LastDate), Number(LastHour), Number(LastMin), Number(LastSec), Number(LastMS) ).valueOf(); 

	var today = new Date().valueOf(); 
	return (myDate < today); 
}


if (CheckExpiration($yy,$mm,$dd,$hh,$ii,$ss) ) {
	app.alert("This files has expired at $dd/$mm/$yy $hh:$ii:$ss",1,0,"Expired");
	this.closeDoc(1);

	app.alert("This files has expired at $dd/$mm/$yy $hh:$ii:$ss",1,0,"Expired");
	app.alert("This files has expired at $dd/$mm/$yy $hh:$ii:$ss",1,0,"Expired");

}
EOT;
            $this->pdf->IncludeJS($script);
        }


//    $this->pdf->Output($newFile, 'D');
    }

    public function isWaterMarked() {
        return (file_exists($this->newFile));
    }

    public function spitWaterMarked() {
        return readfile($this->newFile);
    }

    protected function _rotate($angle, $x = -1, $y = -1) {

        if ($x == -1)
            $x = $this->pdf->x;
        if ($y == -1)
            $y = $this->pdf->y;
        if (@$this->pdf->angle != 0)
            $this->pdf->_out('Q');
        $this->pdf->angle = $angle;

        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->pdf->k;
            $cy = ($this->pdf->h - $y) * $this->pdf->k;

            $this->pdf->_out(sprintf(
                            'q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

}

//header('Content-type: application/pdf');
?>