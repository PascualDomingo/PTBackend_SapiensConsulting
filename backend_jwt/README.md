<p align="center">PRUEBA TÉCNICA BACKEND</p>

### Documentación técnica

#### LIBRERIAS INSTALADAS
* php artisan make:model nombremodelo --all  //para crear modelo, controlador, etc. crea todo si se agrega el --all
* php artisan migrate  //comando para crear tabla en la base de datos 
* composer require tymon/jwt-auth  //instalacion de composer para jwt
* php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider" //publicar jwt
* php artisan jwt:secret //crear llave secreta, para generar uno, cada que se crea un token se mescla con la llave secreta


### PARÁMETROS:

---

## Registro de usuarios
##### Método: POST
##### Ruta: http://127.0.0.1:8000/api/usuario
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
##### Ruta: http://127.0.0.1:8000/api/auth/login
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



