<?php
// return 会中断foreach function
function test(){
    $arr = array(1, 2, 3);
    foreach($arr as $k => $v) {
        if ($v == 4) {
            return null;
        }
    }

    echo "123";
} 

// test();
// var_dump(parse_ini_file("test.ini", true));

// 时区不对时，会影响strtotime 不会影响time()
echo strtotime(date("Y-m-d 10:00:00"));
echo "\n";
echo time();
echo "\n";

