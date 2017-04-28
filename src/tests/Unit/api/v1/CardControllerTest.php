<?php
namespace Tests\Unit\Api\v1;

use Faker\Factory as Faker;
use Tests\TestCase;

class CardControllerTest extends TestCase
{
    protected $faker;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->faker = Faker::create();    
    }

    /**
     * List cards
     *
     * @return void
     */
    public function testCardsList()
    {
        
        $response = $this->call('GET', $this->api.'/cards');
 
        $response->assertStatus(200);
        
        // is not an empty result
        $this->assertNotEmpty($response, 'Data list must not be empty');
        
        $response->assertJsonFragment(["id"=> 1]);
    }

    /**
     * Create Card
     *
     * @return int card id
     */
    public function testCreateCard(): int
    {
        $response = $this->post($this->api.'/cards', [
                'name' => $this->faker->text($maxNbChars = 9),
                'content' => $this->faker->text($maxNbChars = 200)
            ]);

        $this->assertEquals(201, $response->status(), 'Response code must be 201 Created');
    
        $data = $response->decodeResponseJson();
        
        // is not an empty result
        $this->assertNotEmpty($data['id'], 'Response must have an id');

        return $data['id'];
    }

    /**
     * Update card
     *
     * @return void
     */
    public function testSaveCard()
    {
        $response = $this->put($this->api.'/cards/1' , [
                'name' => $this->faker->text($maxNbChars = 9),
                'content' => 'updated ' . date("Y-m-d H:i:s"),
                'enabled' => false
            ]);

        $this->assertEquals(204, $response->status(), 'Response code must be 204 No Content');
    }
    
    /**
     * Update card with null values
     *
     * @return void
     */
    public function testSaveCardNullValues()
    {
        $response = $this->post($this->api.'/cards', [
                'name' => null,
                'content' => null,
                'enabled' => false
            ]);      
        
        $this->assertEquals(400, $response->status(), 'Response code must be 400');
    }

    /**
     * Retrieve card
     *
     * @return void
     */
    public function testGetCard()
    {
        $response = $this->json('GET', $this->api.'/cards/1');

        $this->assertEquals(200, $response->status(), 'Response code must be 200 OK');
    
        $data = $response->decodeResponseJson();
        
        // is not an empty result
        $this->assertNotEmpty($data, 'Item data must not be empty');
    }

    /**
     * Delete card
     *
     * @return void
     */
    public function testDeleteCard()
    {
        $response = $this->delete($this->api.'/cards/1');
        $this->assertEquals(204, $response->status(), 'Response code must be 204 No Content');
    }
}
