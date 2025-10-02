<?php

namespace App\Controllers;
use App\Models\DailyModel;

use TCPDF;  
class PrintpdfNightReports extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index(): string
    {   
        
		 //Get all shop records
		$tamay = $this->DailyModel->tamayn();			
		$bergaya = $this->DailyModel->bergayan();			
		$eden = $this->DailyModel->edenn();			
		$edensi = $this->DailyModel->edensin();			
		$edensw = $this->DailyModel->edenswn();			
		$edenjo = $this->DailyModel->edenjon();			
		$edenjo2 = $this->DailyModel->edenjon2();			
		$edena = $this->DailyModel->edenan();			
		$allshops = $this->DailyModel->allshopsn();
		 
		 
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
		$pdf->AddPage('L', 'A4');
		$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
	
		$pdf->SetFont('helvetica', '', 14);

		// -----------------------------------------------------------------------------
	 if(1)
	 {		
		$text = '<div style="text-align:center;font-size:25;">Nightly Sales Report</div>
			<div style="text-align: center;">
				Date: '.date('d/m/Y H:i').'
			</div>
		';
		$pdf->writeHTML($text, true, false, true, false, '');
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="1" cellpadding="1" border="1" >
				<tr>
					<td colspan="7" align="center" style="font-weight:bold;background-color: #d3d3d3;">EDEN FRAGRANCE</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">SHOP NAME</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">SALES </td>
					<td style="font-weight:bold;background-color: #d3d3d3;">CARD</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">CASH</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">EXPENSES</td>
					<td style="font-weight:bold;background-color: #d3d3d3;">NET CASH</td>
				</tr>
				<tr>
					<td align="center">1</td>
					<td>ESI</td>
					<td>RM '.number_format($edensi->totalSales, 2).'</td>
					<td>RM '.number_format($edensi->totalCard, 2).'</td>
					<td>RM '.number_format($edensi->totalCash, 2).'</td>
					<td>RM '.number_format($edensi->totaleamount, 2).'</td>
					<td>RM '.number_format($edensi->totalNcash, 2).'</td>
				</tr>
				<tr>
					<td align="center">2</td>
					<td>ESW</td>
					<td>RM '.number_format($edensw->totalSales, 2).'</td>
					<td>RM '.number_format($edensw->totalCard, 2).'</td>
					<td>RM '.number_format($edensw->totalCash, 2).'</td>
					<td>RM '.number_format($edensw->totaleamount, 2).'</td>
					<td>RM '.number_format($edensw->totalNcash, 2).'</td>
				</tr>
				<tr>
					<td align="center">3</td>
					<td>JOHONI-Q</td>
					<td>RM '.number_format($edenjo->totalSales, 2).'</td>
					<td>RM '.number_format($edenjo->totalCard, 2).'</td>
					<td>RM '.number_format($edenjo->totalCash, 2).'</td>
					<td>RM '.number_format($edenjo->totaleamount, 2).'</td>
					<td>RM '.number_format($edenjo->totalNcash, 2).'</td>
				</tr>
				
				<tr>
					<td align="center">4</td>
					<td>E66A</td>
					<td>RM '.number_format($edena->totalSales, 2).'</td>
					<td>RM '.number_format($edena->totalCard, 2).'</td>
					<td>RM '.number_format($edena->totalCash, 2).'</td>
					<td>RM '.number_format($edena->totaleamount, 2).'</td>
					<td>RM '.number_format($edena->totalNcash, 2).'</td>
				</tr>
				<tr>
					<td colspan="2" align="center" style="font-weight:bold;">TOTAL</td>
					<td style="font-weight:bold">RM '.number_format($eden->totalSales, 2).'</td>
					<td style="font-weight:bold">RM '.number_format($eden->totalCard, 2).'</td>
					<td style="font-weight:bold">RM '.number_format($eden->totalCash, 2).'</td>
					<td style="font-weight:bold">RM '.number_format($eden->totaleamount, 2).'</td>
					<td style="font-weight:bold">RM '.number_format($eden->totalNcash, 2).'</td>
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
						<td colspan="7" align="center" style="font-weight:bold;background-color: #d3d3d3;">TAMAY BUSINESS GROUP</td>
					</tr>
					<tr>
						<td style="font-weight:bold;background-color: #d3d3d3;">ROW</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">SHOP NAME</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">SALES </td>
						<td style="font-weight:bold;background-color: #d3d3d3;">CARD</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">CASH</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">EXPENSES</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">NET CASH</td>
					</tr>
					<tr>
						<td align="center">1</td>
						<td align="center">GILASCO</td>
						<td>RM '.number_format($tamay->totalSales, 2).'</td>
						<td>RM '.number_format($tamay->totalCard, 2).'</td>
						<td>RM '.number_format($tamay->totalCash, 2).'</td>
						<td>RM '.number_format($tamay->totaleamount, 2).'</td>
						<td>RM '.number_format($tamay->totalNcash, 2).'</td>
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
				<table cellspacing="1" cellpadding="2" border="1">
					<tr>
						<td colspan="5" align="center" style="font-weight:bold;background-color: #d3d3d3;">ALL SHOP REPORTS</td>
					</tr>
					<tr>
						<td style="font-weight:bold;background-color: #d3d3d3;">TOTAL SALES</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">TOTAL CARD</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">TOTAL CASH </td>
						<td style="font-weight:bold;background-color: #d3d3d3;">TOTAL EXPENSES</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">NET CASH</td>
						
					</tr>
					<tr>
						<td align="">RM '.number_format($allshops->totalSales, 2).'</td>
						<td align="">RM '.number_format($allshops->totalCard, 2).'</td>
						<td align="">RM '.number_format($allshops->totalCash, 2).'</td>
						<td align="">RM '.number_format($allshops->totaleamount, 2).'</td>
						<td align="">RM '.number_format($allshops->totalNcash, 2).'</td>
					</tr>
				</table>		
			';
				$pdf->writeHTML($tbl, true, false, false, false, '');
			}

		// -----------------------------------------------------------------------------
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('Nightly_Sales_Report-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	
}
