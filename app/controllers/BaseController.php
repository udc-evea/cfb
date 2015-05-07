<?php

class BaseController extends Controller {
	const EXPORT_XLSP = 'xlsp';
        const EXPORT_XLSI = 'xlsi';
	const EXPORT_PDFP = 'pdfp';
        const EXPORT_PDFI = 'pdfi';        
        const EXPORT_CSV = 'csv';

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

        return PDF::load($html, 'A4', 'landscape')->show();
    }
}
