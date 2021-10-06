<?
function randomText($n){
	$output="";
	$s = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ";
	for ($i=0;$i<$n;$i++){
		$x = rand(0,strlen($s)-1);
		$output .= substr($s,$x,1);
	}
	return $output;
}


function ku_watermark($file, $newFile,$text="",$alpha=0.3,$img="")
{
	include_once "watermark.class.php";

    $wm = new WaterMark($file, $newFile,$alpha,$img);
	if ($text > "") $wm->wmText = $text;

	//allways do watermark
	$wm->doWaterMark();

    $wm->pdf->Output($newFile, 'F');   //create temp-file for next download

}

?>