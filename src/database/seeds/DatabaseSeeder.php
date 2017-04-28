<?php

use App\Card;
use App\Stack;
use App\Tag;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use \DavidBadura\FakerMarkdownGenerator\FakerProvider;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {

            $faker = Faker::create();
            $faker->addProvider(new FakerProvider($faker));
            
            // create one user
            $admin_user_id = DB::table('users')->insertGetId([
                'name'=> 'SysAdmin',
                'email'=> 'admin@stubb.net',
                'password'=> Hash::make('sysadmin'),
                'avatar'=> Config::get('app.default_avatar'),
            ]);

            $users_list = [];
            
            // create more users
            foreach (range(1, 5) as $index) {
                $users_list[] = DB::table('users')->insertGetId([
                    'name'=> $faker->name(),
                    'email'=> $faker->email(),
                    'password'=> Hash::make( $faker->password() ),
                    'avatar'=> Config::get('app.default_avatar'),
                ]);
            }

            // assign stacks to users
            foreach (range(1, 4) as $index) {

                // create stack
                $stack = Stack::create([
                    'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
                    'description' => $faker->text($maxNbChars = 200),
                    'enabled' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // assign stacks to random users                
                $stack_users_keys = (array) array_rand( $users_list, random_int(1, count($users_list)) ); // pick some usres from stack       
                $stack_users = array_map(function($x) use ($users_list) { return $users_list[$x]; }, $stack_users_keys);
                array_push($stack_users, $admin_user_id); // admin must own everything for test purposes
                $stack->users()->attach( $stack_users );
                
                // assign cards
                foreach (range(1, 7) as $index) {

                    $cardContent = (rand(1, 100) > 40) ? $faker->markdown($maxNbChars = 1600) : $faker->text($maxNbChars = 1200);

                    $card = Card::create([
                            'name' => $faker->sentence($nbWords = 5, $variableNbWords = true),
                            'content' => $cardContent,
                            'enabled' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'sticky' => rand(0, 100) < 30
                    ]);
                    // associate stack and card
                    $card->stacks()->attach($stack->id);

                    $card->users()->attach($stack_users);

                    // assign random tags (belonging to card content)
                    $tags = explode(' ', str_replace('.', '', $cardContent)); // separate text in chunks
                    $indices = array_rand($tags, 3); // create three random tags

                    foreach ($indices as $index) {
                        
                        if(!ctype_alnum(substr($tags[$index], 1)))
                            continue; // skip markdown titles

                        $tag = Tag::firstOrCreate([
                            'name' => $tags[$index]
                        ]);

                        if(!$tag->cards->contains($card->id)) {      
                            $tag->cards()->attach($card->id);
                            
                            // replace text in content so to convert text to tags
                            $card->content = preg_replace('/'.$tags[$index].'/', '#'.$tags[$index], $card->content, 1);
                            $card->save();
                        }                    
                    }
                }
            }  
            
        } catch (Exception $ex) {
            Log::info($ex);
            echo $ex->getMessage();
        }
    }
}
