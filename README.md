# PTBackend_SapiensConsulting
realizar un micro aplicativo con características esenciales para una estructura general de un proyecto.


<p align="center">PRUEBA TÉCNICA BACKEND</p>

### Documentación técnica

    {
        "php": "^8.1",
        "guzzlehttp/guzzle": "^7.8",
        "laravel/framework": "^10.10",
        "laravel/sanctum": "^3.3",
        "laravel/tinker": "^2.8",
        "tymon/jwt-auth": "^2.1"
    }

php artisan serve
### PARÁMETROS:

---

## prueba
##### Método: GET
##### Ruta: http://34.16.171.107:8000/api/test
###### respuesta:
    hola mundo v2

## Registro de usuarios
##### Método: POST
##### Ruta: http://34.16.171.107:8000/api/usuario
###### Body:
    {
        "name": "pdd",
        "telefono":"12345678",
        "email": "pdd@gmail.com",
        "password": "123"
    }
###### Respuesta:
    {
        "message": "Usuario registrado",
        "user": {
            "name": "pdd",
            "telefono": "12345678",
            "email": "pdd@gmail.com",
            "updated_at": "2024-04-21T04:24:55.000000Z",
            "created_at": "2024-04-21T04:24:55.000000Z",
            "id": 1
        }
    }
##### Error:
    {
        "name": [
            "The name field is required."
        ],
        "telefono": [
            "The telefono field must not be greater than 12 characters."
        ]
    }

    {
        "email": [
            "The email has already been taken."
        ]
    }


## Login
##### Método: POST
##### Ruta: http://34.16.171.107:8000/api/auth/login
###### Body:
    {
        "email": "pdd@gmail.com",
        "password": "123"
    }
###### Respuesta:
    {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI....",
        "token_type": "bearer",
        "expires_in": 3600 //equivalente a una hora
    }
##### Error:
    {
        "error": "Unauthorized"
    }



## Lista de las últimas películas con paginación
##### Método: GET
##### Método: Authorization: Bearer Toekn
##### Ruta: http://34.16.171.107:8000/api/movies/top

###### Respuesta:
    {
        "status": "success",
        "data": {
            "dates": {
                "maximum": "2024-04-24",
                "minimum": "2024-03-13"
            },
            "page": 1,
            "results": [
                {
                    "adult": false,
                    "backdrop_path": "/xOMo8BRK7PfcJv9JCnx7s5hj0PX.jpg",
                    "genre_ids": [
                        878,
                        12
                    ],
                    "id": 693134,
                    "original_language": "en",
                    "original_title": "Dune: Part Two",
                    "overview": "Follow the mythic journey of Paul Atreides as he unites with Chani and the Fremen while on a path of revenge against the conspirators who destroyed his family. Facing a choice between the love of his life and the fate of the known universe, Paul endeavors to prevent a terrible future only he can foresee.",
                    "popularity": 2494.582,
                    "poster_path": "/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg",
                    "release_date": "2024-02-27",
                    "title": "Dune: Part Two",
                    "video": false,
                    "vote_average": 8.286,
                    "vote_count": 3120
                }, ...
            ],
            "total_pages": 222,
            "total_results": 4431
        }
    }

###### Error, si no está autenticado
    {
        "error": "Unauthenticated."
    }


## API para buscar una o muchas peliculas filtrando por nombre
##### Método: GET
##### Método: Authorization: Bearer Toekn
##### Ruta: http://34.16.171.107:8000/api/movies/buscar/nombre?nombre=titanic II
###### Respuesta:
    {
        "page": 1,
        "results": [
            {
                "adult": false,
                "backdrop_path": "/e9XRikkyth0GtG8RkU3XNm0oMsA.jpg",
                "genre_ids": [
                    28,
                    53,
                    10749,
                    12
                ],
                "id": 44918,
                "original_language": "en",
                "original_title": "Titanic II",
                "overview": "On the 100th anniversary of the original voyage, a modern luxury liner christened \"Titanic 2,\" follows the path of its namesake. But when a tsunami hurls an ice berg into the new ship's path, the passengers and crew must fight to avoid a similar fate.",
                "popularity": 28.813,
                "poster_path": "/3m12UeP1DMfhYZyvpLftaJGsyp3.jpg",
                "release_date": "2010-08-07",
                "title": "Titanic II",
                "video": false,
                "vote_average": 4.993,
                "vote_count": 403
            }, ...
        ],
        "total_pages": 1,
        "total_results": 3
    }

###### Error, si no está autenticado
    {
        "error": "Unauthenticated."
    }

## API para marcar la pelicula como favorita
##### Método: GET
##### Método: Authorization: Bearer Toekn
##### Ruta: http://34.16.171.107:8000/api/movies/favorito?id_pelicula=693134
###### Respuesta:
    {
        "status": "success",
        "data": {
            "success": true,
            "status_code": 12,
            "status_message": "The item/record was updated successfully."
        }
    }
###### Error:
    {
        "status": "error",
        "message": "{\"success\":false,\"status_code\":34,\"status_message\":\"The resource you requested could not be found.\"}"
    }

## API para traer listado de peliculas marcadas como favoritas,
##### Método: GET
##### Método: Authorization: Bearer Toekn
##### Ruta: http://34.16.171.107:8000/api/movies/lista/favorito
###### Respuesta:
    {
        "status": "success",
        "data": {
            "page": 1,
            "results": [
                {
                    "adult": false,
                    "backdrop_path": "/xOMo8BRK7PfcJv9JCnx7s5hj0PX.jpg",
                    "genre_ids": [
                        878,
                        12
                    ],
                    "id": 693134,
                    "original_language": "en",
                    "original_title": "Dune: Part Two",
                    "overview": "Follow the mythic journey of Paul Atreides as he unites with Chani and the Fremen while on a path of revenge against the conspirators who destroyed his family. Facing a choice between the love of his life and the fate of the known universe, Paul endeavors to prevent a terrible future only he can foresee.",
                    "popularity": 2494.582,
                    "poster_path": "/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg",
                    "release_date": "2024-02-27",
                    "title": "Dune: Part Two",
                    "video": false,
                    "vote_average": 8.283,
                    "vote_count": 3150
                }, ...
            ],
            "total_pages": 1,
            "total_results": 6
        }
    }



##  logs de los movimientos del login de usuarios
##### Método: GET
##### Método: Authorization: Bearer Toekn
##### Ruta: http://34.16.171.107:8000/api/logs
###### Respuesta:
    {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "user_id": "0",
                "tipo_evento": "login_success",
                "descripcion": "Usuario autenticado correctamente",
                "created_at": "2024-04-21T20:41:12.000000Z",
                "updated_at": "2024-04-21T20:41:12.000000Z"
            },..
        ],
        "first_page_url": "http://34.16.171.107:8000/api/logs?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://34.16.171.107:8000/api/logs?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },..
        ],
        "next_page_url": null,
        "path": "http://34.16.171.107:8000/api/logs",
        "per_page": 15,
        "prev_page_url": null,
        "to": 3,
        "total": 3
    }


#### LIBRERIAS INSTALADAS
* php artisan make:model nombremodelo --all  //para crear modelo, controlador, etc. crea todo si se agrega el --all
* php artisan migrate  //comando para crear tabla en la base de datos 
* composer require tymon/jwt-auth  //instalacion de composer para jwt
* php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider" //publicar jwt
* php artisan jwt:secret //crear llave secreta, para generar uno, cada que se crea un token se mescla con la llave secreta
* composer require guzzlehttp/guzzle //integración de guzzle en el proyecto
* php artisan make:controller NombreDelControlador  //crear un nuevo controlador
* php artisan migrate:fresh --seed
* php artisan serve --host 0.0.0.0 //iniciar serve en MV GCP