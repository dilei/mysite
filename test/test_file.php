<?php
// $fp = fopen("D:/sql.log", "r+");
// $fp = fopen("D:/sql.log", "w+");
$fp = fopen("D:/sql.log", "a+");
$block = fread($fp, 3);

echo fwrite($fp, $block);

fclose($fp);
