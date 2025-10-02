<?php

namespace App\Controllers;
use App\Models\DailyModel;

use TCPDF;  
class Printpdfdatebased extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index($sdate): string
    {   
        
		 
		//Bring all the Payments
		$result = $this->DailyModel->givendatepayments($sdate);	
		$atotal = $this->DailyModel->givenDateTotalPayments($sdate);
		$ctotal = $this->DailyModel->chequeTotalBydate($sdate);
		$cretotal = $this->DailyModel->creditorsTotal($sdate);
		
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
		$pdf->AddPage('L','A4');

		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', '', 12);

		// -----------------------------------------------------------------------------
		 if(1)
		 {		
			
			
			$text = '<div style="text-align:center;font-size:20; font-weight:bold;">TAMAY BUSINESS GROUP</div>
					<div style="text-align: center;">
						<h3>DATE: '.date_format(date_create($sdate), 'd/m/Y').'</h3> 
					</div>
				';
				$pdf->writeHTML($text, true, false, true, false, '');
			$tbl = '';
			$tbl .= '
				<table cellspacing="1" cellpadding="1" border="0.9px solid;">
					<tr style="background-color: #4caf50;">
						<td colspan="9" align="center" style="font-weight:bold;">PAYMENT</td>
					</tr>
					<tr>
						<td align="center" style="font-weight:bold;background-color: #d3d3d3;">ROW</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">Due Date</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">Invoice No</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">Amount</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">Cheque No</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">Bank Name</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">Paid to</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">Status</td>
						<td style="font-weight:bold;background-color: #d3d3d3;">Remark</td>
					</tr>';
			foreach($result AS $row)
			{
					$status='';
					if($row->status==1)
					{
						$status = "Pending";
					}
					else if($row->status==2)
					{
						$status = "Paid";
					}
					else if($row->status==3)
					{
						$status = "Cancelled";
					}
					//background color
					$bgc='';
					if($row->ptype == 1)
					{
						$bgc="background-color:#ffffc5";
					}
					else if($row->ptype == 2)
					{
						$bgc="background-color:#90EE90";
					}
			$tbl .='		
					<tr style="'.$bgc.'">
						<td align="center">1</td>
						<td>'.date_format(date_create($row->ddate), 'd/m/Y').'</td>
						<td>'.$row->invNo.'</td>
						<td>RM '.number_format($row->amount, 2).'</td>
						<td>'.$row->cno.'</td>
						<td>'.bankName($row->bname).'</td>
						<td>'.getdbc($row->pto).'</td>
						<td>'.$status.'</td>
						<td>'.$row->remark.'</td>
					</tr>';
			}		
			$tbl .='
				<tr style="background-color: #ffffc5;">
					<td colspan="8" style="font-weight:bold;">Total Cheques</td>
					<td colspan="1" style="font-weight:bold;">RM '.number_format($ctotal->totalAmount, 2).'</td>
				</tr>
				<tr style="background-color: #90EE90">
					<td colspan="8" style="font-weight:bold;">Total Creditors</td>
					<td colspan="1" style="font-weight:bold;">RM '.number_format($cretotal->totalAmount, 2).'</td>
				</tr>
				<tr style="background-color:#d3d3d3">
					<td colspan="8" style="font-weight:bold;">All Total</td>
					<td colspan="1" style="font-weight:bold;">RM '.number_format($atotal->totalAmount, 2).'</td>
				</tr>
				</table>
			';
			
			$pdf->writeHTML($tbl, true, false, false, false, '');

			// -----------------------------------------------------------------------------
			
			//header('Content-Type: application/pdf');
			//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
			//Close and output PDF document
			$pdf->Output('Report of -'.date_format(date_create($sdate), 'd/m/Y').'.pdf', 'I');
			
			
			echo APPPATH; exit;
			return view('printpdf/singleprint');
		 }	
    }
	//By given dates
	public function bygivendates($sdate, $edate)
	{
			
			$data = array(
					'sdate'=>$sdate,
					'edate'=>$edate
				  ); 
				  
			//Get dates between two ranges  
			$dates = $this->displayDates($sdate, $edate); //echo "<pre />"; print_r($dates); exit;
			
			//Bring all the Payments
			$result = $this->DailyModel->searchAmountBydate($data);	//echo "<pre />"; print_r($result); exit;
			$total = $this->DailyModel->totalsearchBydate($data);
			
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
			$pdf->AddPage('L','A4');

			$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

			$pdf->SetFont('helvetica', '', 14);

			// -----------------------------------------------------------------------------
			 if(1)
			 {		
				
				
				$text = '<div style="text-align:center;font-size:20; font-weight:bold;">TAMAY BUSINESS GROUP</div>
						<div style="text-align: center;">
							<h3>From: '.date_format(date_create($sdate), 'd/m/Y').' To '.date_format(date_create($sdate), 'd/m/Y').'</h3> 
						</div>
					';
					$pdf->writeHTML($text, true, false, true, false, '');
				$tbl = '';
				$tbl .= '
					<table cellspacing="1" cellpadding="1" border="0.9px solid;">
						<tr style="background-color: #4caf50;">
							<td colspan="4" align="center" style="font-weight:bold;">PAYMENT</td>
						</tr>
						<tr>
							<td align="center" style="font-weight:bold;background-color: #d3d3d3;">ROW</td>
							<td style="font-weight:bold;background-color: #d3d3d3;">Day</td>
							<td style="font-weight:bold;background-color: #d3d3d3;">Due Date</td>
							<td style="font-weight:bold;background-color: #d3d3d3;">Amount</td>
						</tr>';
				$i=1;
				//define start date
				$cdate = date_format(date_create($sdate), 'Y-m-d');			
				foreach($result AS $row)
				{
								
					if($row->ddate>$cdate)
					{	
						
						for($j=$cdate; $j<$row->ddate; $j++)
						{	
							$tbl .='		
									<tr style="">
										<td align="center">'.$i.'</td>
										<td>'.date('l', strtotime($j)).'</td>
										<td>'.date_format(date_create($j), 'd/m/Y').'</td>
										<td>RM 0</td>
										
									</tr>';
							$i++;		
						}		
					}
						
					$tbl .='		
							
							<tr style="">
								<td align="center">'.$i.'</td>
								<td>'.date('l', strtotime($row->ddate)).'</td>
								<td>'.date_format(date_create($row->ddate), 'd/m/Y').'</td>
								<td>RM '.number_format($row->totalAmount, 2).'</td>
								
							</tr>';
									
					$i++;
					//Plus one the date
					$cdate = date("Y-m-d", strtotime($row->ddate. "+1 days"));	
				}		
				$tbl .='
						<tr>
							<td align="center" colspan="3" style="font-weight:bold;">Total</td>
							<td style="font-weight:bold;">RM '.number_format($total->totalAmount, 2).'</td>
						</tr>
					</table>
				';
				
				$pdf->writeHTML($tbl, true, false, false, false, '');

				// -----------------------------------------------------------------------------
				
				//header('Content-Type: application/pdf');
				//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
				//Close and output PDF document
				$pdf->Output('Report of -'.date_format(date_create($sdate), 'd/m/Y').'.pdf', 'I');
				
				
				echo APPPATH; exit;
				return view('printpdf/singleprint');
			 }		
	}

	//Get dates between two given dates
	public function displayDates($date1, $date2, $format = 'd-m-Y' )
	{
	  $dates = array();
	  $current = strtotime($date1);
	  $date2 = strtotime($date2);
	  $stepVal = '+1 day';
	  while( $current <= $date2 ) {
		 $dates[] = date($format, $current);
		 $current = strtotime($stepVal, $current);
	  }
	  return $dates;
	}	
	
}
