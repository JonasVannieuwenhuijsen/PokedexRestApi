<?php

namespace App\Http\Controllers;
use App\Models\Team;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        return response()->json([
            "Successful operation" => $teams
         ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $newTeam = Team::query()->Create([
            'name' => $request->name,
            'pokemon_1'=> null,
            'pokemon_2'=> null,
            'pokemon_3'=> null,
            'pokemon_4'=> null,
            'pokemon_5'=> null,
            'pokemon_6'=> null,
        ]);

        return response()->json([
            "Successful operation" => $newTeam
         ],201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::find($id);
        if($team == null){
            return response()->json([
                "error" => "ERROR",
                "error_message" => "Team not found"
             ],404);
        }else{
            return response()->json([
                "Successful operation" => $team
            ],200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $team = Team::find($id);
        if($team == null){
            return response()->json([
                "error" => "ERROR",
                "error_message" => "Team not found"
             ],404);
        }else{

            $lengthOfArray = count($request->pokemons);

            if($lengthOfArray > 0){
                $team->pokemon_1 = $request->pokemons[0];
            } else{
                $team->pokemon_1 = null;
            }
            if($lengthOfArray > 1){
                $team->pokemon_2 = $request->pokemons[1];
            }else{
                $team->pokemon_2 = null;
            }
            if($lengthOfArray > 2){
                $team->pokemon_3 = $request->pokemons[2];
            }else{
                $team->pokemon_3 = null;
            }
            if($lengthOfArray > 3){
                $team->pokemon_4 = $request->pokemons[3];
            }else{
                $team->pokemon_4 = null;
            }
            if($lengthOfArray > 4){
                $team->pokemon_5 = $request->pokemons[4];
            }else{
                $team->pokemon_5 = null;
            }
            if($lengthOfArray > 5){
                $team->pokemon_6 = $request->pokemons[5];
            }else{
                $team->pokemon_6 = null;
            }

            $team->save();

            return response()->json([
                "Successful operation" => $team
            ],200);
        }

        return $request->pokemons[3];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::find($id);
        if($team == null){
            return response()->json([
                "error" => "ERROR",
                "error_message" => "Team not found"
             ],404);
        }else{

            $team->delete();

            return response()->json([
                "Successful operation" => $team
            ],200);
        }
    }
}
