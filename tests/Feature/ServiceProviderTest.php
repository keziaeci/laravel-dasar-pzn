<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\HelloService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

class ServiceProviderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testServiceProvider(): void
    {
        $f = app()->make(Foo::class);
        $f2 = app()->make(Foo::class);
        $b = app()->make(Bar::class);
        $b2 = app()->make(Bar::class);

        assertSame($b, $b2);
        assertSame($f, $f2);
        assertSame($f, $b->foo);
    }

    function testPropertySingletons() : void {
        $h = app()->make(HelloService::class);
        $h2 = app()->make(HelloService::class);

        assertEquals($h->hello("Rena"), $h2->hello("Rena"));
        assertSame("Halo Rena", $h->hello("Rena"));
    }

    function test_example() : void {
        assertTrue(true);
    }
}
