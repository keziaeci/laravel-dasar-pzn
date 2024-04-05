<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

class FacadeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testConfig(): void
    {
        $a = config('contoh.author.firstname');
        $b = Config::get('contoh.author.firstname');

        assertSame($a,$b);
        // var_dump($a);
    }

    function testConfigDependency() : void {
        $config = $this->app->make("config");
        $f1 = $config->get("contoh.author.firstname");
        $f2 = Config::get("contoh.author.firstname");

        assertEquals($f1,$f2);
    }

    function testConfigMock() : void {
        // mocking adalah seni untuk melakukan sesuatu tanpa benar benar melakukan sesuatu (membuat perubahhan)
        Config::shouldReceive('get')
        ->with("contoh.author.firstname")
        ->andReturn("Rena Keren");

        $f = Config::get("contoh.author.firstname");

        assertEquals("Rena Keren", $f);
    }
}
