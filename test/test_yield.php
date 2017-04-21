<?php
// http://www.laruence.com/2015/05/28/3038.html
// 协程
function xrange($start, $end, $step = 1) {
    for ($i = $start; $i <= $end; $i += $step) {
        yield $i;
    }
}
/*
上面这个xrange()函数提供了和PHP的内建函数range()一样的功能.
但是不同的是range()函数返回的是一个包含值从1到100万0的数组(注：请查看手册). 
而xrange()函数返回的是依次输出这些值的一个迭代器, 而不会真正以数组形式返回.

这种方法的优点是显而易见的.它可以让你在处理大数据集合的时候不用一次性的加载到内存中.
甚至你可以处理无限大的数据流.

当然,也可以不同通过生成器来实现这个功能,而是可以通过继承Iterator接口实现.
但通过使用生成器实现起来会更方便,不用再去实现iterator接口中的5个方法了.
*/

foreach (xrange(1, 10) as $num) {
    echo $num, "\n";
}

$range = xrange(1, 1000000);
var_dump($range); // object(Generator)#1
var_dump($range instanceof Iterator); // bool(true)
var_dump($range->current());

function logger($fileName) {
    $fileHandle = fopen($fileName, 'a');
    while (true) {
        fwrite($fileHandle, yield . "\n");
    }
}

$logger = logger(__DIR__ . '/yield.log');
$logger->send('Foo');
$logger->send('Bar');
