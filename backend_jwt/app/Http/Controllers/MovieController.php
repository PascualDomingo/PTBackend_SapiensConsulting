<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;
use App\Models\Loguser;


class MovieController extends Controller
{
    protected $apiKey;
    protected $apitoken;
    protected $user;

    public function __construct()
    {
        // Asigna tu API Key de TMDb
        $this->apiKey = env('TMDB_API_KEY');
        $this->apitoken = env('TMDB_API_TOKEN');
        $this->user = auth()->user();
    }

    /* obtiene las últimas películas con paginacion **/
    public function getLatestMovies()
    {

        try {
            //$client = new Client();
            $client = new Client([
                'verify' => false,
            ]);
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/now_playing', [
                'query' => [
                    'api_key' => $this->apiKey,
                    'language' => 'en-US',
                    'page' => 1,
                    'per_page' => 15, // Ítems por página
                ],
            ]);
        
            // Procesa la respuesta HTTP correcta aquí
            $statusCode = $response->getStatusCode(); // Código de estado HTTP
            $responseData = $response->getBody()->getContents(); // Contenido de la respuesta
            
            /** registrar logs de este evento */
            if ($this->user) {
                // Si el usuario está autenticado, registra el log
                Loguser::create([
                    'user_id' => $this->user->id, // Acceder a la propiedad id del usuario
                    'tipo_evento' => 'metodo GET, url: api/movies/top', // Tipo de evento
                    'descripcion' => 'listado de las ultimas peliculas con paginacion y maximo 15 items
                    por pagina', // Descripción del evento
                ]);
            }

            // Retorna la respuesta HTTP correcta
            return response()->json(['status' => 'success', 'data' => json_decode($responseData)], $statusCode);
        } catch (ConnectException $e) {
            // Error de conexión (no se puede establecer conexión)
            return response()->json(['status' => 'error', 'message' => 'No se pudo establecer la conexión con el servidor'], 500);
        } catch (ServerException $e) {
            // Error del servidor remoto
            return response()->json(['status' => 'error', 'message' => 'Error en el servidor remoto'], 500);
        } catch (RequestException $e) {
            // Otros errores de solicitud
            if ($e->hasResponse()) {
                // Obtén la respuesta HTTP del error
                $errorResponse = $e->getResponse();
                $errorCode = $errorResponse->getStatusCode(); // Código de estado HTTP del error
                $errorMessage = $errorResponse->getBody()->getContents(); // Mensaje de error
                return response()->json(['status' => 'error', 'message' => $errorMessage], $errorCode);
            } else {
                // Si no hay respuesta HTTP, se produjo un error de conexión
                return response()->json(['status' => 'error', 'message' => 'Error de conexión'], 500);
            }
        }


    }

    /** realiza una búsqueda de péliculas por nombre */
    public function searchMovies(Request $request)
    {
        $query = $request->input('nombre');
        $client = new Client([
            'verify' => false,
        ]);
        $response = $client->get("https://api.themoviedb.org/3/search/movie?api_key={$this->apiKey}&language=en-US&query={$query}&page=1");

        /** registrar logs de este evento */
        if ($this->user) {
            // Si el usuario está autenticado, registra el log
            Loguser::create([
                'user_id' => $this->user->id, // Acceder a la propiedad id del usuario
                'tipo_evento' => 'metodo GET success', // Tipo de evento
                'descripcion' => 'buscar una o muchas peliculas filtrando por nombre', // Descripción del evento
            ]);
        }

        return response()->json(json_decode($response->getBody(), true));

    }

    public function marcarPeliFavorita(Request $request)
    {

        try {
            //obtiene el id de la película por parámetro
            $idPelicula = $request->input('id_pelicula');
            // Crea una instancia del cliente Guzzle
            $client = new Client([
                'verify' => false,
            ]);

            $response = $client->request('POST', 'https://api.themoviedb.org/3/account/{account_id}/favorite', [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->apitoken,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'media_type' => 'movie',
                    'media_id' => $idPelicula,
                    'favorite' => true, // Marcar como favorita
                ],
            ]);
        
            // Procesa la respuesta HTTP correcta aquí
            $statusCode = $response->getStatusCode(); // Código de estado HTTP
            $responseData = $response->getBody()->getContents(); // Contenido de la respuesta
            
            /** registrar logs de este evento */
        if ($this->user) {
            // Si el usuario está autenticado, registra el log
            Loguser::create([
                'user_id' => $this->user->id, // Acceder a la propiedad id del usuario
                'tipo_evento' => 'metodo GET success', // Tipo de evento
                'descripcion' => ' marcar la pelicula como favorita', // Descripción del evento
            ]);
        }

            // Retorna la respuesta HTTP correcta
            return response()->json(['status' => 'success', 'data' => json_decode($responseData)], $statusCode);
        } catch (ConnectException $e) {
            // Error de conexión (no se puede establecer conexión)
            return response()->json(['status' => 'error', 'message' => 'No se pudo establecer la conexión con el servidor'], 500);
        } catch (ServerException $e) {
            // Error del servidor remoto
            return response()->json(['status' => 'error', 'message' => 'Error en el servidor remoto'], 500);
        } catch (RequestException $e) {
            // Otros errores de solicitud
            if ($e->hasResponse()) {
                // Obtén la respuesta HTTP del error
                $errorResponse = $e->getResponse();
                $errorCode = $errorResponse->getStatusCode(); // Código de estado HTTP del error
                $errorMessage = $errorResponse->getBody()->getContents(); // Mensaje de error
                return response()->json(['status' => 'error', 'message' => $errorMessage], $errorCode);
            } else {
                // Si no hay respuesta HTTP, se produjo un error de conexión
                return response()->json(['status' => 'error', 'message' => 'Error de conexión'], 500);
            }
        }
    }


    public function obtenerPeliculasFavoritas()
    {
        try {
            // Crea una instancia del cliente Guzzle
            $client = new Client([
                'verify' => false,
            ]);

            // Realiza la solicitud para obtener las películas favoritas del usuario
            $response = $client->request('GET', 'https://api.themoviedb.org/3/account/{account_id}/favorite/movies', [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->apitoken,
                    'Accept' => 'application/json',
                ],
            ]);

            // Procesa la respuesta HTTP correcta aquí
            $statusCode = $response->getStatusCode(); // Código de estado HTTP
            $responseData = $response->getBody()->getContents(); // Contenido de la respuesta

            if ($this->user) {
                // Si el usuario está autenticado, registra el log
                Loguser::create([
                    'user_id' => $this->user->id, // Acceder a la propiedad id del usuario
                    'tipo_evento' => 'metodo GET success', // Tipo de evento
                    'descripcion' => 'listado de peliculas marcadas como favoritas', // Descripción del evento
                ]);
            }

            // Retorna la respuesta HTTP correcta
            return response()->json(['status' => 'success', 'data' => json_decode($responseData)], $statusCode);
            
        } catch (ConnectException $e) {
            // Error de conexión (no se puede establecer conexión)
            if ($this->user) {
                // Si el usuario está autenticado, registra el log
                Loguser::create([
                    'user_id' => $this->user->id, // Acceder a la propiedad id del usuario
                    'tipo_evento' => 'metodo GET error', // Tipo de evento
                    'descripcion' => 'No se pudo establecer la conexión con el servido', // Descripción del evento
                ]);
            }
            return response()->json(['status' => 'error', 'message' => 'No se pudo establecer la conexión con el servidor'], 500);
        } catch (ServerException $e) {
            // Error del servidor remoto
            if ($this->user) {
                // Si el usuario está autenticado, registra el log
                Loguser::create([
                    'user_id' => $this->user->id, // Acceder a la propiedad id del usuario
                    'tipo_evento' => 'metodo GET error', // Tipo de evento
                    'descripcion' => 'Error en el servidor remoto', // Descripción del evento
                ]);
            }
            return response()->json(['status' => 'error', 'message' => 'Error en el servidor remoto'], 500);
        } catch (RequestException $e) {
            // Otros errores de solicitud
            if ($e->hasResponse()) {
                // Obtén la respuesta HTTP del error
                $errorResponse = $e->getResponse();
                $errorCode = $errorResponse->getStatusCode(); // Código de estado HTTP del error
                $errorMessage = $errorResponse->getBody()->getContents(); // Mensaje de error
                if ($this->user) {
                    // Si el usuario está autenticado, registra el log
                    Loguser::create([
                        'user_id' => $this->user->id, // Acceder a la propiedad id del usuario
                        'tipo_evento' => 'metodo GET error', // Tipo de evento
                        'descripcion' => $errorMessage, // Descripción del evento
                    ]);
                }
                return response()->json(['status' => 'error', 'message' => $errorMessage], $errorCode);
            } else {
                // Si no hay respuesta HTTP, se produjo un error de conexión
                return response()->json(['status' => 'error', 'message' => 'Error de conexión'], 500);
            }
        }
    }

  


}