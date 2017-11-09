<?php      
    echo "<h1>PHP QR Code by Dirk</h1><hr/>";  
      
    include 'phpqrcode/phpqrcode.php';      
    $value = 'https://idilei.com'; //二维码内容     
    $errorCorrectionLevel = 'L'; //容错级别     
    $matrixPointSize = 6; //生成图片大小  
  
    // 生成二维码图片     
    QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);  
    echo "QR code generated"."<br/>";    
  
    //生成中间带logo的二维码       
    $logo = 'info.jpg'; // logo图片是你自己放到文件夹里的    
    $QR = 'qrcode.png';    
     
    if($logo !== FALSE)    
    {    
     
        $QR = imagecreatefromstring(file_get_contents($QR));    
        $logo = imagecreatefromstring(file_get_contents($logo));    
        $QR_width = imagesx($QR);    
        $QR_height = imagesy($QR);    
        $logo_width = imagesx($logo);    
        $logo_height = imagesy($logo);    
        $logo_qr_width = $QR_width / 5;    
        $scale = $logo_width / $logo_qr_width;    
        $logo_qr_height = $logo_height / $scale;    
        $from_width = ($QR_width - $logo_qr_width) / 2;    
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);    
    }    
    imagepng($QR,'qrWithLogo.png');   
  
    echo '<img src="qrWithLogo.png">';    
