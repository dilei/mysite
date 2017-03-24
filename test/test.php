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

// test();

//l 声明为字符串 然后以数组方式赋值会报错
function test_type() {
    // 1
    // http://php.net/manual/zh/language.types.string.php
    //自 PHP 5.4 起字符串下标必须为整数或可转换为整数的字符串，否则会发出警告 
    $str ="2222";
    $str["a"] = "333";
    echo $str;

    // 2 它会先解析$str,然后再算偏移量
    $str = "aaaaa";
    $str["2"] = "333";
    echo $str;  // aa3aa

    //3 正确
    $str = array();
    $str["a"] = "333";
}
test_type();


