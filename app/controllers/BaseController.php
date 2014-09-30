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
        
        protected function exportar($filename, $rows)
        {
            Excel::create($filename, function($excel) use($rows) {
                $excel->sheet('First sheet', function($sheet) use($rows) {
                    $sheet->fromArray($rows);
                }); 
            })->export('xls');
        }

}
