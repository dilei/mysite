<?php

$ip="127.0.0.1";
$port = 6382; 

// $ip = "r-2ze765b8e1686c74.redis.rds.aliyuncs.com"; 
// $port = 6379; 

// $handle = fopen("/tmp/strace.log", "r");
// $contents = fread($handle, filesize("/tmp/strace.log"));
// echo $contents;
// fclose($handle);

$redis = new Redis();
$redis->connect($ip, $port);
// $redis->auth("Kn6b2p3F86qyej");  
$key = "test";
$value = "this is test";

$redis->set($key, $value);
$d = $redis->get($key);
var_dump($d);
