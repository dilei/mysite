<?php
function test(){
    $arr = array(1, 2, 3);
    foreach($arr as $k => $v) {
        if ($v == 4) {
            return null;
        }
    }

    echo "123";
} 

test();


