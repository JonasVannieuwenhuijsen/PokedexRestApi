<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Pokemon;
use App\Models\Ability;
use App\Models\Move;
use App\Models\Version_group_detail;
use App\Models\Sprite;
use App\Models\Type;
use App\Models\Stat;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Change path
        $json = file_get_contents("C:\Users\jonas\SynologyDrive\GIT\PokedexRestApi\pokemons.json");;
        $pokemons = json_decode($json, true);

        //$pokemon = $pokemons[0]; implementation of one pokemon
        foreach ($pokemons as $pokemon){
            $newPokemon = Pokemon::query()->updateOrCreate([
                'id' => $pokemon['id'],
                'name' => $pokemon['name'],
                'height' => $pokemon['height'],
                'weight' => $pokemon['weight'],
                'order' => $pokemon['order'],
                'species' => $pokemon['species']['name'],
                'form' => $pokemon['forms'][0]['name']
            ]);

            $pokemonById = Pokemon::find($pokemon['id']);

            $abilities = $pokemon['abilities'];
            foreach ($abilities as $ability){
                $newAbility = new Ability([
                    'ability' => $ability['ability']['name'],
                    'is_hidden' => $ability['is_hidden'],
                    'slot' => $ability['slot']
                ]);
                
                $pokemonById->abilities()->save($newAbility);
            }

            $moves = $pokemon['moves'];
            foreach ($moves as $move){
                $newMove = new Move([
                    'move' => $move['move']['name'],
                ]);
                
                $pokemonById->moves()->save($newMove);

                $version_group_details = $move['version_group_details'];
                foreach ($version_group_details as $version_group_detail){
                    $newVersion_group_detail = new Version_group_detail([
                        'move_learn_method' => $version_group_detail['move_learn_method']['name'],
                        'version_group' => $version_group_detail['version_group']['name'],
                        'level_learned_at' => $version_group_detail['level_learned_at']
                    ]);
                    
                    $newMove->version_group_details()->save($newVersion_group_detail);
                }
            }

            $sprites = $pokemon['sprites'];
            $newSprite = new Sprite([
                'front_default' => $sprites['front_default'],
                'front_female' => $sprites['front_female'],
                'front_shiny' => $sprites['front_shiny'],
                'front_shiny_female' => $sprites['front_shiny_female'],
                'back_default' => $sprites['back_default'],
                'back_female' => $sprites['back_female'],
                'back_shiny' => $sprites['back_shiny'],
                'back_shiny_female' => $sprites['back_shiny_female']
            ]);
            
            $pokemonById->sprites()->save($newSprite);

            $stats = $pokemon['stats'];
            foreach ($stats as $stat){
                $newStat = new Stat([
                    'stat' => $stat['stat']['name'],
                    'base_stat' => $stat['base_stat'],
                    'effort' => $stat['effort']
                ]);
                
                $pokemonById->stats()->save($newStat);
            }

            $types = $pokemon['types'];
            foreach ($types as $type){
                $newType = new Type([
                    'type' => $type['type']['name'],
                    'slot' => $type['slot']                    
                ]);
                
                $pokemonById->types()->save($newType);
            }
            
        }
    }
}
