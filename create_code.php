<?php
session_start();
//������֤��ͼƬ
header("Content-type: image/png");
// ȫ����
$str = "1,2,3,4,5,6,7,8,9,a,b,c,d,f,g";      //Ҫ��ʾ���ַ������Լ�������ɾ
$list = explode(",", $str);
$cmax = count($list) - 1;
$verifyCode = '';
for ( $i=0; $i < 5; $i++ ){
      $randnum = mt_rand(0, $cmax);
      $verifyCode .= $list[$randnum];           //ȡ���ַ�����ϳ�Ϊ����Ҫ����֤���ַ�
}
$_SESSION['code'] = $verifyCode;        //���ַ�����SESSION��
$im=imagecreate(60,30);
$bgcolor=imagecolorallocate($im,210,105,30); 
$write=imagecolorallocate($im,0,0,0);
imagestring($im,5,10,8,$verifyCode,$write);
imagejpeg($im);
imagedestroy($im);
?>