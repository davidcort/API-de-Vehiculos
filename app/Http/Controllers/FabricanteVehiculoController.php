<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Fabricante;
use App\Vehiculo;
use App\Http\Middleware\Authenticate;

use Illuminate\Http\Request;

class FabricanteVehiculoController extends Controller {

	public function __construct()
	{
		$this->middleware('auth.basic', ['only' => ['store','update','destroy']]); //Indicamos que tipo de middleware que vamos a usar
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$fabricante = Fabricante::find($id);

		if(!$fabricante)
		{
			return response()->json(["mensaje"=>"No se encuentra este fabricante", "codigo"=>404],400);		
		}

		return response()->json(['data'=>$fabricante->vehiculos()->get()],200); //Se obtienen todos los vehiculos del fabricante con el metodo vehiculos()
		//return 'mostrando los vehiculos del fabricante con id '.$id;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		return 'mostrando formulario para agregar vehiculo al fabricante '.$id;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request, $id)
	{
		//fabricante_id
		//serie (autoincrement) no neesario
		//color
		//clilindraje
		//potencia
		//peso

		if(!$request->input('color') || !$request->input('cilindraje') || !$request->input('potencia') || !$request->input('peso'))
		{
			return response()->json(['mensaje'=>'No se pudieron procesar los valores','codigo'=>422],422);
		}

		$fabricante = Fabricante::find($id); //Tomamos el id de la URL

		if(!$fabricante)
		{
			return response()->json(['mensaje'=>'No existe fabricante asociado','codigo'=>404],404);
		}

		$fabricante->vehiculos()->create($request->all()); //Accedemos a la relacion con vehiculos

		return response()->json(['mensaje'=>'Vehiculo insertado'],201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($idFabricante, $idVehiculo)
	{
		return 'Mostrando vehiculo ' . $idVehiculo . ' del fabricante ' . $idFabricante;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($idFabricante, $idVehiculo)
	{
		return "mostrando formulario para editar el vehiculo $idVehiculo del fabricante $idFabricante";
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($idFabricante, $idVehiculo)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idFabricante, $idVehiculo)
	{
		//
	}

}
