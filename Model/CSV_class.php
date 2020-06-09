<?php
	
	class CSV_class{
		
		private $_csv_file = null;
		
		public function __construct($csv_file) {
			if (file_exists($csv_file)) { 
				$this->_csv_file = $csv_file; 
			}
			else { 
				throw new Exception("Файл ".$csv_file." не найден"); 
			}
		}
	 
		public function setCSV(Array $csv) {
			$handle = fopen($this->_csv_file, "a"); 
	 
			foreach ($csv as $value) { 
				fputcsv($handle,  $value, ";"); 
				//fputcsv($handle, explode(";", $value), ";"); 
			}
			fclose($handle); //Закрываем
		}
} 
?>