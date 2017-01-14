<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Fabricante; //Modelo Fabricante

class FabricanteController extends Controller {
	
	public function __construct()
	{
		$this->middleware('auth.basic.once', ['only' => ['store','update','destroy']]); //Indicamos que tipo de middleware que vamos a usar
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return response()->json(['data' => Fabricante::all()],200);
		//return Fabricante::all(); //Regresa todos los fabricantes
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request) //Recibiendo la petición con inyección de dependencias
	{
		if(!$request->input('nombre') || !$request->input('telefono')) //Nombre y teléfono para crear al fabricante
		{
			return response()->json(['mensaje' => 'No es posible procesar los valores','codigo' => 422],422);
		}

		Fabricante::create($request->all()); //Indicamos que recibimos todos los valores	
		return response()->json(['mensaje' => 'Fabricante insertado'], 201);	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$fabricante = Fabricante::find($id);
		if(!$fabricante)
		{
			return response()->json(['mensaje' => 'No se encuentra este fabricante', 'codigo' => 404],404);
		}

		return response()->json(['data' => $fabricante],200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$metodo = $request->method();
		$fabricante = Fabricante::find($id);

		if(!$fabricante)
		{
			return response()->json(['mensaje'=>'No se encuentra este fabricante','codigo'=>404],404);
		}

		if($metodo === 'PATCH') //Si metodo es igual tanto en tipo como en valor
		{
			$bandera = false;
			$nombre = $request->input('nombre');
			
			if($nombre != null && $nombre != '')
			{
				$fabricante->nombre = $nombre;
				$bandera = true;
			}

			$telefono = $request->input('telefono');

			if($telefono != null && $telefono != '')
			{
				$fabricante->telefono = $telefono;
				$bandera = true;
			}

			if($bandera)
			{
				$fabricante->save(); //Con este método guardamos la informacion recibida en la BD
				return response()->json(['mensaje' => 'Fabricante editado'], 200);
			}else{
				//El codigo 304 indica que no hay neesidad de retornar nada
				return response()->json(['mensaje'=>'No se modifico ningun fabricante'],200); 
			}
		
		}else{

			$nombre = $request->input('nombre');
			$telefono = $request->input('telefono');

			if(!$nombre || !$telefono)
			{
				return response()->json(['mensaje'=>'No es posible procesar los valores','codigo'=>422],422);

			}else{
				$fabricante->nombre = $nombre;
				$fabricante->telefono = $telefono;
				$fabricante->save();

				return response()->json(['mensaje' => 'Fabricante insertado'], 200);
			}
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$fabricante = Fabricante::find($id);

		if(!$fabricante)
		{
			return response()->json(['mensaje'=>'No se encuentra este fabricante','codigo'=>404],404); 
		
		}else{
			
			//No se puede eliminar un fabricante que contenga vehiculos
			$vehiculos = $fabricante->vehiculos; //De esta forma obtenemos solamente el array
			
			if(sizeof($vehiculos) > 0) // sizeof La cantidad de vehiculos
			{
				return response()->json(['mensaje'=>'Este fabricante posee vehiculos asociados y no puede ser eliminado. Eliminar primero sus vehiculos','codigo'=>409],409); 
			
			}else{
				$fabricante->delete();
				return response()->json(['mensaje' => 'Fabricante eliminado'], 200);
			}
		}
	}
}
