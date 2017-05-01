<?php
	//Create security code in login page
	session_start();
	header("Content-type: image/png");
	$str = "1,2,3,4,5,6,7,8,9,a,b,c,d,f,g";
	$list = explode(",", $str);
	$cmax = count($list) - 1;
	$verifyCode = '';
	for ( $i=0; $i < 5; $i++ ){
		$randnum = mt_rand(0, $cmax);
		$verifyCode .= $list[$randnum]; 
	}
	$_SESSION['code'] = $verifyCode;
	$im=imagecreate(60,30);
	$bgcolor=imagecolorallocate($im,210,105,30); 
	$write=imagecolorallocate($im,0,0,0);
	imagestring($im,5,10,8,$verifyCode,$write);
	imagejpeg($im);
	imagedestroy($im);
?>