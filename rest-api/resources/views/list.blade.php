<h1>Pokemon List</h1>

<table border="1">
<tr>
    <td>ID</td>
    <td>Name</td>
    <td>Sprites (front_default)</td>
    <td>Type (slot 1)</td>
    <td>Type (slot 2)</td>
</tr>
@foreach($pokemons as $pokemon)
<tr>
    <td>{{$pokemon['id']}}</td>
    <td>{{$pokemon['name']}}</td>
    <td>{{$pokemon['sprites']['front_default']}}</td>
    <td>{{$pokemon['types'][0]['type']['name']}}</td>
    @if(count($pokemon['types'])>1)
        <td>{{$pokemon['types'][1]['type']['name']}}</td>
    @else
        <td>none</td>
    @endif
</tr>
@endforeach
</table>

<span>
    {{$pokemons->appends(request()->query())->links()}}
</span>

<style>
    .w-5{
        display: none
    }
</style>    