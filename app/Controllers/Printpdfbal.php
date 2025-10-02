<?php

namespace App\Controllers;
use App\Models\DailyModel;

use TCPDF;  

class Printpdfbal extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	//Print main list
	public function index(): string
    {   
        
		$result = $this->DailyModel->balanceMainList();
		$total = $this->DailyModel->dbcTotal();
			
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Alizada');
		$pdf->SetTitle('Statements');
		$pdf->SetSubject('Daily Report');
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
		/*$pdf->Cell(265, 0, 'As on: '.date('d/m/Y'), 0, 1, 'R', 0, 0, '', '');
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(55, 7, $onerecord->dcnames, 0, 'L', 0, 0, '', '', true);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(55, 7, $onerecord->addr, 0, 'L', 0, 0, '', '', true);
		$pdf->Cell(55, 7, $onerecord->phone, 0, 'L', 0, 0, '', '', true);*/
		
		
		$pdf->SetFont('helvetica', '', 8);
		
		// -----------------------------------------------------------------------------
	 if(1)
	 {		
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.1" cellpadding="5" border="0.1" style="width:100%">
				<tr>
					<td colspan="6" align="center" style="font-weight:bold;background-color: #d3d3d3;">D/C STATEMENT</td>
				</tr>
				<tr>
					<td style="font-weight:bold;background-color: #d3d3d3;width:5%;">Row</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:30%;">D/C</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:20%;">Type</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:15%;">Debit</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:15%;">Credit</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:15%;">Balance</td>
				</tr>';
			$i=1;	
			foreach($result AS $res)
			{	
						
			$tbl .='<tr>
					<td align="center">'.$i.'</td>
					<td>'.getdbc($res->dbc).'</td>
					<td>'.dbcType($res->type).'</td>
					<td>'.'RM '.number_format(round($res->damount, 2), 2).'</td>
					<td>'.'RM '.number_format(round($res->camount, 2), 2).'</td>
					<td>'.'RM '.number_format(round($res->damount - $res->camount, 2), 2).'</td>
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="3" align="center" style="font-weight:bold;">Total</td>
					<td colspan="1" style="font-weight:bold;">'.'RM '.number_format(round($total->damount, 2), 2).'</td>
					<td colspan="1" style="font-weight:bold;">'.'RM '.number_format(round($total->camount, 2), 2).'</td>
					<td colspan="1" style="font-weight:bold;">'.'RM '.number_format(round($total->damount - $total->camount, 2), 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}		

		// -----------------------------------------------------------------------------
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('D/C STATEMENTS-'.date('d-m-Y').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	
	//Print by type
	public function printbytype($type): string
    {   
       
		if($type!=0)
		{	
			$result = $this->DailyModel->searchbytype($type);
			$total = $this->DailyModel->dbctypeTotal($type);
		}
		else
		{
			$result = $this->DailyModel->balanceMainList();
			$total = $this->DailyModel->dbcTotal();
		}	
		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Alizada');
		$pdf->SetTitle('Daily Report');
		$pdf->SetSubject('Daily Report');
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
		/*$pdf->Cell(265, 0, 'As on: '.date('d/m/Y'), 0, 1, 'R', 0, 0, '', '');
		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->Cell(55, 7, $onerecord->dcnames, 0, 'L', 0, 0, '', '', true);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(55, 7, $onerecord->addr, 0, 'L', 0, 0, '', '', true);
		$pdf->Cell(55, 7, $onerecord->phone, 0, 'L', 0, 0, '', '', true);*/
		
		
		$pdf->SetFont('helvetica', '', 12);
		
		// -----------------------------------------------------------------------------
	 if(1)
	 {		
		$tbl = '';
		$tbl .= '
			<table cellspacing="1" cellpadding="5" border="1" style="width:100%">
				<tr>
					<td colspan="6" align="center" style="font-weight:bold;background-color: #d3d3d3;">D/C STATEMENT</td>
				</tr>
				<tr>
					<td style="font-weight:bold;background-color: #d3d3d3;">S.No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">D/C</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">Type</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">Debit</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">Credit</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">Balance</td>
				</tr>';
			$i=1;	
			foreach($result AS $res)
			{	
						
			$tbl .='<tr>
					<td align="center">'.$i.'</td>
					<td>'.getdbc($res->dbc).'</td>
					<td>'.dbcType($res->type).'</td>
					<td>'.'RM '.number_format(round($res->damount, 2), 2).'</td>
					<td>'.'RM '.number_format(round($res->camount, 2), 2).'</td>
					<td>'.'RM '.number_format(round($res->damount - $res->camount, 2), 2).'</td>
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="3" align="center" style="font-weight:bold;">Total</td>
					<td colspan="1" style="font-weight:bold;">'.'RM '.number_format(round($total->damount, 2), 2).'</td>
					<td colspan="1" style="font-weight:bold;">'.'RM '.number_format(round($total->camount, 2), 2).'</td>
					<td colspan="1" style="font-weight:bold;">'.'RM '.number_format(round($total->damount - $total->camount, 2), 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}		

		// -----------------------------------------------------------------------------
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('D/C STATEMENTS-'.date('d-m-Y').'.pdf', 'I');
		
		
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