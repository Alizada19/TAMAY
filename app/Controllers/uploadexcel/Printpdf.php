<?php

namespace App\Controllers\uploadexcel;
use App\Controllers\BaseController;
use App\Models\upload\ExcelModel;

use TCPDF;  

class Printpdf extends BaseController
{
    //my constructor
	public function __construct() {

        $this->ExcelModel = new ExcelModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	//Print 
	public function index()
    {   
		
		$sdate = $this->request->getPost('sdate');
		$edate = $this->request->getPost('edate');
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
						
		$records = $this->ExcelModel->search($data); 
		$grouped = [];

		foreach ($records as $row) {
			$date = $row->cdate;
			$category = $row->category;
			$cost = $row->cost;

			 // Initialize date group
			if (!isset($grouped[$date])) {
				$grouped[$date] = [
					'categories' => [], // holds category-wise cost
					'total' => 0        // holds daily total
				];
			}

			// Initialize category if not set
			if (!isset($grouped[$date]['categories'][$category])) {
				$grouped[$date]['categories'][$category] = 0;
			}

			// Accumulate cost by category
			$grouped[$date]['categories'][$category] += $cost;

			// Accumulate total cost for the day
			$grouped[$date]['total'] += $cost;
		}
		$total = $this->ExcelModel->totalSearch($data);
		ob_end_clean();
		ob_start();
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Alizada');
		$pdf->SetTitle('Transfered Stocks');
		$pdf->SetSubject('Grouped by category and date');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		//$pdf->setPrintHeader(false);
		//$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
	
		// add a page
		$pdf->AddPage('P', 'A4');
		$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		//Header subparts
		$pdf->Cell(177, 0, 'Date: '.date('d/m/Y'), 0, 1, 'R', 0, 0, '', '');
		$pdf->SetFont('helvetica', 'B', 10);
		//$pdf->Cell(55, 5, 'fff', 0, 'L', 0, 0, '', '', true);
		$pdf->SetFont('helvetica', '', 10);
		//$pdf->Cell(55, 5, 'dfa', 0, 'L', 0, 0, '', '', true);
		//$pdf->Cell(55, 5, 'dfafa', 0, 'L', 0, 0, '', '', true);
		$pdf->Cell(180, 3, 'LIST OF STOCKS GROUPED BY CATEGORY AND DATE', 0, 1, 'C', 0, '', '', '');
		$pdf->Ln(3);
		
		$pdf->SetFont('helvetica', '', 8);
		
		// -----------------------------------------------------------------------------
		 if(1)
		 {		
			$tbl = '';
			$tbl .= '
				<table cellspacing="0.5" cellpadding="4" border="0.1" style="width:100%">
					<tr>
						<td style="font-weight:bold;background-color: #d3d3d3;width:15%;" align="center">Date</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:50%;">Category</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:20%;">Cost</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:20%;">Day cost</td>
					</tr>';
			$i=1;		
			foreach ($grouped as $date => $data):
				$first = true;
				$rowCount = count($data['categories']);
					foreach ($data['categories'] as $category => $cost):
					$tbl.='
					<tr>';
							if ($first):
								$tbl.='
								<td rowspan="'.$rowCount.'" style="width:15%;" align="center">'.esc(date_format(date_create($date), 'd-m-Y')).'</td>';
								$first = false;
							endif;
							$tbl.='
								<td style="width:50%;" align="center">'.esc($category).'</td>';
							$tbl.='
								<td style="width:20%;" align="center">RM '.esc(number_format($cost, 2)).'</td>';	
								if ($category === array_key_last($data['categories'])):
								$tbl.='
								<td style="width:20%;font-weight:bold;" align="center">RM '.number_format($data['total'], 2).'</td>';
								endif;
					$tbl.='
					</tr>';			
					endforeach;
			endforeach;		
				
				$i++;
				
				$tbl.='
					<tr style="font-weight:bold;">
						<td colspan="3" style="" align="center">Total cost</td>
						<td style="text-align:center;">RM '.number_format($total->cost, 2).'</td>
					</tr>
				';	
				$tbl .='</table>';
				$pdf->writeHTML($tbl, true, false, false, false, '');
					
		 }
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('DC Statment-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	

	//By Category
	public function printCategory()
    {   
		
		$sdate = $this->request->getPost('sdate');  
		$edate = $this->request->getPost('edate');
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
						
		$records = $this->ExcelModel->searchCategory($data); 
		$total = $this->ExcelModel->totalSearch($data);
		ob_end_clean();
		ob_start();
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Alizada');
		$pdf->SetTitle('Transfered Stocks');
		$pdf->SetSubject('Grouped by category and date');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		//$pdf->setPrintHeader(false);
		//$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
	
		// add a page
		$pdf->AddPage('P', 'A4');
		$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
		//Header subparts
		$pdf->Cell(177, 0, 'Date: '.date('d/m/Y'), 0, 1, 'R', 0, 0, '', '');
		$pdf->SetFont('helvetica', 'B', 10);
		//$pdf->Cell(55, 5, 'fff', 0, 'L', 0, 0, '', '', true);
		$pdf->SetFont('helvetica', '', 10);
		//$pdf->Cell(55, 5, 'dfa', 0, 'L', 0, 0, '', '', true);
		//$pdf->Cell(55, 5, 'dfafa', 0, 'L', 0, 0, '', '', true);
		$pdf->Cell(180, 3, 'LIST OF STOCKS GROUPED BY CATEGORY', 0, 1, 'C', 0, '', '', '');
		$pdf->Ln(3);
		$pdf->SetFont('helvetica', '', 8);
		
		// -----------------------------------------------------------------------------
		 if(1)
		 {		
			$tbl = '';
			$tbl .= '
				<table cellspacing="0.5" cellpadding="4" border="0.1" style="width:100%">
					<tr>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">No</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:50%;">Category</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:40%;">Cost</td>
					</tr>';
			$i=1;		
				foreach($records AS $row)
				{
					$tbl .='<tr>
								<td>'.$i.'</td>
								<td>'.$row->category.'</td>
								<td>RM '.number_format($row->cost, 2).'</td>
							  </tr>';
					
					$i++;
				}		
				
				$tbl.='
					<tr style="font-weight:bold;">
						<td colspan="2" style="" align="center">Total cost</td>
						<td style="text-align:center;">RM '.number_format($total->cost, 2).'</td>
					</tr>
				';	
				$tbl .='</table>';
				$pdf->writeHTML($tbl, true, false, false, false, '');
					
		 }
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('DC Statment-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
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
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+5, PDF_MARGIN_RIGHT);
	    $this->Cell(55, 7, 'EDEN FRAGRANCE SDN.BHD', 0, 'L', 1, 0, '', '', true);
		$this->SetFont('helvetica', '', 10);
	    $this->Cell(55, 7, 'Unit 12-02, Fahrenheit 88, No 179,', 0, 'L', 1, 0, '', '', true);
	    $this->Cell(55, 7, 'Jalan Bukit Bintang, Kuala Lumpur', 0, 'L', 1, 0, '', '', true);
		$this->SetFont('helvetica', '', 10);
	    $this->Cell(55, 7, '+60 32142 1197', 0, 'L', 1, 0, '', '', true);
		$this->SetFont('helvetica', 'B', 10);
		$this->setCellMargins(1, 1, 1, 1);
		//$this->Cell(55, 7, 'STATEMENT OF ACCOUNT (OUTSTANDING)',0, false, 'L', 0, '', 0, false, '', '');
	    //$this->SetFont('helvetica', '', 12);
	    //$this->Cell(180, 3, 'LIST OF STOCKS GROUPED BY CATEGORY AND DATE', 0, 1, 'C', 0, '', '', '');
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