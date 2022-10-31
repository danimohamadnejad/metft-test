<?php
namespace Metft\Auth\Tests\Feature;
use Metft\Auth\Tests\TestCase;

class NewsServerTest extends TestCase{
    /** @test */
    public function simple_test(){
        $this->get('dani');
    } 
}