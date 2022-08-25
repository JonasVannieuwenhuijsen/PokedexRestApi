<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use App\Models\Pokemon;
use App\Models\Ability;
use App\Models\Move;
use App\Models\Version_group_detail;
use App\Models\Sprite;
use App\Models\Type;
use App\Models\Stat;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //All pokemons

        $response = [];
        $typesArray = [];

        $pokemons = Pokemon::all();

        $sort = $request->input('sort');

        

        if($sort == 'id-desc'){
            $pokemons = $pokemons->sortByDesc('id');
        }elseif($sort == 'name-asc'){
            $pokemons = $pokemons->sortBy('name');
        }elseif($sort == 'name-desc'){
            $pokemons = $pokemons->sortByDesc('name');
        } elseif($sort == 'id-asc'){
            $pokemons = $pokemons->sortBy('id');
        }

        foreach ($pokemons as $pokemon){
            $sprite_front_default = DB::table('sprites')->where('pokemon_id', $pokemon['id'])->value('front_default');

            $types = DB::table('types')->where('pokemon_id', $pokemon['id'])->get();
            foreach($types as $type){
                $newType = array("slot" => $type->slot, "type" => array("name" => $type->type));
                array_push($typesArray, $newType);
            }

            $newPokemon = array( 
                "id" => $pokemon['id'],
                "name" => $pokemon['name'],
                "sprites" => array(
                    "front_default" => $sprite_front_default),
                "types" => $typesArray,
              ); 

              array_push($response, $newPokemon);
              $typesArray = [];
        }

        return response()->json([
            "pokemons" => $response
         ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $typesArray = [];
        $movesArray = [];
        $versionGroupDetailsArray = [];
        $statsArray = [];
        $abilitiesArray = [];

        $pokemon = Pokemon::find($id);

        //dd($pokemon);
        if($pokemon == null){
            return response()->json([
                "error" => "ERROR",
                "error_message" => "Pokemon not found"
             ],404);
        }else{
            $sprites = DB::table('sprites')->where('pokemon_id', $pokemon['id'])->first();

            $types = DB::table('types')->where('pokemon_id', $pokemon['id'])->get();
            foreach($types as $type){
                $newType = array("slot" => $type->slot, "type" => array("name" => $type->type));
                array_push($typesArray, $newType);
            }
    
            $moves = DB::table('moves')->where('pokemon_id', $pokemon['id'])->get();
            foreach($moves as $move){
    
                $versionGroupDetails = DB::table('version_group_details')->where('move_id', $move->id)->get();
                foreach($versionGroupDetails as $versionGroupDetail){
                    $newVersionGroupDetail = array("move_learn_method" => $versionGroupDetail->move_learn_method, 
                                                   "version_group" => $versionGroupDetail->version_group,
                                                   "level_learned_at" => $versionGroupDetail->level_learned_at);
                    array_push($versionGroupDetailsArray, $newVersionGroupDetail);
                }    
    
                $newMove = array("move" => $move->move, "version_group_details" => $versionGroupDetailsArray);
                array_push($movesArray, $newMove);
                $versionGroupDetailsArray = [];
            }
    
            $stats = DB::table('stats')->where('pokemon_id', $pokemon['id'])->get();
            foreach($stats as $stat){
                $statType = array("stat" => $stat->stat,
                                  "base_stat" => $stat->base_stat,
                                  "effort" => $stat->effort);
                array_push($statsArray, $statType);
            }
    
            $abilities = DB::table('abilities')->where('pokemon_id', $pokemon['id'])->get();
            foreach($abilities as $ability){
                $newAbility = array("ability" => $ability->ability,
                                    "is_hidden" => $ability->is_hidden,
                                    "slot" => $ability->slot);
                array_push($abilitiesArray, $newAbility);
            }
    
            $newPokemon = array( 
                "id" => $pokemon['id'],
                "name" => $pokemon['name'],
                "sprites" => array(
                    "front_default" => $sprites->front_default,
                    "front_female" => $sprites->front_female,
                    "front_shiny" => $sprites->front_shiny,
                    "front_shiny_female" => $sprites->front_shiny_female,
                    "back_default" => $sprites->back_default,
                    "back_female" => $sprites->back_female,
                    "back_shiny" => $sprites->back_shiny,
                    "back_shiny_female" => $sprites->back_shiny_female),
                "types" => $typesArray,
                "height" => $pokemon['height'],
                "weight" => $pokemon['weight'],
                "moves" => $movesArray,
                "order" => $pokemon['order'],
                "species" => $pokemon['species'],
                "stats" => $statsArray,
                "abilities" => $abilitiesArray,
                "form" => $pokemon['form']
                ); 
            
    
            return response()->json([
                "pokemons" => $newPokemon
             ],200);
        }
    }

    public function search(Request $request)
    {
        //All pokemons

        $response = [];
        $typesArray = [];
        $resultIDsArray = [];

        $nameOrType = $request->input('query');
        $limit = intval($request->input('limit'));

        $pokemonIDByName = DB::table('pokemon')->where('name', $nameOrType)->value('id'); //all pokemons have unique names
        if($pokemonIDByName != null){
            array_push($resultIDsArray, $pokemonIDByName);
        }

        $pokemonsIDByType = DB::table('types')->where('type', $nameOrType)->get();
        foreach ($pokemonsIDByType as $pokemonIDByType){
            array_push($resultIDsArray, $pokemonIDByType->pokemon_id);
        }

        if($limit == null){
            $limit = count($resultIDsArray);
        }

        for ($x = 0; $x < $limit; $x++){
            $pokemonById = DB::table('pokemon')->where('id', $resultIDsArray[$x])->first();

            $sprite_front_default = DB::table('sprites')->where('pokemon_id', $pokemonById->id)->value('front_default');

            $types = DB::table('types')->where('pokemon_id', $pokemonById->id)->get();
            foreach($types as $type){
                $newType = array("slot" => $type->slot, "type" => array("name" => $type->type));
                array_push($typesArray, $newType);
            }

            $newPokemon = array( 
                "id" => $pokemonById->id,
                "name" => $pokemonById->name,
                "sprites" => array(
                    "front_default" => $sprite_front_default),
                "types" => $typesArray,
              ); 

              array_push($response, $newPokemon);
              $typesArray = [];
        }

        return response()->json([
            "pokemons" => $response
         ],200);

    }

    /**
     * Add new pokemon from external api
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idOrName)
    {

        $response = Http::get('https://pokeapi.co/api/v2/pokemon/'. $idOrName . '/');
        $responseBody = json_decode($response->getBody(), true);

        $pokemon = Pokemon::find($responseBody['id']);

        if($pokemon != null){
            return response()->json([
                "error" => "ERROR",
                "error_message" => "Pokemon already in database"
             ],404);
        }else{
            $newPokemon = Pokemon::query()->updateOrCreate([
                'id' => $responseBody['id'],
                'name' => $responseBody['name'],
                'height' => $responseBody['height'],
                'weight' => $responseBody['weight'],
                'order' => $responseBody['order'],
                'species' => $responseBody['species']['name'],
                'form' => $responseBody['forms'][0]['name']
            ]);

            $pokemonById = Pokemon::find($responseBody['id']);

            $abilities = $responseBody['abilities'];
            foreach ($abilities as $ability){
                $newAbility = new Ability([
                    'ability' => $ability['ability']['name'],
                    'is_hidden' => $ability['is_hidden'],
                    'slot' => $ability['slot']
                ]);
                
                $pokemonById->abilities()->save($newAbility);
            }

            $moves = $responseBody['moves'];
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

            $sprites = $responseBody['sprites'];
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

            $stats = $responseBody['stats'];
            foreach ($stats as $stat){
                $newStat = new Stat([
                    'stat' => $stat['stat']['name'],
                    'base_stat' => $stat['base_stat'],
                    'effort' => $stat['effort']
                ]);
                
                $pokemonById->stats()->save($newStat);
            }

            $types = $responseBody['types'];
            foreach ($types as $type){
                $newType = new Type([
                    'type' => $type['type']['name'],
                    'slot' => $type['slot']                    
                ]);
                
                $pokemonById->types()->save($newType);
            }

            return response()->json([
                "Successful operation" => 'Pokemon added to database'
             ],200);
        
        }  
    }

    public function paginated(Request $request)
    {
        $response = [];
        $typesArray = [];

        $pokemons = Pokemon::all();

        $sort = $request->input('sort');
        $limit = intval($request->input('limit'));
        if($limit == null){
            $limit = count($pokemons);
        }

        if($sort == 'id-desc'){
            $pokemons = $pokemons->sortByDesc('id');
        }elseif($sort == 'name-asc'){
            $pokemons = $pokemons->sortBy('name');
        }elseif($sort == 'name-desc'){
            $pokemons = $pokemons->sortByDesc('name');
        } elseif($sort == 'id-asc'){
            $pokemons = $pokemons->sortBy('id');
        }

        foreach ($pokemons as $pokemon){
            $sprite_front_default = DB::table('sprites')->where('pokemon_id', $pokemon['id'])->value('front_default');

            $types = DB::table('types')->where('pokemon_id', $pokemon['id'])->get();
            foreach($types as $type){
                $newType = array("slot" => $type->slot, "type" => array("name" => $type->type));
                array_push($typesArray, $newType);
            }

            $newPokemon = array( 
                "id" => $pokemon['id'],
                "name" => $pokemon['name'],
                "sprites" => array(
                    "front_default" => $sprite_front_default),
                "types" => $typesArray,
              ); 

              array_push($response, $newPokemon);
              $typesArray = [];
        }

        //dd($response);
        $response = $this->paginate($response,$limit);
        $response->withPath('/api/v2/pokemons');

        return view('list',['pokemons'=>$response]);
    }

    public function paginate($items, $perPage = 4, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
    }

}
