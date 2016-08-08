<?php

class RequisitosController extends BaseController {

	public function __contruct(Oferta $oferta, Requisito $requisito)
	{
		$this->Oferta = $oferta;
		$this->requisito = $requisito;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($oferta_id)
	{
            $oferta    = Oferta::findOrFail($oferta_id);
            $input    = Input::all();

            $validation = Validator::make($input, Requisito::$rules);

            if ($validation->fails())
                    return Response::json(array('error' => 'Error al guardar'), 400);

            $obj = new Requisito;
            $obj = $obj->create(array_merge($input, array('oferta_id' => $oferta_id)));
            return View::make('requisitos.item', array('oferta' => $oferta, 'req' => $obj));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($oferta_id, $id)
	{
		$repo = new Requisito;
		$repo = $repo->findOrFail($id);
            
        $repo->delete();
		return Response::make('', 200);
	}

}
