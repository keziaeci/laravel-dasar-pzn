<?php 

namespace App\Data;

class Bar {

    public Foo $foo;
    public function __construct(Foo $foo) {
        $this->foo = $foo;
    }

    function bar() : string {
        return $this->foo->foo() . " and Bar";
    }
}