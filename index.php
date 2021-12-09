<?php

class Singleton {
    private static $singleton;
    private $text = "aaaaaaaa";

    private function __construct()
    {
        echo "generated instance\n";
    }
    
    public function setText($tex) {
        $this -> text = $tex;
    }
    
    public function getText() {
        return $this -> text;
    }

    public static function getInstance() {
        if(!isset(self::$singleton)) {
            self::$singleton = new Singleton;
        }

        return self::$singleton;
    }

    public function sayHello() {
        echo "hello\n";
    }
}

Singleton::getInstance() -> sayHello();
echo Singleton::getInstance() -> getText() . "\n";
Singleton::getInstance() -> setText("myName is tyatya");
echo Singleton::getInstance() -> getText() . "\n";

?>