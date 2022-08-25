# PokedexRestApi

PokedexRestApi is an Rest Api created by Jonas Vannieuwenhuijsen.

## Api calls
- "api/v1/pokemons/" :
    - Returns list of all pokemons in database
- "api/v1/pokemons/{id}" :
    - Returns pokemon with given id
- "api/v1/search/?NameOrType" :
    - Returns pokemon(s) with given name or type
- "api/v1/addFromExternalApi/{nameOrID}" :
    - Adds pokemon from external api to the database
- "api/v2/pokemons?sort&limit&page" :
    - Returns sorted pokemons (amount equal to limit) in paginated form
- "api/v1/teams" :
    - Get -> Returns all teams
    - Post -> Create empty team with name
- "api/v1/teams/{id}" :
    - Get -> Returns team with given id
    - Post -> Update teams pokemons (body = array of pokemon id)
- "api/v1/teams/delete/{id}" :
    - Delete team with given id from database

## Included files
- pokemondatabase.sql :
    - Database with preloaded pokemons
- pokemons.json :
    - Json file with 151 pokemons for seeder (dont forget to update path of json file in seeder)

## Database structure
![alt text](https://github.com/JonasVannieuwenhuijsen/PokedexRestApi/blob/main/DatabaseStructure.png?raw=true)

All relationships of pokemon are 'hasMany' only the relationship between pokemon and sprite is 'hasOne'.