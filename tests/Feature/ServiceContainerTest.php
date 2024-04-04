<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use Tests\TestCase;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;

use function PHPUnit\Framework\assertSame;

use function PHPUnit\Framework\assertEquals;
use Illuminate\Foundation\Testing\WithFaker;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNotSame;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceContainerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateDependency(): void
    {
        // $foo = new Foo();
        // $foo2 =  new Foo();
        $foo = app()->make(Foo::class);
        $foo2 = app()->make(Foo::class);

        assertNotSame($foo,$foo2);
    }

    function testBind() : void {
        // $person = app()->make(Person::class);
        // $person = app()->make(Person::class);

        // bind method 
        app()->bind(Person::class, function () {
            return new Person("Maria", "Regina"); //memanggil ini untuk mengisi data secara otomatis ketika app()->make() dipanggil
        });

        $person = app()->make(Person::class);
        $person2 = app()->make(Person::class);

        assertEquals("Maria" , $person->firstname);
        assertNotNull($person);
        assertNotSame($person, $person2);
    }

    function testSingleton() : void {
        // sama seperti bind, bedanya dia tidak bikin objek baru lagi
        app()->singleton(Person::class, function () {
            return new Person("Maria", "Regina");
        });

        $p = app()->make(Person::class);
        $p2 = app()->make(Person::class);
        
        assertEquals("Maria",$p->firstname);
        assertSame($p,$p2); 
    }

    function testInstance() : void {
        $p = new Person("Maria" , "Regina");
        app()->instance(Person::class, $p); //ini sama seperti singleton, bedanya dia ambil referensi dari objek yang sudah ada

        $p2 = app()->make(Person::class);
        $p3 = app()->make(Person::class);

        assertEquals("Maria",$p2->firstname);
        assertSame($p2,$p3);  
    }

    function testDependencyInjectionSingleton() : void {
        app()->singleton(Foo::class, function () {
            return new Foo();
        });

        $foo = app()->make(Foo::class);
        $foo2 = app()->make(Foo::class);
        $bar = app()->make(Bar::class);
        $bar2 = app()->make(Bar::class);

        assertEquals("Foo and Bar", $bar->bar());
        assertNotSame($bar, $bar2);
        assertSame($foo, $bar->foo);
        assertSame($foo, $foo2);
    }

    function testDependencyInjectionInClosure() : void {
        app()->singleton(Foo::class, function () {
            return new Foo();
        });

        app()->singleton(Bar::class, function () {
            return new Bar(app()->make(Foo::class)); //supaya ketika bikin beberapa Bar akan return objek yang sama walaupun bar memiliki dependency terhadap foo
        });

        $foo = app()->make(Foo::class);
        $foo2 = app()->make(Foo::class);
        $bar = app()->make(Bar::class);
        $bar2 = app()->make(Bar::class);

        assertEquals("Foo and Bar", $bar->bar());
        assertSame($bar, $bar2);
        assertSame($foo, $bar->foo);
        assertSame($foo, $foo2);

    }

    function testInterfaceToClass() : void {
        app()->singleton(HelloService::class,HelloServiceIndonesia::class); //cara 1
        // app()->singleton(HelloService::class, function () {
        //     return new HelloServiceIndonesia();
        // }); //cara 2

        $h = app()->make(HelloService::class);
        assertSame("Halo Rena", $h->hello("Rena"));
    }
}
