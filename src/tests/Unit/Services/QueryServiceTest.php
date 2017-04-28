<?php

namespace Tests\Services;

use App\Services\QueryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class QueryServiceTest extends TestCase
{
    
    private $results_per_page = 10;
    private $request;
    private $config;
    
    protected function setUp()
    {
        parent::setUp();
                     
        $this->request = new Request;
        $this->config = new Config;
        $this->config::set('app.results_per_page', $this->results_per_page);
    }

    protected function tearDown()
    {
        parent::tearDown();
        
        unset($_COOKIE['stack_id']);
    }
    
    public function testQuery()
    {
        $qs = new QueryService($this->request, $this->config);
        
        $results = $qs->search();
       
        $this->assertNotEmpty($results->count(), 'Results must not be empty');
        
        $this->assertLessThanOrEqual($this->results_per_page, $results->count(), 'Results cannot excede the pagination limit');
    }
    
    public function testQueryByStack()
    {
        $request = Request::create(
            '/', 'GET', [], ['stack_id'=>1]
        );
        
        $qs = new QueryService($request, $this->config);
        
        $results = $qs->searchByStack();
        
        $this->assertNotEmpty($results->count(), 'Results must not be empty');
        
        $this->assertLessThanOrEqual($this->results_per_page, $results->count(), 'Results cannot excede the pagination limit');
    }
    
    public function testQueryByTags()
    {
        $qs = new QueryService($this->request, $this->config);
        
        $results = $qs->searchByTags();
        
        $this->assertNotEmpty($results->count(), 'Results must not be empty');
        
        $this->assertLessThanOrEqual($this->results_per_page, $results->count(), 'Results cannot excede the pagination limit');
    }
}
