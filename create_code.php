<?php
session_start();
//生成验证码图片
header("Content-type: image/png");
// 全数字
$str = "1,2,3,4,5,6,7,8,9,a,b,c,d,f,g";      //要显示的字符，可自己进行增删
$list = explode(",", $str);
$cmax = count($list) - 1;
$verifyCode = '';
for ( $i=0; $i < 5; $i++ ){
      $randnum = mt_rand(0, $cmax);
      $verifyCode .= $list[$randnum];           //取出字符，组合成为我们要的验证码字符
}
$_SESSION['code'] = $verifyCode;        //将字符放入SESSION中
$im=imagecreate(60,30);
$bgcolor=imagecolorallocate($im,210,105,30); 
$write=imagecolorallocate($im,0,0,0);
imagestring($im,5,10,8,$verifyCode,$write);
imagejpeg($im);
imagedestroy($im);
?>