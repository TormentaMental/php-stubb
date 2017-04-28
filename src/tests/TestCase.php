<?php

namespace Tests;

use DirectoryIterator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    protected $api = '/api/v1';
    protected $user = null; 
        
    protected function setUp()
    {
        parent::setUp();
        
        Config::set('database.connections.sqlite.database', ':memory:');
        Config::set('database.default', 'sqlite');
        
        Artisan::call('migrate');
        
        Artisan::call('db:seed');
        
        $this->user = \App\User::find(1);
        $this->actingAs($this->user, 'api');
    }

    protected function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
