<?php
namespace App\Controllers\salary;
use App\Controllers\BaseController;
use App\Models\DailyModel;
use App\Models\attendance\AttendanceModel;
use App\Models\salary\SalaryModel;
use TCPDF;  
// Use FPDI with TCPDF
use setasign\Fpdi\Tcpdf\Fpdi;
 
class Printpdf extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->AttendanceModel = new AttendanceModel();
		$this->SalaryModel = new SalaryModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function generatePayslipt($rid)
    {   
         
		//Get record details
		$rdetails = $this->SalaryModel->rdetails($rid);
		ob_end_clean();
		ob_start();
		// Create PDF instance
		$pdf = new Fpdi();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		if($rdetails->location == 8)
		{	
			// Import the existing PDF
			$templateFile = FCPATH.'template/payslipt.pdf'; // Your PDF file
		}
		else
		{		
			// Import the existing PDF
			$templateFile = FCPATH.'template/paysliptEden.pdf'; // Your PDF file
		}
		$pageCount = $pdf->setSourceFile($templateFile);
		$tplIdx = $pdf->importPage(1); // Import the first page
		$pdf->useTemplate($tplIdx, 0, 0, 210, 297); // Set as background

		// Set font and add text
		$pdf->SetFont('Times', '', 10);
		//Employee Name
		$pdf->SetXY(41, 71); // Position (X, Y)
		$pdf->Cell(100, 10, getEmp($rdetails->empId), 0, 1, 'L');
		//Employee Name
		$pdf->SetXY(41, 77); // Position (X, Y)
		$depId = getDep2($rdetails->empId);
		$pdf->Cell(100, 10, getDep($depId), 0, 1, 'L');
		
		//IC
		$pdf->SetXY(150, 71); // Position (X, Y)
		$pdf->Cell(100, 10, getIc($rdetails->empId), 0, 1, 'L');
		
		//For the month of
		$pdf->SetXY(150, 75); // Position (X, Y)
		$pdf->Cell(100, 10, date_format(date_create($rdetails->sdate), 'M Y'), 0, 1, 'L');
		
		//Current Date
		$pdf->SetXY(150, 81); // Position (X, Y)
		$pdf->Cell(100, 10, date('d-m-Y'), 0, 1, 'L');
		
		//Basic Salary
		$pdf->SetXY(65, 92); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->bsalary, 0, 1, 'L');
		//Over time
		$pdf->SetXY(65, 97); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->otRm, 0, 1, 'L');
		//Paid off day
		$pdf->SetXY(65, 102); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->wodRm, 0, 1, 'L');
		//commission
		$pdf->SetXY(65, 107); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM 0.00', 0, 1, 'L');
		//Claims
		$pdf->SetXY(65, 117); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->claims, 0, 1, 'L');
		//Public Holiday
		$pdf->SetXY(65, 127); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->phRm, 0, 1, 'L');
		//Gross Salary
		$pdf->SetXY(65, 137); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->gSalary, 0, 1, 'L');
		
		//Advance
		$pdf->SetXY(160, 92); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->advance, 0, 1, 'L');
		//EPF
		$pdf->SetXY(160, 97); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->epf, 0, 1, 'L');
		//Absent
		$pdf->SetXY(160, 107); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->abdRm, 0, 1, 'L');
		//deduction
		$pdf->SetXY(160, 127); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->deduction, 0, 1, 'L');
		//Net Salary
		$pdf->SetXY(160, 137); // Position (X, Y)
		$pdf->Cell(100, 10, 'RM '.$rdetails->netSalary, 0, 1, 'L');
		
		// Output the final PDF
		$pdf->Output(getEmp($rdetails->empId).'-'.date_format(date_create($rdetails->sdate), 'F Y').'.pdf', 'D'); // Display in browser
		EXIT;
		
    }

}


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	
	
	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'tamay.jpg'; 
		//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 10);
		// set cell padding
		//$this->setCellPaddings(1, 1, 1, 1);

		// set cell margins
		//$this->setCellMargins(1, 1, 1, 1);

		// set color for background
		//$this->SetFillColor(255, 255, 127);
		// Title
		// Multicell test
		//$this->MultiCell(55, 5, 'dfadfafda dfadfafda dfadfadf dfadfadf dfadf', 0, 'L', 0, 1, '', '', true);
		if ($this->page == 1) 
		{
			$image_file = K_PATH_IMAGES.'tamay.jpg';
			$this->Image($image_file, 15, 15, 15, '', 'JPG', '', 'C', false, 300, 'C', false, false, 0, false, false, false);
			$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+5, PDF_MARGIN_RIGHT);
			$this->Cell(55, 7, 'TAMAY', 0, 'L', 1, 0, '', '', true);
			$this->SetFont('helvetica', '', 10);
			$this->Cell(55, 7, 'Unit 12-02, Fahrenheit 88, No 179,', 0, 'L', 1, 0, '', '', true);
			$this->Cell(55, 7, 'Jalan Bukit Bintang, Kuala Lumpur', 0, 'L', 1, 0, '', '', true);
			$this->SetFont('helvetica', '', 10);
			$this->Cell(55, 7, '+60 32142 1197', 0, 'L', 1, 0, '', '', true);
			$this->SetFont('helvetica', 'B', 10);
			$this->setCellMargins(1, 1, 1, 1);
			//$this->Cell(55, 7, 'STATEMENT OF ACCOUNT (OUTSTANDING)',0, false, 'L', 0, '', 0, false, '', '');
			//$this->SetFont('helvetica', '', 12);
			
		}
	    //$this->Cell(55, 7, 'uuuuuuuuu', 0, 'L', 0, 0, '', '', true);
	    //$this->Cell(55, 7, 'uuuuuuuuu', 0, 'L', 0, 0, '', '', true);
	    //$this->Cell(270, 7, 'yyyyyyyyyyyyy', 0, 1, 'R', 0, '', '', '');
		
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
	
	
}