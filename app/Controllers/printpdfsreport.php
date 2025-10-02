<?php

namespace App\Controllers;
use App\Models\DailyModel;

use TCPDF;

 
class Printpdfsreport extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index($sdate, $edate, $slocation): string
    {   
        
		$request = \Config\Services::request();		
		
		$data=array(
			'sdate' => $sdate,
			'edate' => $edate,
			'shop' => $slocation
		);
		 
		$tamay = $this->DailyModel->tamay($data);	
		$tamayTotal = $this->DailyModel->tamayTotal($data);			
		$bergayaTotal = $this->DailyModel->bergayaTotal($data);			
		$glsChocolate = $this->DailyModel->tamayChocolate($data);	
		$js = $this->DailyModel->js($data);		
		$bergaya = $this->DailyModel->bergaya($data);			
		$eden = $this->DailyModel->eden($data);			
		$edensi = $this->DailyModel->edensi($data);			
		$edensw = $this->DailyModel->edensw($data);			
		$edenjo = $this->DailyModel->edenjo($data);			
		$edenjo2 = $this->DailyModel->edenjo2($data);			
		$edena = $this->DailyModel->edena($data);			
		$allshops = $this->DailyModel->allshops($data);

		$sdate = $sdate;
		$edate = $edate;
		$loc = $slocation;
			
		//echo "<pre />"; print_r($data); exit; 
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Alizada');
		$pdf->SetTitle('Daily Report');
		$pdf->SetSubject('Daily Report');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setFooterData(array(0,64,0), array(0,64,128));

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', 'sans-serif', 8);

		// -----------------------------------------------------------------------------
	 if($slocation == 20)
	 {
		 if(1)
		 {		
			 $text = '<div style="text-align:center;font-size:25;">SHOP SALES REPORT</div>
				<div style="text-align: center;">
					DATE: '.date_format(date_create($sdate), 'd/m/Y').'-'.date_format(date_create($edate), 'd/m/Y').'
				</div>
			';
			$pdf->writeHTML($text, true, false, true, false, '');
			$tbl = '';
			$tbl .= '
				<table cellspacing="1" cellpadding="1" border="1">
					<tr>
						<td colspan="7" align="center" style="background-color: #d3d3d3; font-weight:bold;">EDEN FRAGRANCE</td>
					</tr>
					<tr>
						<td align="center" style="background-color: #d3d3d3;font-weight:bold;">SHOP</td>
						<td style="background-color: #d3d3d3;font-weight:bold;">SHOP NAME</td>
						<td style="background-color: #d3d3d3;font-weight:bold;">SALES </td>
						<td style="background-color: #d3d3d3;font-weight:bold;">CARD</td>
						<td style="background-color: #d3d3d3;font-weight:bold;">CASH</td>
						<td style="background-color: #d3d3d3;font-weight:bold;">EXPENSES</td>
						<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
					</tr>';
				if(isset($edensi->totalSales))
				{		
					$tbl.='<tr>
							<td align="center">1</td>
							<td>ESI</td>
							<td>RM '.number_format($edensi->totalSales, 2).'</td>
							<td>RM '.number_format($edensi->totalCard, 2).'</td>
							<td>RM '.number_format($edensi->totalCash, 2).'</td>
							<td>RM '.number_format($edensi->totaleamount, 2).'</td>
							<td>RM '.number_format($edensi->totalNcash, 2).'</td>
						</tr>';
				}
				if(isset($edensw->totalSales))
				{	
					$tbl.='<tr>
							<td align="center">1</td>
							<td>ESW</td>
							<td>RM '.number_format($edensw->totalSales, 2).'</td>
							<td>RM '.number_format($edensw->totalCard, 2).'</td>
							<td>RM '.number_format($edensw->totalCash, 2).'</td>
							<td>RM '.number_format($edensw->totaleamount, 2).'</td>
							<td>RM '.number_format($edensw->totalNcash, 2).'</td>
						</tr>
						';
				}	
				if(isset($edena->totalSales))
				{	
					$tbl.='<tr>
						<td align="center">5</td>
						<td>E66A</td>
						<td>RM '.number_format($edena->totalSales, 2).'</td>
						<td>RM '.number_format($edena->totalCard, 2).'</td>
						<td>RM '.number_format($edena->totalCash, 2).'</td>
						<td>RM '.number_format($edena->totaleamount, 2).'</td>
						<td>RM '.number_format($edena->totalNcash, 2).'</td>
					</tr>';
				}	
					$tbl.='<tr>
						<td align="center">1</td>
						<td>JOHONI-JB</td>
						<td>RM '.number_format($js->totalSales, 2).'</td>
						<td>RM '.number_format($js->totalCard, 2).'</td>
						<td>RM '.number_format($js->totalCash, 2).'</td>
						<td>RM '.number_format($js->totaleamount, 2).'</td>
						<td>RM '.number_format($js->totalNcash, 2).'</td>
					</tr>
					<tr>
						<td align="center">2</td>
						<td>CHOCOLATE JB</td>
						<td>RM '.number_format($glsChocolate->totalSales, 2).'</td>
						<td>RM '.number_format($glsChocolate->totalCard, 2).'</td>
						<td>RM '.number_format($glsChocolate->totalCash, 2).'</td>
						<td>RM '.number_format($glsChocolate->totaleamount, 2).'</td>
						<td>RM '.number_format($glsChocolate->totalNcash, 2).'</td>
					</tr>
					<tr>
						<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
						<td style="font-weight:bold;">RM '.number_format($eden->totalSales, 2).'</td>
						<td style="font-weight:bold;">RM '.number_format($eden->totalCard, 2).'</td>
						<td style="font-weight:bold;">RM '.number_format($eden->totalCash, 2).'</td>
						<td style="font-weight:bold;">RM '.number_format($eden->totaleamount, 2).'</td>
						<td style="font-weight:bold;">RM '.number_format($eden->totalNcash, 2).'</td>
					</tr>';
				$tbl.='</table>		
			';
				$pdf->writeHTML($tbl, true, false, false, false, '');
			}

		// -----------------------------------------------------------------------------
			 if(1)
			 {		
				 
				$tbl = '';
				$tbl .= '
					<table cellspacing="1" cellpadding="1" border="1">
						<tr>
							<td colspan="7" align="center" style="background-color: #d3d3d3;font-weight:bold;">BERGAYA</td>
						</tr>
						<tr>
							<td align="center">1</td>
							<td>JOHONI-Q</td>
							<td>RM '.number_format($edenjo->totalSales, 2).'</td>
							<td>RM '.number_format($edenjo->totalCard, 2).'</td>
							<td>RM '.number_format($edenjo->totalCash, 2).'</td>
							<td>RM '.number_format($edenjo->totaleamount, 2).'</td>
							<td>RM '.number_format($edenjo->totalNcash, 2).'</td>
						</tr>
						<tr>
							<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
							<td style="font-weight:bold;">RM '.number_format($bergayaTotal->totalSales, 2).'</td>
							<td style="font-weight:bold;">RM '.number_format($bergayaTotal->totalCard, 2).'</td>
							<td style="font-weight:bold;">RM '.number_format($bergayaTotal->totalCash, 2).'</td>
							<td style="font-weight:bold;">RM '.number_format($bergayaTotal->totaleamount, 2).'</td>
							<td style="font-weight:bold;">RM '.number_format($bergayaTotal->totalNcash, 2).'</td>
						</tr>
					</table>	
				';
					$pdf->writeHTML($tbl, true, false, false, false, '');
				}
			if(2==1)
			 {		
				 
				$tbl = '';
				$tbl .= '
					<table cellspacing="1" cellpadding="1" border="1">
						<tr>
							<td colspan="7" align="center" style="background-color: #d3d3d3;font-weight:bold;">TAMAY BUSINESS GROUP</td>
						</tr>
						<tr>
							<td align="center" style="background-color: #d3d3d3;font-weight:bold;">SHOP</td>
							<td style="background-color: #d3d3d3;font-weight:bold;">SHOP NAME</td>
							<td style="background-color: #d3d3d3;font-weight:bold;">SALES </td>
							<td style="background-color: #d3d3d3;font-weight:bold;">CARD</td>
							<td style="background-color: #d3d3d3;font-weight:bold;">CASH</td>
							<td style="background-color: #d3d3d3;font-weight:bold;">EXPENSES</td>
							<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
						</tr>';
				if(isset($edena->totalSales))
				{	
					$tbl.='<tr>
							<td align="center">1</td>
							<td>GILASCO</td>
							<td>RM '.number_format($tamay->totalSales, 2).'</td>
							<td>RM '.number_format($tamay->totalCard, 2).'</td>
							<td>RM '.number_format($tamay->totalCash, 2).'</td>
							<td>RM '.number_format($tamay->totaleamount, 2).'</td>
							<td>RM '.number_format($tamay->totalNcash, 2).'</td>
						</tr>';
				}		
					$tbl.= '
						<tr>
							<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
							<td style="font-weight:bold;">RM '.number_format($tamayTotal->totalSales, 2).'</td>
							<td style="font-weight:bold;">RM '.number_format($tamayTotal->totalCard, 2).'</td>
							<td style="font-weight:bold;">RM '.number_format($tamayTotal->totalCash, 2).'</td>
							<td style="font-weight:bold;">RM '.number_format($tamayTotal->totaleamount, 2).'</td>
							<td style="font-weight:bold;">RM '.number_format($tamayTotal->totalNcash, 2).'</td>
						</tr>
					</table>		
				';
					$pdf->writeHTML($tbl, true, false, false, false, '');
				}

			// -----------------------------------------------------------------------------
			/*if(1)
			 {		
				 
				$tbl = '';
				$tbl .= '
					<table cellspacing="1" cellpadding="1" border="1">
						<tr>
							<td colspan="7" align="center">BERGAYA</td>
						</tr>
						<tr>
							<td align="center">ROW</td>
							<td align="center">SHOP NAME</td>
							<td align="center">SALES </td>
							<td align="center">CARD</td>
							<td align="center">CASH</td>
							<td align="center">EXPENSES</td>
							<td align="center">NET CASH</td>
						</tr>
						<tr>
							<td align="center">1</td>
							<td align="center">BUY&SAVE</td>
							<td align="center">RM '.number_format($bergaya->totalSales, 2).'</td>
							<td align="center">RM '.number_format($bergaya->totalCard, 2).'</td>
							<td align="center">RM '.number_format($bergaya->totalCash, 2).'</td>
							<td align="center">RM '.number_format($bergaya->totaleamount, 2).'</td>
							<td align="center">RM '.number_format($bergaya->totalNcash, 2).'</td>
						</tr>
					</table>		
				';
					$pdf->writeHTML($tbl, true, false, false, false, '');
				}
				*/
			// -----------------------------------------------------------------------------
			
			if(1)
			 {		
				 
				$tbl = '';
				$tbl .= '
					<table cellspacing="1" cellpadding="1" border="1">
						<tr>
							<td colspan="5" align="center" style="background-color: #d3d3d3;font-weight:bold;">ALL SHOPS</td>
						</tr>
						<tr>
							<td style="background-color: #d3d3d3;font-weight:bold;">TOTAL SALES</td>
							<td style="background-color: #d3d3d3;font-weight:bold;">TOTAL CARD</td>
							<td style="background-color: #d3d3d3;font-weight:bold;">TOTAL CASH </td>
							<td style="background-color: #d3d3d3;font-weight:bold;">TOTAL EXPENSES</td>
							<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
							
						</tr>
						<tr>
							<td>RM '.number_format($allshops->totalSales, 2).'</td>
							<td>RM '.number_format($allshops->totalCard, 2).'</td>
							<td>RM '.number_format($allshops->totalCash, 2).'</td>
							<td>RM '.number_format($allshops->totaleamount, 2).'</td>
							<td>RM '.number_format($allshops->totalNcash, 2).'</td>
						</tr>
					</table>		
				';
					$pdf->writeHTML($tbl, true, false, false, false, '');
				}

		}
		else if($slocation == 21)
		{
			//By all day by day REPORTS
			//1. ESI
			$resultEsi = $this->DailyModel->dailySales($sdate, $edate, '3');
			//2. ESW
			$resultEsw = $this->DailyModel->dailySales($sdate, $edate, '4');
			//3. Johoni-q
			$resultJohoniq = $this->DailyModel->dailySales($sdate, $edate, '5');
			//4. E66a
			$resultE66a = $this->DailyModel->dailySales($sdate, $edate, '6');
			//5. GLC
			$resultGlc = $this->DailyModel->dailySales($sdate, $edate, '2');
			//All shops
			$allshops = $this->DailyModel->allshops($data);
			//All Eden shops by given date ranges
			$eden = $this->DailyModel->eden($data);
			//sum of esi shop
			$sesi = $this->DailyModel->sumofgivenshops($sdate, $edate, '3'); //echo "<pre />"; print_r($glcsum); exit;
			//sum of esw shop
			$sesw = $this->DailyModel->sumofgivenshops($sdate, $edate, '4'); //echo "<pre />"; print_r($glcsum); exit;
			//sum of johoni-q shop
			$sjohoniq = $this->DailyModel->sumofgivenshops($sdate, $edate, '5'); //echo "<pre />"; print_r($glcsum); exit;
			//sum of se66a shop
			$se66a = $this->DailyModel->sumofgivenshops($sdate, $edate, '6'); //echo "<pre />"; print_r($glcsum); exit;
			//sum of glc shop
			$glcsum = $this->DailyModel->sumofgivenshops($sdate, $edate, '2'); //echo "<pre />"; print_r($glcsum); exit;
			
			 if(1)
			 {		
				 $text = '<div style="text-align:center;font-size:25;"><h3>SHOP REPORTS</h3></div>
					<div style="text-align: center;">
						<h3>From: '.date_format(date_create($sdate), 'd/m/Y').' To '.date_format(date_create($edate), 'd/m/Y').'</h3>
					</div>
				';
				$pdf->writeHTML($text, true, false, true, false, '');
				$tbl = '';
					$tbl .= '
						<table cellspacing="1" cellpadding="1" border="1">
							<tr>
								<td colspan="7" align="center" style="background-color: #d3d3d3; font-weight:bold;">EDEN FRAGRANCE</td>
							</tr>
							<tr>
								<td colspan="7" align="center" style="background-color: #d3d3d3; font-weight:bold;">ESI</td>
							</tr>
							<tr>
								<td align="center" style="background-color: #d3d3d3;font-weight:bold;">ROW</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">Date</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">SALES </td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CARD</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CASH</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">EXPENSES</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
							</tr>';
					$i=1;		
					foreach($resultEsi AS $esi)
					{	
						$tbl .= '<tr>
									<td align="center">'.$i.'</td>
									<td>'.date_format(date_create($esi->sdate), 'd/m/Y').'</td>
									<td>RM '.number_format($esi->totalSales, 2).'</td>
									<td>RM '.number_format($esi->totalCard, 2).'</td>
									<td>RM '.number_format($esi->totalCash, 2).'</td>
									<td>RM '.number_format($esi->totaleamount, 2).'</td>
									<td>RM '.number_format($esi->totalNcash, 2).'</td>
								</tr>';
						$i++;		
					}		
					$tbl .= '<tr>
								<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
								<td style="font-weight:bold;">RM '.number_format($sesi->totalSales, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sesi->totalCard, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sesi->totalCash, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sesi->totaleamount, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sesi->totalNcash, 2).'</td>
							</tr>
						</table>		
					';
					//ESW
					$tbl .= '
						<table cellspacing="1" cellpadding="1" border="1">
							<tr>
								<td colspan="7" align="center" style="background-color: #d3d3d3; font-weight:bold;">ESW</td>
							</tr>
							<tr>
								<td align="center" style="background-color: #d3d3d3;font-weight:bold;">ROW</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">Date</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">SALES </td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CARD</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CASH</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">EXPENSES</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
							</tr>';
					$i=1;		
					foreach($resultEsw AS $esw)
					{	
						$tbl .= '<tr>
									<td align="center">'.$i.'</td>
									<td>'.date_format(date_create($esw->sdate), 'd/m/Y').'</td>
									<td>RM '.number_format($esw->totalSales, 2).'</td>
									<td>RM '.number_format($esw->totalCard, 2).'</td>
									<td>RM '.number_format($esw->totalCash, 2).'</td>
									<td>RM '.number_format($esw->totaleamount, 2).'</td>
									<td>RM '.number_format($esw->totalNcash, 2).'</td>
								</tr>';
						$i++;		
					}		
					$tbl .= '<tr>
								<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
								<td style="font-weight:bold;">RM '.number_format($sesw->totalSales, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sesw->totalCard, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sesw->totalCash, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sesw->totaleamount, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sesw->totalNcash, 2).'</td>
							</tr>
						</table>		
					';
					//Johoni-Q
					$tbl .= '
						<table cellspacing="1" cellpadding="1" border="1">
							<tr>
								<td colspan="7" align="center" style="background-color: #d3d3d3; font-weight:bold;">JOHONI-Q</td>
							</tr>
							<tr>
								<td align="center" style="background-color: #d3d3d3;font-weight:bold;">ROW</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">Date</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">SALES </td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CARD</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CASH</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">EXPENSES</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
							</tr>';
					$i=1;		
					foreach($resultJohoniq AS $jq)
					{	
						$tbl .= '<tr>
									<td align="center">'.$i.'</td>
									<td>'.date_format(date_create($jq->sdate), 'd/m/Y').'</td>
									<td>RM '.number_format($jq->totalSales, 2).'</td>
									<td>RM '.number_format($jq->totalCard, 2).'</td>
									<td>RM '.number_format($jq->totalCash, 2).'</td>
									<td>RM '.number_format($jq->totaleamount, 2).'</td>
									<td>RM '.number_format($jq->totalNcash, 2).'</td>
								</tr>';
						$i++;		
					}		
					$tbl .= '<tr>
								<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
								<td style="font-weight:bold;">RM '.number_format($sjohoniq->totalSales, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sjohoniq->totalCard, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sjohoniq->totalCash, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sjohoniq->totaleamount, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($sjohoniq->totalNcash, 2).'</td>
							</tr>
						</table>		
					';
					//E66A
					$tbl .= '
						<table cellspacing="1" cellpadding="1" border="1">
							<tr>
								<td colspan="7" align="center" style="background-color: #d3d3d3; font-weight:bold;">E66A</td>
							</tr>
							<tr>
								<td align="center" style="background-color: #d3d3d3;font-weight:bold;">ROW</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">Date</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">SALES </td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CARD</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CASH</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">EXPENSES</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
							</tr>';
					$i=1;		
					foreach($resultE66a AS $e66a)
					{	
						$tbl .= '<tr>
									<td align="center">'.$i.'</td>
									<td>'.date_format(date_create($e66a->sdate), 'd/m/Y').'</td>
									<td>RM '.number_format($e66a->totalSales, 2).'</td>
									<td>RM '.number_format($e66a->totalCard, 2).'</td>
									<td>RM '.number_format($e66a->totalCash, 2).'</td>
									<td>RM '.number_format($e66a->totaleamount, 2).'</td>
									<td>RM '.number_format($e66a->totalNcash, 2).'</td>
								</tr>';
						$i++;		
					}		
					$tbl .= '<tr>
								<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
								<td style="font-weight:bold;">RM '.number_format($se66a->totalSales, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($se66a->totalCard, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($se66a->totalCash, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($se66a->totaleamount, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($se66a->totalNcash, 2).'</td>
							</tr>
						</table>		
					';
					$pdf->writeHTML($tbl, true, false, false, false, '');
				}

			// -----------------------------------------------------------------------------
				
				if(1)
				 {		
					 
					$tbl = '';
					$tbl .= '
						<table cellspacing="1" cellpadding="1" border="1">
							<tr>
								<td colspan="7" align="center" style="background-color: #d3d3d3;font-weight:bold;">TAMAY BUSINESS GROUP</td>
							</tr>
							<tr>
								<td align="center" style="background-color: #d3d3d3;font-weight:bold;">ROW</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">Date</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">SALES </td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CARD</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">CASH</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">EXPENSES</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
							</tr>';
					$i=1;		
					foreach($resultGlc AS $glc)
					{	
						$tbl .= '<tr>
									<td align="center">'.$i.'</td>
									<td>GILASCO</td>
									<td>RM '.number_format($glc->totalSales, 2).'</td>
									<td>RM '.number_format($glc->totalCard, 2).'</td>
									<td>RM '.number_format($glc->totalCash, 2).'</td>
									<td>RM '.number_format($glc->totaleamount, 2).'</td>
									<td>RM '.number_format($glc->totalNcash, 2).'</td>
								</tr>';
						$i++;		
					}		
					$tbl .= '
							<tr>
								<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
								<td style="font-weight:bold;">RM '.number_format($glcsum->totalSales, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($glcsum->totalCard, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($glcsum->totalCash, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($glcsum->totaleamount, 2).'</td>
								<td style="font-weight:bold;">RM '.number_format($glcsum->totalNcash, 2).'</td>
							</tr>
						</table>		
					';
						$pdf->writeHTML($tbl, true, false, false, false, '');
					}

				
				// -----------------------------------------------------------------------------
				
				if(1)
				 {		
					 
					$tbl = '';
					$tbl .= '
						<table cellspacing="1" cellpadding="1" border="1">
							<tr>
								<td colspan="5" align="center" style="background-color: #d3d3d3;font-weight:bold;">ALL SHOPS</td>
							</tr>
							<tr>
								<td style="background-color: #d3d3d3;font-weight:bold;">TOTAL SALES</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">TOTAL CARD</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">TOTAL CASH </td>
								<td style="background-color: #d3d3d3;font-weight:bold;">TOTAL EXPENSES</td>
								<td style="background-color: #d3d3d3;font-weight:bold;">NET CASH</td>
								
							</tr>
							<tr>
								<td>RM '.number_format($allshops->totalSales, 2).'</td>
								<td>RM '.number_format($allshops->totalCard, 2).'</td>
								<td>RM '.number_format($allshops->totalCash, 2).'</td>
								<td>RM '.number_format($allshops->totaleamount, 2).'</td>
								<td>RM '.number_format($allshops->totalNcash, 2).'</td>
							</tr>
						</table>		
					';
						$pdf->writeHTML($tbl, true, false, false, false, '');
					}
		}
		else if($slocation == 22)
		{
			//Get sales report day by day
			//1. ESI
			$resultEsi = $this->DailyModel->expensesType($sdate, $edate, '3'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of esi shop
			$sesi = $this->DailyModel->sumofgivenshops($sdate, $edate, '3');
			//2. ESW
			$resultEsw = $this->DailyModel->expensesType($sdate, $edate, '4'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of esw shop
			$sesw = $this->DailyModel->sumofgivenshops($sdate, $edate, '4');
			//3. Johoni-q
			$johoniq = $this->DailyModel->expensesType($sdate, $edate, '5'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of JOHONIQ shop
			$sjohoni = $this->DailyModel->sumofgivenshops($sdate, $edate, '5');
			//4. 66A
			$r66a = $this->DailyModel->expensesType($sdate, $edate, '6'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of 66A shop
			$s66a = $this->DailyModel->sumofgivenshops($sdate, $edate, '6');
			
			//5. glc
			$glc = $this->DailyModel->expensesType($sdate, $edate, '2'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of glc shop
			$sglc = $this->DailyModel->sumofgivenshops($sdate, $edate, '2');
			
			 if(1)
			 {		
				 $text = '<div style="text-align:center;font-size:25;"><h3>SHOP REPORTS</h3></div>
					<div style="text-align: center;">
						<h3>From: '.date_format(date_create($sdate), 'd/m/Y').' To '.date_format(date_create($edate), 'd/m/Y').'</h3>
					</div>
				';
				$pdf->writeHTML($text, true, false, true, false, '');
				$tbl = '';
					$tbl .= '
						<table cellspacing="1" cellpadding="1" border="1">
							<tr>
								<td colspan="3" align="center" style="background-color: #d3d3d3; font-weight:bold;">EDEN FRAGRANCE</td>
							</tr>';
							
							$tbl .= '<tr>
										<td colspan="3" align="center" style="background-color: #d3d3d3; font-weight:bold;">ESI</td>
									</tr>
									<tr>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center;">Shop Name</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Type of Expenses</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Amount</td>
									</tr>';
							
							if(isset($resultEsi->tsub1) AND $resultEsi->tsub1!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESI</td>
										<td style="text-align:center;">Target</td>
										<td style="text-align:center;">RM '.round($resultEsi->tsub1, 2).'</td>
									</tr>';
							}
							if(isset($resultEsi->tsub2) AND $resultEsi->tsub2!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESI</td>
										<td style="text-align:center;">Commission</td>
										<td style="text-align:center;">RM '.round($resultEsi->tsub2, 2).'</td>
									</tr>';
							}
							if(isset($resultEsi->tsub3) AND $resultEsi->tsub3!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESI</td>
										<td style="text-align:center;">Promoter</td>
										<td style="text-align:center;">RM '.round($resultEsi->tsub3, 2).'</td>
									</tr>';
							}
							if(isset($resultEsi->tsub4) AND $resultEsi->tsub4!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESI</td>
										<td style="text-align:center;">Transport</td>
										<td style="text-align:center;">RM '.round($resultEsi->tsub4, 2).'</td>
									</tr>';
							}
							if(isset($resultEsi->tsub5) AND $resultEsi->tsub5!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESI</td>
										<td style="text-align:center;">Voucher</td>
										<td style="text-align:center;">RM '.round($resultEsi->tsub5, 2).'</td>
									</tr>';
							}
							if(isset($resultEsi->tsub6) AND $resultEsi->tsub6!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESI</td>
										<td style="text-align:center;">Advance</td>
										<td style="text-align:center;">RM '.round($resultEsi->tsub6, 2).'</td>
									</tr>';
							}
							if(isset($resultEsi->tsub7) AND $resultEsi->tsub7!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESI</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($resultEsi->tsub7, 2).'</td>
									</tr>';
							}
							if(isset($resultEsi->tsub8) AND $resultEsi->tsub8!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESI</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.$resultEsi->tsub8.'</td>
									</tr>';
							}
							$tbl .= '<tr>
										<td colspan="2" style="text-align:center;">Total</td>
										<td colspan="1" style="text-align:center;">'.round($sesi->totaleamount, 2).'</td>
									</tr>';
							//ESW	
							$tbl .= '<tr>
										<td colspan="3" align="center" style="background-color: #d3d3d3; font-weight:bold;">ESW</td>
									</tr>
									<tr>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center;">Shop Name</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Type of Expenses</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Amount</td>
									</tr>';
							
							if(isset($resultEsw->tsub1) AND $resultEsw->tsub1!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESW</td>
										<td style="text-align:center;">Target</td>
										<td style="text-align:center;">RM '.round($resultEsw->tsub1, 2).'</td>
									</tr>';
							}
							if(isset($resultEsw->tsub2) AND $resultEsw->tsub2!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESW</td>
										<td style="text-align:center;">Commission</td>
										<td style="text-align:center;">RM '.round($resultEsw->tsub2, 2).'</td>
									</tr>';
							}
							if(isset($resultEsw->tsub3) AND $resultEsw->tsub3!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESW</td>
										<td style="text-align:center;">Promoter</td>
										<td style="text-align:center;">RM '.round($resultEsw->tsub3, 2).'</td>
									</tr>';
							}
							if(isset($resultEsw->tsub4) AND $resultEsw->tsub4!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESW</td>
										<td style="text-align:center;">Transport</td>
										<td style="text-align:center;">RM '.round($resultEsw->tsub4, 2).'</td>
									</tr>';
							}
							if(isset($resultEsw->tsub5) AND $resultEsw->tsub5!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESW</td>
										<td style="text-align:center;">Voucher</td>
										<td style="text-align:center;">RM '.round($resultEsw->tsub5, 2).'</td>
									</tr>';
							}
							if(isset($resultEsw->tsub6) AND $resultEsw->tsub6!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESW</td>
										<td style="text-align:center;">Advance</td>
										<td style="text-align:center;">RM '.round($resultEsw->tsub6, 2).'</td>
									</tr>';
							}
							if(isset($resultEsw->tsub7) AND $resultEsw->tsub7!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESW</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($resultEsw->tsub7, 2).'</td>
									</tr>';
							}
							if(isset($resultEsw->tsub8) AND $resultEsw->tsub8!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">ESW</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($resultEsw->tsub8, 2).'</td>
									</tr>';
							}
							$tbl .= '<tr>
										<td colspan="2" style="text-align:center;">Total</td>
										<td colspan="1" style="text-align:center;">'.round($sesw->totaleamount, 2).'</td>
									</tr>';
							//JOHONI-Q	
							$tbl .= '<tr>
										<td colspan="3" align="center" style="background-color: #d3d3d3; font-weight:bold;">JOHONI-Q</td>
									</tr>
									<tr>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center;">Shop Name</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Type of Expenses</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Amount</td>
									</tr>';
							
							if(isset($johoniq->tsub1) AND $johoniq->tsub1!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">JOHONI-Q</td>
										<td style="text-align:center;">Target</td>
										<td style="text-align:center;">RM '.round($johoniq->tsub1, 2).'</td>
									</tr>';
							}
							if(isset($johoniq->tsub2) AND $johoniq->tsub2!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">JOHONI-Q</td>
										<td style="text-align:center;">Commission</td>
										<td style="text-align:center;">RM '.round($johoniq->tsub2, 2).'</td>
									</tr>';
							}
							if(isset($johoniq->tsub3) AND $johoniq->tsub3!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">JOHONI-Q</td>
										<td style="text-align:center;">Promoter</td>
										<td style="text-align:center;">RM '.round($johoniq->tsub3, 2).'</td>
									</tr>';
							}
							if(isset($johoniq->tsub4) AND $johoniq->tsub4!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">JOHONI-Q</td>
										<td style="text-align:center;">Transport</td>
										<td style="text-align:center;">RM '.round($johoniq->tsub4, 2).'</td>
									</tr>';
							}
							if(isset($johoniq->tsub5) AND $johoniq->tsub5!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">JOHONI-Q</td>
										<td style="text-align:center;">Voucher</td>
										<td style="text-align:center;">RM '.round($johoniq->tsub5, 2).'</td>
									</tr>';
							}
							if(isset($johoniq->tsub6) AND $johoniq->tsub6!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">JOHONI-Q</td>
										<td style="text-align:center;">Advance</td>
										<td style="text-align:center;">RM '.round($johoniq->tsub6, 2).'</td>
									</tr>';
							}
							if(isset($johoniq->tsub7) AND $johoniq->tsub7!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">JOHONI-Q</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($johoniq->tsub7, 2).'</td>
									</tr>';
							}
							if(isset($johoniq->tsub8) AND $johoniq->tsub8!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">JOHONI-Q</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($johoniq->tsub8, 2).'</td>
									</tr>';
							}
							$tbl .= '<tr>
										<td colspan="2" style="text-align:center;">Total</td>
										<td colspan="1" style="text-align:center;">'.round($sjohoni->totaleamount, 2).'</td>
									</tr>';	
							//E66A
							$tbl .= '<tr>
										<td colspan="3" align="center" style="background-color: #d3d3d3; font-weight:bold;">E66A</td>
									</tr>
									<tr>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center;">Shop Name</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Type of Expenses</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Amount</td>
									</tr>';
							
							if(isset($r66a->tsub1) AND $r66a->tsub1!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">E66A</td>
										<td style="text-align:center;">Target</td>
										<td style="text-align:center;">RM '.round($r66a->tsub1, 2).'</td>
									</tr>';
							}
							if(isset($r66a->tsub2) AND $r66a->tsub2!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">E66A</td>
										<td style="text-align:center;">Commission</td>
										<td style="text-align:center;">RM '.round($r66a->tsub2, 2).'</td>
									</tr>';
							}
							if(isset($r66a->tsub3) AND $r66a->tsub3!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">E66A</td>
										<td style="text-align:center;">Promoter</td>
										<td style="text-align:center;">RM '.round($r66a->tsub3, 2).'</td>
									</tr>';
							}
							if(isset($r66a->tsub4) AND $r66a->tsub4!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">E66A</td>
										<td style="text-align:center;">Transport</td>
										<td style="text-align:center;">RM '.round($r66a->tsub4, 2).'</td>
									</tr>';
							}
							if(isset($r66a->tsub5) AND $r66a->tsub5!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">E66A</td>
										<td style="text-align:center;">Voucher</td>
										<td style="text-align:center;">RM '.round($r66a->tsub5, 2).'</td>
									</tr>';
							}
							if(isset($r66a->tsub6) AND $r66a->tsub6!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">E66A</td>
										<td style="text-align:center;">Advance</td>
										<td style="text-align:center;">RM '.round($r66a->tsub6, 2).'</td>
									</tr>';
							}
							if(isset($r66a->tsub7) AND $r66a->tsub7!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">E66A</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($r66a->tsub7, 2).'</td>
									</tr>';
							}
							if(isset($r66a->tsub8) AND $r66a->tsub8!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">E66A</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($r66a->tsub8, 2).'</td>
									</tr>';
							}
							$tbl .= '<tr>
										<td colspan="2" style="text-align:center;">Total</td>
										<td colspan="1" style="text-align:center;">'.round($s66a->totaleamount, 2).'</td>
									</tr>';	
							//GLC
							//E66A
							$tbl .= '<tr>
										<td colspan="3" align="center" style="background-color: #d3d3d3; font-weight:bold;">GILASCO</td>
									</tr>
									<tr>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center;">Shop Name</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Type of Expenses</td>
										<td style="background-color: #d3d3d3;font-weight:bold;text-align:center">Amount</td>
									</tr>';
							
							if(isset($glc->tsub1) AND $glc->tsub1!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">GILASCO</td>
										<td style="text-align:center;">Target</td>
										<td style="text-align:center;">RM '.round($glc->tsub1, 2).'</td>
									</tr>';
							}
							if(isset($glc->tsub2) AND $glc->tsub2!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">GILASCO</td>
										<td style="text-align:center;">Commission</td>
										<td style="text-align:center;">RM '.round($glc->tsub2, 2).'</td>
									</tr>';
							}
							if(isset($glc->tsub3) AND $glc->tsub3!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">GILASCO</td>
										<td style="text-align:center;">Promoter</td>
										<td style="text-align:center;">RM '.round($glc->tsub3, 2).'</td>
									</tr>';
							}
							if(isset($glc->tsub4) AND $glc->tsub4!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">GILASCO</td>
										<td style="text-align:center;">Transport</td>
										<td style="text-align:center;">RM '.round($glc->tsub4, 2).'</td>
									</tr>';
							}
							if(isset($glc->tsub5) AND $glc->tsub5!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">GILASCO</td>
										<td style="text-align:center;">Voucher</td>
										<td style="text-align:center;">RM '.round($glc->tsub5, 2).'</td>
									</tr>';
							}
							if(isset($glc->tsub6) AND $glc->tsub6!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">GILASCO</td>
										<td style="text-align:center;">Advance</td>
										<td style="text-align:center;">RM '.round($glc->tsub6, 2).'</td>
									</tr>';
							}
							if(isset($glc->tsub7) AND $glc->tsub7!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">GILASCO</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($glc->tsub7, 2).'</td>
									</tr>';
							}
							if(isset($glc->tsub8) AND $glc->tsub8!=0)
							{		
							$tbl .= '<tr>
										<td style="text-align:center;">GILASCO</td>
										<td style="text-align:center;">Utility</td>
										<td style="text-align:center;">RM '.round($glc->tsub8, 2).'</td>
									</tr>';
							}
							$tbl .= '<tr>
										<td colspan="2" style="text-align:center;">Total</td>
										<td colspan="1" style="text-align:center;">'.round($sglc->totaleamount, 2).'</td>
									</tr>';	
						$tbl .= '</table>		
					';
					$pdf->writeHTML($tbl, true, false, false, false, '');
				}

			// -----------------------------------------------------------------------------
				
				
			
		}
		else
		{
			
			$result = $this->DailyModel->displaysearch($data); 
			//Print pdf for without location
			if(1)
			 {		
				 
				$tbl = '';
				$tbl .= '
					<table cellspacing="0" cellpadding="1" border="1">
						<tr>
							<td colspan="7" align="center" style="padding:5px 5px 5px 5px;">'.bname($slocation).'</td>
						</tr>
						<tr>
							<td align="center">ROW</td>
							<td align="center">SHOP NAME</td>
							<td align="center">SALES </td>
							<td align="center">CARD</td>
							<td align="center">CASH</td>
							<td align="center">EXPENSES</td>
							<td align="center">NET CASH</td>
						</tr>
						<tr>
							<td align="center">1</td>
							<td align="center">'.bname($slocation).'</td>
							<td align="center">RM '.number_format($result->totalSales, 2).'</td>
							<td align="center">RM '.number_format($result->totalCard, 2).'</td>
							<td align="center">RM '.number_format($result->totalCash, 2).'</td>
							<td align="center">RM '.number_format($result->totaleamount, 2).'</td>
							<td align="center">RM '.number_format($result->totalCash-$result->totaleamount, 2).'</td>
						</tr>
					</table>		
				';
					$pdf->writeHTML($tbl, true, false, false, false, '');
				}

			// -----------------------------------------------------------------------------
			
		}
		// -----------------------------------------------------------------------------
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('SHOP_SALES_REPORT-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	
}


