<?php

class BaseController extends Controller {

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
        
        protected function exportar($filename, $rows, $view)
        {
            Excel::create($filename, function($excel) use($rows, $view) {
                $excel->sheet('hoja1', function($sheet) use($rows, $view) {
                    $sheet->loadView($view)
      					->with('rows', $rows);
                    
                }); 
            })->export('xls');
        }

}
