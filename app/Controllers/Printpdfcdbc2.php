<?php

namespace App\Controllers;
use App\Models\DailyModel;

use TCPDF;  

class Printpdfcdbc2 extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	//Print dbc
	public function index($dbc): string
    {   
      
		$result= $this->DailyModel->balanceList2($dbc); 
		$total = $this->DailyModel->dbcSum2($dbc);
		foreach ($total as $item) {
				if (!empty($item['tamount'])) {
					$mergedArray['tamount'] = $item['tamount'];  // Merge tamount
				}
				if (!empty($item['damount'])) {
					$mergedArray['damount'] = $item['damount'];  // Merge damount
				}
			}
		$total = $mergedArray;	
		//echo "<pre />"; print_r($result); exit;
		$onerecord= $this->DailyModel->dbconerecord($dbc);
		$phone='';
		if($onerecord->phone!=0)
		{
			$phone=$onerecord->phone;
		}
		//Get post dated cheques
		$pdc = $this->DailyModel->postDateCheque($dbc);
		//Get post dated cheques Total
		$pdctotal = $this->DailyModel->postDateChequeTotal($dbc);
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
		$pdf->Cell(170, 0, 'As on: '.date('d/m/Y'), 0, 1, 'R', 0, 0, '', '');
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->Cell(55, 5, $onerecord->dcnames, 0, 'L', 0, 0, '', '', true);
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(55, 5, $onerecord->addr, 0, 'L', 0, 0, '', '', true);
		$pdf->Cell(55, 5, $phone, 0, 'L', 0, 0, '', '', true);
		
		
		$pdf->SetFont('helvetica', '', 8);
		
		// -----------------------------------------------------------------------------
	 if(1)
	 {		
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.5" cellpadding="4" border="0.1" style="width:100%">
				<tr>
					<td style="font-weight:bold;background-color: #d3d3d3;width:8%;" align="center">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Inv.date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Pay date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:8%;">C.No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:34%;">D/C</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Debit</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Credit</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Balance</td>
				</tr>';
			$i=1;
			$bal='';	
			foreach($result AS $res)
			{	
				$dbc='';
				if($res->amount)
				{
					$bal=floatval($bal)+floatval($res->amount);
				}
				if($res->damount)
				{
					$bal=floatval($bal)-floatval($res->damount);
				}
				if($res->pto)
				{
						$dbc=getdbc($res->pto);
				}
				else if($res->crno)
				{
					$dbc=getdbc($res->crno);
				}
				$ttamount = 0;
				$ddamount = 0;
				if(isset($total['tamount']))
				{
					$ttamount = $total['tamount'];
				}
				if(isset($total['damount']))
				{
					$ddamount = $total['damount'];
				}	
				$invoiceDate='';	
				if($res->invDate !='0000-00-00')
				{
					$invoiceDate = $res->invDate;
				}		
			$tbl .='<tr>
					<td align="center" style="width:8%;">'.$i.'</td>
					<td style="width:10%;">'.$invoiceDate.'</td>
					<td style="width:10%;">'.$res->pdate.'</td>
					<td style="width:8%;">'.$res->cno.'</td>
					<td style="34%">'.$dbc.'</td>
					<td style="width:10%;">'.number_format($res->amount, 2).'</td>
					<td style="width:10%;">'.number_format($res->damount, 2).'</td>
					<td style="width:10%;">'.$bal.'</td>
					
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td style="font-weight:bold" colspan="5" align="center">Total</td>
					<td style="font-weight:bold" colspan="1">'.number_format(round($ttamount, 2), 2).'</td>
					<td style="font-weight:bold" colspan="1">'.number_format($ddamount, 2).'</td>
					<td style="font-weight:bold" colspan="1">'.number_format(round($ttamount, 2)-round($ddamount, 2),2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}		

		// -----------------------------------------------------------------------------
		if($pdc)
		{	
			$tb2 = '
				<table cellspacing="0.5" cellpadding="4" border="0.1" style="width:100%">
					<tr>
						<td colspan="7" style="font-weight:bold;background-color: #F0E68C;width:100%;" align="center">POST DATED CHEQUES ISSUED</td>
					</tr>	
					<tr>
						<td style="font-weight:bold;background-color: #d3d3d3;width:8%;" align="center">ROW</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due.date</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:8%;">C.No</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Inv No</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:34%;">D/C</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Amount</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:20%;">Remark</td>
					</tr>';
				$j=1;	
				foreach($pdc AS $row)
				{	
					
				$tb2 .='<tr>
						<td align="center" style="width:8%;">'.$j.'</td>
						<td style="width:10%;">'.$row->ddate.'</td>
						<td style="width:8%;">'.$row->cno.'</td>
						<td style="width:10%;">'.$row->invNo.'</td>
						<td style="34%">'.$dbc.'</td>
						<td style="width:10%;">'.number_format($row->amount, 2).'</td>
						<td style="width:20%;">'.$row->remark.'</td>
						
					</tr>
					';
					$j++;
				}	
				$tb2 .='
					<tr>
						<td style="font-weight:bold" colspan="6" align="center">Total</td>
						<td style="font-weight:bold" colspan="1">'.number_format(round($pdctotal->tamount, 2), 2).'</td>
					</tr>';
				$tb2 .='</table>';
				$pdf->writeHTML($tb2, true, false, false, false, '');
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
	    $this->Cell(55, 7, 'Tamay', 0, 'L', 1, 0, '', '', true);
		$this->SetFont('helvetica', '', 10);
	    $this->Cell(55, 7, 'Unit 12-02, Fahrenheit 88, No 179,', 0, 'L', 1, 0, '', '', true);
	    $this->Cell(55, 7, 'Jalan Bukit Bintang, Kuala Lumpur', 0, 'L', 1, 0, '', '', true);
		$this->SetFont('helvetica', '', 10);
	    $this->Cell(55, 7, '+60 32142 1197', 0, 'L', 1, 0, '', '', true);
		$this->SetFont('helvetica', 'B', 10);
		$this->setCellMargins(1, 1, 1, 1);
		//$this->Cell(55, 7, 'STATEMENT OF ACCOUNT (OUTSTANDING)',0, false, 'L', 0, '', 0, false, '', '');
	    //$this->SetFont('helvetica', '', 12);
	    $this->Cell(180, 3, 'STATEMENT OF ACCOUNT (OUTSTANDING)', 0, 1, 'C', 0, '', '', '');
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