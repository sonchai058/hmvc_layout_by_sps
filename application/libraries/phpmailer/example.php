<?php
include_once ('class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

//echo "<pre>";print_r($_POST);exit;

if ($_POST['webcode'] != "sendmail1234"){
	exit;
}

if ($_POST['sendfrom'] > ""){
	$send_from = trim($_POST['sendfrom']);
}

if ($_POST['sendto'] > ""){
	$admin_email = trim($_POST['sendto']);
}else{
	$admin_email = "nontanan.cm@gmail.com"; //m_roongrueng@hotmail.com
}

$subject = trim($_POST['subject']);
$body = trim($_POST['body']) ;
$body             = eregi_replace("[\]",'',$body);

$mail             = new PHPMailer();
if (!$mail) exit;




//=================================
//@2/12/2554
//=================================
$nosend_subject = "Server Report INSTITUTE OF PHYSICAL EDUCATION";
if (trim(strtolower(substr($subject,0,strlen($nosend_subject)))) == trim(strtolower($nosend_subject))){
	exit; //do nothing
}

//=================================




$mail->CharSet = 'UTF-8';
$mail->IsSMTP(); // telling the class to use SMTP
//$mail->Host       = "mail.yourdomain.com"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "simplybright.mailer@gmail.com";  // GMAIL username
$mail->Password   = "thaitimebank2020";            // GMAIL password

$mail->SetFrom($send_from,$send_from);
$mail->AddReplyTo($send_from,$send_from);

//����Ѻ
if (strpos($admin_email,';') > 0){
	$emails = explode(';',$admin_email);
	foreach ($emails as $xmail){
		$mail->AddAddress($xmail,$xmail);
	}
}else{
	$mail->AddAddress($admin_email,$admin_email);
}

$mail->Subject    = $subject;

//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);


//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}


?>