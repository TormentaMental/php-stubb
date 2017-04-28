<?php
namespace Tests\Unit;

use App\Tag;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    
    protected function setUp(): void
    {
        $this->card_id = null;
        $this->tag_id = null;
        parent::setUp();
    }

    /**
     * List tags
     *
     * @return void
     */
    public function testTagsList()
    {

        $response = $this->json('GET', $this->api.'/tags')->decodeResponseJson();

        // is not an empty result
        $this->assertNotEmpty($response, 'Data list must not be empty');
    }

    /**
     * Retrieve tag
     *
     * @return void
     */
    public function testGetTag()
    {
        $faker = Faker::create();
        $this->card_id = DB::table('cards')->insertGetId([
            'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            'content' => $faker->text($maxNbChars = 200),
            'enabled' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $tag = Tag::firstOrCreate([
                'name' => $faker->word()
        ]);
        $tag->cards()->attach($this->card_id);
        $this->tag_id = $tag->id;
        
        $response = $this->json('GET', $this->api.'/tags/' . $tag->id)
            ->decodeResponseJson();

        // is not an empty result
        $this->assertNotEmpty($response, 'Item data must not be empty');
        
        return $tag->id;
    }

    /**
     * Delete tag
     * 
     * @return void
     */
    public function testDeleteTag()
    {
        $response = $this->delete($this->api.'/tags/1');
        $this->assertEquals(204, $response->status(), 'Response code must be 204 No Content');
    }
}
