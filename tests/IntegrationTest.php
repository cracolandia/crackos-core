<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class IntegrationTest extends TestCase{
    public function testConnection(){
        $this->assertNotNull(\DB::connection());
    }

    public function testMigrate(){
        $this->assertTrue(\DB::table('migrations')->count() > 0);
    }
}
