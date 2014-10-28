<?php

class BaseController extends Controller {
	const EXPORT_XLS = 'xls';
	const EXPORT_PDF = 'pdf';

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

    protected function exportarPDF($filename, $rows, $view)
    {
        $html = View::make($view, compact('rows'));

        return PDF::load($html, 'A4', 'landscape')->show();
    }
    
    protected function exportarFormPDF($filename, $data, $view)
    {
        $html = View::make($view, $data);

        return PDF::load($html, 'A4', 'portrait')->show();
    }

}
