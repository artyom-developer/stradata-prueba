<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Person;

class PersonaController extends Controller
{

    public function buscarNombre(Request $request){


        try {
            
            $nombre = $request['nombre_buscado'];
            $porcentaje = $request['porcentaje_buscado'];
    
            $coincidencia = "(((CHAR_LENGTH (`nombre`) - levenshtein('".$nombre."', `nombre`))*100)/CHAR_LENGTH (`nombre`))";
        
            $data =  Person::selectRaw("$coincidencia AS coincidencia, nombre, departamento, municipio, localidad, tipo_persona, tipo_cargo  ") 
            ->whereRaw("$coincidencia >=  ?  ", $porcentaje)        
            ->simplePaginate(10);
              
            $response['data'] = $data;
            $response['success'] = true;

        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
        }
        return $response;
    }
     
}
