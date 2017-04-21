<?php
class A {
    public function __construct() {
        $this->setConfig();
    }

    public function setConfig() {
        echo "A";
    }
}

class B extends A {
    public function __construct() {
        parent::__construct();
    }

    public function setConfig() {
        echo "B";
    }
}

class C extends B {
    public function __construct() {
        parent::__construct();
    }

    public function setConfig() {
        echo "C";
    }
}

new C;  // output C
