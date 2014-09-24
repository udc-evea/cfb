<?php

class RequisitosController extends BaseController {

	/**
	 * el repositorio
	   @var Requisito
	 */
	public function __contruct(Curso $curso, Requisito $requisito)
	{
		$this->curso = $curso;
		$this->requisito = $requisito;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($curso_id)
	{
        return View::make('requisitos.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($curso_id)
	{
        return View::make('requisitos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($curso_id)
	{
		$curso    = Curso::findOrFail($curso_id);
        $input    = Input::all();

        $validation = Validator::make($input, Requisito::$rules);

        if ($validation->fails())
        	return Response::json(array('error' => 'Error al guardar'), 400);
        
    	$obj = new Requisito;
    	$obj = $obj->create(array_merge($input, array('oferta_id' => $curso_id)));
    	return View::make('requisitos.item', array('curso' => $curso, 'req' => $obj));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($curso_id, $id)
	{
        return View::make('requisitos.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($curso_id, $id)
	{
        return View::make('requisitos.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($curso_id, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($curso_id, $id)
	{
		$repo = new Requisito;
		$repo = $repo->findOrFail($id);
            
        $repo->delete();
		return Response::make('', 200);
	}

}
