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
        
        protected function exportarCSV($filename, $rows)
        {
            $ftemp = fopen('php://temp', 'r+');
            $output = '';
            
            fputcsv($ftemp, $rows[0]->getColumnasCSV());
            rewind($ftemp);
            $fila = fread($ftemp, 1048576);
            fclose($ftemp);
            $output .= $fila;
            
            foreach($rows as $row)
            {
                $fila = $row->toCSV();
                
                $output .= $fila;
            }
            
            $headers = array(
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            );

            return Response::make(rtrim($output, "\n"), 200, $headers);
        }

}
