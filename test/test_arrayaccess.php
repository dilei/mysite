<?php
// arrayaccess接口可以让你以访问数组的形式访问对象 
class obj implements arrayaccess {

    private $name = 123;

    public function say() {
        echo "hahahaha hello\r\n";
        echo $this["name"]."\r\n";
    }

    public function __construct() {
    }

    public function offsetSet($offset, $value) {
        if ($offset == "name") {
            $this->name = $value;
        } else {
            echo "null";
        }
    }

    public function offsetExists($offset) {
        return isset($this->$offset);
    }

    public function offsetUnset($offset) {
        unset($this->$offset);
    }

    public function offsetGet($offset) {
        if (method_exists($this, $offset)) {
            return $this->$offset();
        }
        return isset($this->$offset) ? $this->$offset : "111";
    }
}

$a = new obj();
// echo $a["name"];
echo $a["say"];


