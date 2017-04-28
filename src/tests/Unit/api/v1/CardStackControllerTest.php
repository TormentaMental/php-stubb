<?php
namespace Tests\Unit\Api\v1;

use Faker\Factory as Faker;
use Tests\TestCase;

class CardStackControllerTest extends TestCase
{
    
    protected function setUp(): void
    {
        parent::setUp();
    }
    
    /**
     * Retrieve card
     *
     * @return void
     */
    public function testGetCardStacks()
    {
        $response = $this->json('GET', $this->api.'/cards/1/stacks');

        $this->assertEquals(200, $response->status(), 'Response code must be 200 OK');
    
        $data = $response->decodeResponseJson();
        
        // is not an empty result
        $this->assertNotEmpty($data, 'Item data must not be empty');
        
        $this->assertNotEmpty($data['stacks'], 'Stack list must not be empty');
    }
    
    /**
     * Retrieve tag cards
     *
     * @return void
     */
    public function testGetStackCards()
    {
        $response = $this->json('GET', $this->api.'/stacks/1/cards');

        $this->assertEquals(200, $response->status(), 'Response code must be 200 OK');
    
        $data = $response->decodeResponseJson();
        
        // is not an empty result
        $this->assertNotEmpty($data, 'Item data must not be empty');
        
        $this->assertNotEmpty($data['data'], 'Cards list must not be empty');
    }
    
    public function testAttachCardToStack()
    {
        $response = $this->json('PUT', $this->api.'/stacks/1/cards/4');
        
        $this->assertEquals(204, $response->status(), 'Response code must be 204 No Content');
    }
}
