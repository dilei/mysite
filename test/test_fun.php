#! /data/server/php7/bin/php
<?php
//  错误 unset没有返回值
// isset($a) && unset($a);

// var_dump(unset($a));


// 正确
// isset($a) && intval(11);
// isset($a) && fun();


$a = 0 || 'avacado';
print "A: $a\n";
