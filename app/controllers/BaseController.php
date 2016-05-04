<?php

class BaseController extends Controller {
	const EXPORT_XLSP = 'xlsp';
        const EXPORT_XLSI = 'xlsi';
	const EXPORT_PDFP = 'pdfp';
        const EXPORT_PDFI = 'pdfi';
        const EXPORT_CSV = 'csv';
        const EXPORT_PDFA = 'pdfa';
        const EXPORT_PDFAS = 'pdfas';
        const EXPORT_PDFCAP = 'pdfcap';

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
        $html = View::make($view, compact('rows'));

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
        $caracteres = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));        
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
