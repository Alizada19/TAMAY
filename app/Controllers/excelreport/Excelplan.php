<?php

namespace App\Controllers\excelreport;
use App\Controllers\BaseController;
use App\Models\excelreport\ExcelplanModel;
use CodeIgniter\I18n\Time;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
//use PhpOffice\PhpSpreadsheet\Shared\Date;

class Excelplan extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->ExcelplanModel = new ExcelplanModel();
		$request = \Config\Services::request();
        helper('fornames');
	}
	
	public function index()
    {		
	
			/*$spreadsheet = new Spreadsheet();
			$activeWorksheet = $spreadsheet->getActiveSheet();
			$activeWorksheet->setCellValue('A1', 'Hello World !');
			$writer = new Xlsx($spreadsheet);
			//$writer->save('hello world.xlsx'); 
			ob_clean();
		    //ob_start();
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Disposition: attachment;filename=\"2-download.xlsx\"");
			header("Cache-Control: max-age=0");
			header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
			header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
			header("Cache-Control: cache, must-revalidate");
			header("Pragma: public");
			$writer->save("php://output");
			//ob_end_flush();
			exit;*/
			
			// Load the Excel template
			$spreadsheet = IOFactory::load(FCPATH.'template\tamay.xlsx');
			// Access the active worksheet
			$sheet = $spreadsheet->getActiveSheet();
			$sdate='2024-10-01';
			$edate='2024-12-31';
			
			//Glc part Start
			//Get the daily total sales for the gilasco shop
			$glcresult = $this->ExcelplanModel->getResult('daily', '2', $sdate, $edate); //echo "<pre />"; print_r($glcresult); exit;
			// Start and end dates based on the data
			$gstartDate = new \DateTime('2024-10-01');	
			$gendDate = new \DateTime(end($glcresult)['sdate']); 
			// Initialize the result array
			$glcfresult = [];
			$glcLookup = array_column($glcresult, null, 'sdate');	

			// Loop through each date in the range
			for ($date = clone $gstartDate; $date <= $gendDate; $date->modify('+1 day')) {
				$gformattedDate = $date->format('Y-m-d');

				// Check if the date is in the original data
				if (isset($glcLookup[$gformattedDate])) {
					$glcfresult[] = $glcLookup[$gformattedDate];
				} else {
					// Add missing date with amount = 0
					$glcfresult[] = ["sdate" => $gformattedDate, "tsales" => 0];
				}
			}
			//echo "<pre />"; print_r($glcfresult); exit;
			$i=222;
			foreach($glcfresult AS $row)
			{
				$ckey='F'.$i; 
				$cvalue=$row['tsales'];
				if($cvalue!=0)
				{	
					$sheet->setCellValue($ckey, $cvalue);
					//style the cell
					$sheet->getStyle($ckey)->applyFromArray([
						'fill' => [
							'fillType' => Fill::FILL_SOLID,
							'startColor' => [
								'argb' => '90EE90', // Green
							],
						],
					]);
				}
				$i++;
			}	
			//Glc part end
			
			//Glc Cash part Start
			$getGlcCash = $this->ExcelplanModel->getGlcCash('expenses', $sdate, $edate); //echo "<pre />"; print_r($getGlcCash); exit;
			// Start and end dates based on the data
			$cstartDate = new \DateTime('2024-10-01');	
			$cendDate = new \DateTime(end($getGlcCash)['pdate']); 
			// Initialize the result array
			$cResult = [];
			$cdateLookup = array_column($getGlcCash, null, 'pdate');	
			// Loop through each date in the range
			for ($date = clone $cstartDate; $date <= $cendDate; $date->modify('+1 day')) {
				$cformattedDate = $date->format('Y-m-d');

				// Check if the date is in the original data
				if (isset($cdateLookup[$cformattedDate])) {
					$cResult[] = $cdateLookup[$cformattedDate];
				} else {
					// Add missing date with amount = 0
					$cResult[] = ["pdate" => $cformattedDate, "amount" => 0];
				}
			}
			//echo "<pre />"; print_r($cResult); exit;
			$j=533;
			foreach($cResult AS $row)
			{
				$ckey='I'.$j; 
				$cvalue=$row['amount'];
				if($cvalue!=0)
				{	
					$sheet->setCellValue($ckey, $cvalue);
					//style the cell
					$sheet->getStyle($ckey)->applyFromArray([
						'fill' => [
							'fillType' => Fill::FILL_SOLID,
							'startColor' => [
								'argb' => '90EE90', // Green
							],
						],
					]);
				}
				$j++;
			}	
			//echo "<pre />"; print_r($cResult); exit;
			//Glc cash part end
			
			//Glc Credit part Start
			$glcCredit = $this->ExcelplanModel->glcCredit('expenses', $sdate, $edate); //echo "<pre />"; print_r($glcCredit); exit;
			// Start and end dates based on the data
			$crstartDate = new \DateTime('2024-10-01');	
			$crendDate = new \DateTime(end($glcCredit)['pdate']); 
			// Initialize the result array
			$crResult = [];
			$crdateLookup = array_column($glcCredit, null, 'pdate');	
			// Loop through each date in the range
			for ($date = clone $crstartDate; $date <= $crendDate; $date->modify('+1 day')) {
				$crformattedDate = $date->format('Y-m-d');

				// Check if the date is in the original data
				if (isset($crdateLookup[$crformattedDate])) {
					$crResult[] = $crdateLookup[$crformattedDate];
				} else {
					// Add missing date with amount = 0
					$crResult[] = ["pdate" => $crformattedDate, "tamount" => 0];
				}
			}
			//echo "<pre />"; print_r($crResult); exit;
			$k=533;
			foreach($crResult AS $row)
			{
				$ckey='M'.$k; 
				$lf='L'.$k; 
				$cvalue=$row['tamount'];
				if(isset($row['crno']))
				{	
					$lfvalue=$row['crno'];
					$lfvalue=getdbc($lfvalue);
					$sheet->setCellValue($lf, $lfvalue);
				}
				if($cvalue!=0)
				{	
					$sheet->setCellValue($ckey, $cvalue);
					//style the cell
					$sheet->getStyle($ckey)->applyFromArray([
						'fill' => [
							'fillType' => Fill::FILL_SOLID,
							'startColor' => [
								'argb' => '90EE90', // Green
							],
						],
					]);
				}
				$k++;
			}	
			//Glc Credit part Ends
			
			// Save the modified file as a new Excel file
			$writer = new Xlsx($spreadsheet);
			//$writer->save('modified_template.xlsx');
			ob_clean();
		    //ob_start();
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Disposition: attachment;filename=\"Tamay-Expenses-Plan.xlsx\"");
			header("Cache-Control: max-age=0");
			header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
			header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
			header("Cache-Control: cache, must-revalidate");
			header("Pragma: public");
			$writer->save("php://output");
			//ob_end_flush();
			
    }
	
	
}
