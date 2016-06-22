<?php

class BaseController extends Controller {
	const EXPORT_XLSP = 'xlsp'; //exportar a excel todos los preinscriptos
        const EXPORT_PDFP = 'pdfp'; //exportar a pdf todos los preinscriptos
        
        const EXPORT_XLSI = 'xlsi'; //exportar a excel todos los inscriptos
        const EXPORT_PDFI = 'pdfi'; //exportar a pdf todos los inscriptos
        const EXPORT_CSV = 'csv'; //exportar a csv todos los inscriptos
        
        const EXPORT_XLSAS = 'xlsas'; //exportar a excel todos los asistentes a evento
        const EXPORT_PDFASIST = 'pdfasist'; //exportar a pdf todos los asistentes a un evento
        
        const EXPORT_XLSAPDOS = 'xlsapdos'; //exportar a excel todos los aprobados de un curso
        const EXPORT_PDFAPDOS = 'pdfapdos'; //exportar a pdf todos los aprobados de un curso
        
        const EXPORT_PDFA = 'pdfa'; //exportar a pdf los datos del Aprobado (p/el certificado)
        const EXPORT_PDFAS = 'pdfas'; //exportar a pdf los datos del Asistente (p/el certificado)
        const EXPORT_PDFCAP = 'pdfcap'; //exportar a pdf los datos del capacitador (p/el certificado)
        
        const EXPORT_XLSCAPES = 'xlscapes'; //exportar a xls el listado de los capacitadores de una Oferta
        const EXPORT_PDFCAPES = 'pdfcapes'; //exportar a pdf el listado de los capacitadores de una Oferta

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
        
    protected function exportarXLS($filename, $rows, $view)
    {
        Excel::create($filename, function($excel) use($rows, $view) {
            $excel->sheet('hoja1', function($sheet) use($rows, $view) {
                $sheet->loadView($view)                        
                        ->with('rows', $rows);
                //$sheet->setAllBorders('thin');
            }); 
        })->export('xls');
    }
    
    protected function exportarCSV($fname, $rowss, $vieww)
    {
        Excel::create($fname, function($excel) use($rowss, $vieww) {
            $excel->sheet('hoja1', function($sheet) use($rowss, $vieww) {
                $sheet->loadView($vieww)
                        ->with('rows', $rowss);
            }); 
        })->export('csv');
    }

    protected function exportarPDF($filename, $rows, $view)
    {
        $html = '<!DOCTYPE html>
                <html lang="es-AR">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                        <style>
                            body {
                                //border: 1px solid red;
                                margin: -30px;
                                width: 100%;
                                height: 760px;
                                font-family: serif !Important;
                            }';
        $aux = View::make($view, compact('rows'));
        $html .= $aux->render();

        return PDF::load($html, 'A4', 'landscape')->show($filename);
    }
    
    protected function obtenerElId($string) {
        $id = 0;
        $aux = explode('*-AAA', $string);
        if(sizeof($aux)>1){
            $id = (int)$aux[1];
        }else{
            $id = (int)$aux[0];
        }
        return $id;
    }
    
    public function getEstiloMensajeCabecera($tipoAlert, $tipoIcono) {    
        return "<div class='flash alert alert-dismiss alert-$tipoAlert'><button type='button' class='close' data-dismiss='alert'>x</button><p style='text-align: center'><span class='$tipoIcono'></span>";
    }
        
    public function getEstiloMensajeFinal() {
        return '</p></div>';
    }
    
    public function nombreMes($mes){
        setlocale(LC_TIME, 'spanish');  
        $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
        return $nombre;
    }
    
    private function cadena_random($largo_cadena){
        $cadena = '';
        $caracteres = array_merge(range(0, 9), range('A', 'Z'));
        for($i=0;$i<$largo_cadena;$i++){
            $cadena .= $caracteres[array_rand($caracteres)];
        }
        return $cadena;
    }
    
    public function generarCodigoDeVerificacion() {
        $codigo = '';
        for($i=0;$i<3;$i++){
            $codigo .= $this->cadena_random(4)."-";
        }
        $codigo .= $this->cadena_random(4);
        return $codigo;
    }
}
