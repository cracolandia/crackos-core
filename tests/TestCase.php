<?php

use Illuminate\Support\Facades\Artisan;

class TestCase extends Laravel\Lumen\Testing\TestCase{
    public function setUp(){
        parent::setUp();
        
        Artisan::call('migrate');
    }

    public function createApplication(){
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function tearDown(){
        Artisan::call('migrate:reset');

        parent::tearDown();
    }
}
