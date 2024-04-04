<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

class DependencyInjectionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testDependencyInjection(): void
    {
        $foo = new Foo();
        $bar = new Bar($foo);
        
        assertEquals("Foo and Bar" , $bar->bar());
    }
}
