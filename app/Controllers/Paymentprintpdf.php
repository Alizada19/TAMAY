<?php

namespace App\Controllers;
use App\Models\DailyModel;

use TCPDF;  
class Paymentprintpdf extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	//Print all the cheques
	public function cheque(): string
    {   
         
		//Bring all the cheques to print
		$chequeresult = $this->DailyModel->chequereports();	
		$chequetotal = $this->DailyModel->chequeTotal();
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
	
		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------
	 if($chequeresult)
	 {		
		$text = '
			<div style="text-align: center;">
				Date: '.date('Y-m-d').'
			</div>
		';
		$pdf->writeHTML($text, true, false, true, false, '');
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
				<tr>
					<td colspan="8" align="center" style="font-weight:bold;background-color: #d3d3d3;">All Cheques</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;width:7%;">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:11%;">Due Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Bank</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:11%;">Cheque No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:14%;">Amount</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:25%;">Pay To</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Remark</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:8%;">Status</td>
				</tr>';
			$i=1;	
			foreach($chequeresult AS $cheque)
			{	
				$status='';
				if($cheque->status == 1)
				{
					$status = 'Pending';
				}
				else if($cheque->status == 2)
				{
					$status = 'Paid';
				}
				else if($cheque->status == 10)
				{
					$status = 'Not Issued';
				}	
			$tbl .='<tr>
					<td align="center" style="width:7%;">'.$i.'</td>
					<td style="width:11%;">'.$cheque->ddate.'</td>
					<td style="width:12%;">'.bankName($cheque->bname).'</td>
					<td style="width:11%;">'.$cheque->cno.'</td>
					<td style="width:14%;">RM '.number_format($cheque->amount, 2).'</td>
					<td style="width:25%;">'.getdbc($cheque->pto).'</td>
					<td style="width:12%;">'.$cheque->remark.'</td>
					<td style="width:8%;">'.$status.'</td>
				</tr>';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="6" align="center" style="font-weight:bold;">Total</td>
					<td colspan="2" style="font-weight:bold;">RM '.number_format($chequetotal->totalAmount, 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}		

		// -----------------------------------------------------------------------------
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('Cheques-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	
	//Print specefic search records
	public function printcheque()
    {  	
		$request = \Config\Services::request(); //echo "<pre />"; print_r($request); exit;
		$sdate = $request->getGet('sdate');
		$edate = $request->getGet('edate');
		$status = $request->getGet('status');
		$cno = $request->getGet('cno');
		
		$data = array(
			'sdate' => $sdate,
			'edate' => $edate,
			'status' => $status,
			'cno' => $cno
		);
		//echo "<pre />"; print_r($data); exit;
		//Bring all the cheques to print
		$chequeresult = $this->DailyModel->chequeSpeceficReport($data);	
		$chequetotal = $this->DailyModel->chequeSpeceficTotal($data);
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
	
		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------
		 if($chequeresult)
		 {		
			$text = '
				<div style="text-align: center;">
					From: '.$sdate.' To '.$edate.'
				</div>
			';
			$pdf->writeHTML($text, true, false, true, false, '');
			
			$tbl = '';
			$tbl .= '
				<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
				<tr>
					<td colspan="8" align="center" style="font-weight:bold;background-color: #d3d3d3;">All Cheques</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;width:7%;">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:11%;">Due Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Bank</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:11%;">Cheque No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:14%;">Amount</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:25%;">Pay To</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Remark</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:8%;">Status</td>
				</tr>';
				$i=1;	
				foreach($chequeresult AS $cheque)
				{	
					$status='';
					if($cheque->status == 1)
					{
						$status = 'Pending';
					}
					else if($cheque->status == 2)
					{
						$status = 'Paid';
					}	
					else if($cheque->status == 10)
					{
						$status = 'Not Issued';
					}	
				$tbl .='<tr>
							<td align="center" style="width:7%;">'.$i.'</td>
							<td style="width:11%;">'.$cheque->ddate.'</td>
							<td style="width:12%;">'.bankName($cheque->bname).'</td>
							<td style="width:11%;">'.$cheque->cno.'</td>
							<td style="width:14%;">RM '.number_format($cheque->amount, 2).'</td>
							<td style="width:25%;">'.getdbc($cheque->pto).'</td>
							<td style="width:12%;">'.$cheque->remark.'</td>
							<td style="width:8%;">'.$status.'</td>
						</tr>';
					$i++;
				}	
				$tbl .='
					<tr>
						<td colspan="6" align="center" style="font-weight:bold;">Total</td>
						<td colspan="2" style="font-weight:bold;">RM '.number_format($chequetotal->totalAmount, 2).'</td>

					</tr>';
				$tbl .='</table>';
				$pdf->writeHTML($tbl, true, false, false, false, '');
			}		

			// -----------------------------------------------------------------------------
			//header('Content-Type: application/pdf');
			//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
			//Close and output PDF document
			$pdf->Output('Cheques-'.date('Y-m-d').'.pdf', 'I');
			
			
			echo APPPATH; exit;
			return view('printpdf/singleprint');
    }
	

	//Print pdf all OT (Online Transfer/Cash)
	//Print all the cheques
	public function ot(): string
    {   
       
		//Bring all the cheques to print
		$otresult = $this->DailyModel->otReports();	
		$ottotal = $this->DailyModel->otTotal();
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
	
		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------
	 if(1)
	 {		
		$pdf->Cell(180, 8, 'REPORT OF CREDITORS AS ON '.date('d/m/Y'), 0, 1, 'C', 0, '', '', '');
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%;">
				<tr>
					<td colspan="8" align="center" style="font-weight:bold;background-color: #d3d3d3;">Creditors</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;width:7%">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Invoice Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Invoice No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Amount</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:28%;">Pay To</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Status</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
				</tr>';
			$i=1;
			$status='';	
			foreach($otresult AS $ot)
			{	
				//Check the status
				if($ot->status == 1)
				{
					$status = "Pending";
				}
				else if($ot->status == 2)
				{
					$status = "Paid";
				}
				else if($ot->status == 3)
				{
					$status = "Cancelled";
				}	
				
						
			$tbl .='<tr>
					<td align="center" style="width:7%;">'.$i.'</td>
					<td style="width:10%;">'.$ot->invDate.'</td>
					<td style="width:10%;">'.$ot->ddate.'</td>
					<td style="width:10%;">'.$ot->invNo.'</td>
					<td style="width:12%;">RM '.number_format($ot->amount, 2).'</td>
					<td style="width:28%;">'.getdbc($ot->pto).'</td>
					<td style="width:10%;">'.$status.'</td>
					<td style="width:13%;">'.$ot->remark.'</td>
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="7" align="center" style="font-weight:bold;">Total</td>
					<td colspan="1" style="font-weight:bold;">RM '.number_format($ottotal->totalAmount, 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}		

		// -----------------------------------------------------------------------------
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('Creditors-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	
	//Print OT with specefic give dates
	public function printotsearch()
    {   
		$request = \Config\Services::request();	
		$sdate = $request->getGet('sdate');
		$edate = $request->getGet('edate');
		$status = $request->getGet('status');
		$nsdate = $request->getGet('nsdate');
		$nedate = $request->getGet('nedate');
		$invNo = $request->getGet('invNo');
		$creditor = $request->getGet('creditor');
		
		$data = array(
			'sdate'=>$sdate,
			'edate'=>$edate,
			'status'=>$status,
			'nsdate'=>$nsdate,
			'nedate'=>$nedate,
			'invNo'=>$invNo,
			'creditor'=>$creditor
		  );
		   
		//Bring OTS to print
		$otresult = $this->DailyModel->otSpeceficReportSearch($data);	
		$ottotal = $this->DailyModel->otSearchTotal($data);
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
	
		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------
		 if(1)
		 {		
			$pdf->Cell(180, 8, 'REPORT OF CREDITORS AS ON '.date('d/m/Y'), 0, 1, 'C', 0, '', '', '');
			
			$tbl = '';
			$tbl .= '
				<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%;">
				<tr>
					<td colspan="8" align="center" style="font-weight:bold;background-color: #d3d3d3;">Creditors</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;width:7%">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Invoice Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Invoice No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Amount</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:28%;">Pay To</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Status</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
				</tr>';
				$i=1;	
				$status='';
				foreach($otresult AS $ot)
				{	
					//Status
					if($ot->status == 1)
					{
						$status = "Pending";
					}
					else if($ot->status == 2)
					{
						$status = "Paid";
					}		
					else if($ot->status == 3)
					{
						$status = "Cancelled";
					}
					else if($ot->status == 10)
					{
						$status = "Not Issued";
					}	
				$tbl .='<tr>
							<td align="center" style="width:7%;">'.$i.'</td>
							<td style="width:10%;">'.$ot->invDate.'</td>
							<td style="width:10%;">'.$ot->ddate.'</td>
							<td style="width:10%;">'.$ot->invNo.'</td>
							<td style="width:12%;">RM '.number_format($ot->amount, 2).'</td>
							<td style="width:28%;">'.getdbc($ot->pto).'</td>
							<td style="width:10%;">'.$status.'</td>
							<td style="width:13%;">'.$ot->remark.'</td>
						</tr>
						';
					$i++;
				}	
				$tbl .='
					<tr>
						<td colspan="7" align="center" style="font-weight:bold;">Total</td>
						<td colspan="1" style="font-weight:bold;">RM '.number_format($ottotal->totalAmount, 2).'</td>

					</tr>';
				$tbl .='</table>';
				$pdf->writeHTML($tbl, true, false, false, false, '');
			}		

			// -----------------------------------------------------------------------------
			//header('Content-Type: application/pdf');
			//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
			//Close and output PDF document
			$pdf->Output('Creditors-'.date('Y-m-d').'.pdf', 'I');
			
			
			echo APPPATH; exit;
			return view('printpdf/singleprint');
    }
	
	//Pdf all payments
	public function pdfAllPayments()
    {   
		
		//Bring all the cheques to print
		$chequeresult = $this->DailyModel->chequereports();	
		$chequetotal = $this->DailyModel->chequeTotal();
		
		//Bring all the cheques OT/Cash print
		$otresult = $this->DailyModel->otReports();	
		$ottotal = $this->DailyModel->otTotal();
		 	
		
		$allTotal = $chequetotal->totalAmount + $ottotal->totalAmount;
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
	
		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------
	 if($chequeresult)
	 {		
		$text = '<div style="text-align:center;font-size:20;">Cheques</div>';
		$pdf->writeHTML($text, true, false, true, false, '');
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
				<tr>
					<td colspan="8" align="center" style="font-weight:bold;background-color: #d3d3d3;">All Cheques</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;width:5%;">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Bank</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Cheque No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:14%;">Amount</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:30%;">Pay To</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:8%;">Status</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
				</tr>';
			$i=1;	
			foreach($chequeresult AS $cheque)
			{	
				$status='';
				if($cheque->status == 1)
				{
					$status = 'Pending';
				}
				else if($cheque->status == 2)
				{
					$status = 'Paid';
				}
				else if($cheque->status == 3)
				{
					$status = 'Cancelled';
				}
				else if($cheque->status == 10)
				{
					$status = 'Not Issued';
				}	
			$tbl .='<tr>
					<td align="center" style="width:5%;">'.$i.'</td>
					<td style="width:10%;">'.$cheque->ddate.'</td>
					<td style="width:10%;">'.bankName($cheque->bname).'</td>
					<td style="width:10%;">'.$cheque->cno.'</td>
					<td style="width:14%;">RM '.number_format($cheque->amount, 2).'</td>
					<td style="width:30%;">'.getdbc($cheque->pto).'</td>
					<td style="width:8%;">'.$status.'</td>
					<td style="width:13%;">'.$cheque->remark.'</td>
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="7" align="center" style="font-weight:bold;">Total</td>
					<td colspan="1" style="font-weight:bold;">RM '.number_format($chequetotal->totalAmount, 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}		

		// -----------------------------------------------------------------------------
			// -----------------------------------------------------------------------------
	 if($otresult)
	 {		
		$text = '<div style="text-align:center;font-size:20;">On Accounts</div>';
		$pdf->writeHTML($text, true, false, true, false, '');
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
				<tr>
					<td colspan="7" align="center" style="font-weight:bold;background-color: #d3d3d3;">All On Accounts</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3; width:5%;">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:11%;">Invoice No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Amount</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:39%;">Pay To</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Status</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
				</tr>';
			$i=1;	
			$status="";
			foreach($otresult AS $ot)
			{	
				if($ot->status == 1)
				{
					$status = "Pending";
				}
				else if($ot->status == 2)
				{
					$status = "Paid";
				}
				else if($ot->status == 3)
				{
					$status = "Cancelled";
				}
				else if($ot->status == 10)
				{
					$status = "Not Issued";
				}
			$tbl .='<tr>
					<td align="center" style="width:5%;">'.$i.'</td>
					<td style="width:10%;">'.$ot->ddate.'</td>
					<td style="width:11%;">'.$ot->invNo.'</td>
					<td style="width:12%;">'.$ot->amount.'</td>
					<td style="width:39%;">'.getdbc($ot->pto).'</td>
					<td style="width:10%;">'.$status.'</td>
					<td style="width:13%;">'.$ot->remark.'</td>
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="6" align="center" style="font-weight:bold;">Total</td>
					<td colspan="1" style="font-weight:bold;">RM '.number_format($ottotal->totalAmount, 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
					
		}

		//Uncheduled
		 if($unRes)
		 {		
			$text = '<div style="text-align:center;font-size:20;">Uncheduled</div>
			';
			$pdf->writeHTML($text, true, false, true, false, '');
			
			$tb3 = '';
			$tb3 .= '
				<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
					<tr>
						<td colspan="7" align="center" style="font-weight:bold;background-color: #d3d3d3;">All Uncheduled</td>
					</tr>
					<tr>
						<td align="center" style="font-weight:bold;background-color: #d3d3d3; width:5%;">ROW</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:11%;">Invoice No</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Amount</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:39%;">Pay To</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Status</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
					</tr>';
				$i=1;	
				$status="";
				foreach($unRes AS $un)
				{	
				
				$tb3 .='<tr>
						<td align="center" style="width:5%;">'.$i.'</td>
						<td style="width:10%;">'.$un->ddate.'</td>
						<td style="width:11%;">'.$un->invNo.'</td>
						<td style="width:12%;">'.$un->amount.'</td>
						<td style="width:39%;">'.getdbc($un->pto).'</td>
						<td style="width:10%;">Uncheduled</td>
						<td style="width:13%;">'.$un->remark.'</td>
					</tr>
					';
					$i++;
				}	
				$tb3 .='
					<tr>
						<td colspan="6" align="center" style="font-weight:bold;">Total</td>
						<td colspan="1" style="font-weight:bold;">RM '.number_format($unTotal->totalAmount, 2).'</td>

					</tr>';
				$tb3 .='</table>';
				$pdf->writeHTML($tb3, true, false, false, false, '');
				
				$tbl='';
				$tbl .= '
					<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
						
						<tr>
							<td  align="center" style="font-weight:bold;background-color: #d3d3d3;">All Total</td>
							<td align="center" style="font-weight:bold;background-color: #d3d3d3;">RM '.number_format($allTotal, 2).'</td>
						</tr>
					</table>	
						';
				$pdf->writeHTML($tbl, true, false, true, false, '');		
			}		
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('All Payments-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	
	//All Payment Search by given dates
	public function printpdfAllSearchBydate()
    {   
		
		$sdate = $this->request->getGet('sdate');
		$edate = $this->request->getGet('edate');
		$status = $this->request->getGet('status');
		$nsdate = $this->request->getGet('nsdate');
		$nedate = $this->request->getGet('nedate');
		$invNo = $this->request->getGet('invNo');
		$creditor = $this->request->getGet('creditor');
		$cno = $this->request->getGet('cno');	
		$type = $this->request->getGet('type');
	
		$data=array(
			'sdate' => $sdate,
			'edate' => $edate,
			'status' => $status,
			'nsdate'=>$nsdate,
			'nedate'=>$nedate,
			'invNo'=>$invNo,
			'creditor'=>$creditor,
			'cno'=>$cno,
			'type'=>$type
		); 
		$allTotal='';
		//Bring all the cheques to print	
		$chequeresult = $this->DailyModel->chequeSpeceficReport2($data);	
		$chequetotal = $this->DailyModel->chequeSpeceficTotal2($data);
	
		//Bring all the  OT/Cash print
		$otresult = $this->DailyModel->otsearch($data);	
		$ottotal = $this->DailyModel->otsearchtTotal($data);
	
		$allTotal = $chequetotal->totalAmount + $ottotal->totalAmount;		
		
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
	
		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------
	 if($type==1)
	 {		
		$text = '<div style="text-align:center;font-size:20;">Cheques</div>';
		$pdf->writeHTML($text, true, false, true, false, '');
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
				<tr>
					<td colspan="8" align="center" style="font-weight:bold;background-color: #d3d3d3;">All Cheques</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;width:5%;">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Bank</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Cheque No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:14%;">Amount</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:30%;">Pay To</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:8%;">Status</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
				</tr>';
			$i=1;	
			foreach($chequeresult AS $cheque)
			{	
				$status='';
				if($cheque->status == 1)
				{
					$status = 'Pending';
				}
				else if($cheque->status == 2)
				{
					$status = 'Paid';
				}
				else if($cheque->status == 3)
				{
					$status = 'Cancelled';
				}
				else if($cheque->status == 10)
				{
					$status = 'Not Issued';
				}	
			$tbl .='<tr>
					<td align="center" style="width:5%;">'.$i.'</td>
					<td style="width:10%;">'.$cheque->ddate.'</td>
					<td style="width:10%;">'.bankName($cheque->bname).'</td>
					<td style="width:10%;">'.$cheque->cno.'</td>
					<td style="width:14%;">RM '.number_format($cheque->amount, 2).'</td>
					<td style="width:30%;">'.getdbc($cheque->pto).'</td>
					<td style="width:8%;">'.$status.'</td>
					<td style="width:13%;">'.$cheque->remark.'</td>
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="7" align="center" style="font-weight:bold;">Total</td>
					<td colspan="1" style="font-weight:bold;">RM '.number_format($chequetotal->totalAmount, 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
					
		}		
	 else if($type==2 AND $otresult)
	 {		
		$text = '<div style="text-align:center;font-size:20;">On Accounts</div>';
		$pdf->writeHTML($text, true, false, true, false, '');
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
				<tr>
					<td colspan="7" align="center" style="font-weight:bold;background-color: #d3d3d3;">All On Accounts</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3; width:5%;">ROW</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:11%;">Invoice No</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Amount</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:39%;">Pay To</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Status</td>
					<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
				</tr>';
			$i=1;	
			$status = '';
			foreach($otresult AS $ot)
			{	
				if($ot->status == 1)
				{
					$status = "Pending";
				}
				else if($ot->status == 2)
				{
					$status = "Paid";
				}
				else if($ot->status == 3)
				{
					$status = "Cancelled";
				}
				else if($ot->status == 10)
				{
					$status = "Not Issued";
				}	
			$tbl .='<tr>
					<td align="center" style="width:5%;">'.$i.'</td>
					<td style="width:10%;">'.$ot->ddate.'</td>
					<td style="width:11%;">'.$ot->invNo.'</td>
					<td style="width:12%;">'.$ot->amount.'</td>
					<td style="width:39%;">'.getdbc($ot->pto).'</td>
					<td style="width:10%;">'.$status.'</td>
					<td style="width:13%;">'.$ot->remark.'</td>
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="7" align="center" style="font-weight:bold;">Total</td>
					<td colspan="1" style="font-weight:bold;">RM '.number_format($ottotal->totalAmount, 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
					
		}
		else
		{
			$text = '<div style="text-align:center;font-size:20;">Cheques</div>';
			$pdf->writeHTML($text, true, false, true, false, '');
			
			$tbl = '';
			$tbl .= '
				<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
					<tr>
						<td colspan="8" align="center" style="font-weight:bold;background-color: #d3d3d3;">All Cheques</td>
					</tr>
					<tr>
						<td align="center" style="font-weight:bold;background-color: #d3d3d3;width:5%;">ROW</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Bank</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Cheque No</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:14%;">Amount</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:30%;">Pay To</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:8%;">Status</td>
						<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
					</tr>';
				$i=1;	
				foreach($chequeresult AS $cheque)
				{	
					$status='';
					if($cheque->status == 1)
					{
						$status = 'Pending';
					}
					else if($cheque->status == 2)
					{
						$status = 'Paid';
					}
					else if($cheque->status == 3)
					{
						$status = 'Cancelled';
					}
					else if($cheque->status == 10)
					{
						$status = 'Not Issued';
					}	
				$tbl .='<tr>
						<td align="center" style="width:5%;">'.$i.'</td>
						<td style="width:10%;">'.$cheque->ddate.'</td>
						<td style="width:10%;">'.bankName($cheque->bname).'</td>
						<td style="width:10%;">'.$cheque->cno.'</td>
						<td style="width:14%;">RM '.number_format($cheque->amount, 2).'</td>
						<td style="width:30%;">'.getdbc($cheque->pto).'</td>
						<td style="width:8%;">'.$status.'</td>
						<td style="width:13%;">'.$cheque->remark.'</td>
					</tr>
					';
					$i++;
				}	
				$tbl .='
					<tr>
						<td colspan="7" align="center" style="font-weight:bold;">Total</td>
						<td colspan="1" style="font-weight:bold;">RM '.number_format($chequetotal->totalAmount, 2).'</td>

					</tr>';
				$tbl .='</table>';
				$pdf->writeHTML($tbl, true, false, false, false, '');
				//On accounts
				$text = '<div style="text-align:center;font-size:20;">On Accounts</div>';
				$pdf->writeHTML($text, true, false, true, false, '');
				
				$tbl = '';
				$tbl .= '
					<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
						<tr>
							<td colspan="7" align="center" style="font-weight:bold;background-color: #d3d3d3;">All On Accounts</td>
						</tr>
						<tr>
							<td align="center" style="font-weight:bold;background-color: #d3d3d3; width:5%;">ROW</td>
							<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Due Date</td>
							<td style="font-weight:bold;background-color: #d3d3d3;width:11%;">Invoice No</td>
							<td style="font-weight:bold;background-color: #d3d3d3;width:12%;">Amount</td>
							<td style="font-weight:bold;background-color: #d3d3d3;width:39%;">Pay To</td>
							<td style="font-weight:bold;background-color: #d3d3d3;width:10%;">Status</td>
							<td style="font-weight:bold;background-color: #d3d3d3;width:13%;">Remark</td>
						</tr>';
					$i=1;	
					$status = '';
					foreach($otresult AS $ot)
					{	
						if($ot->status == 1)
						{
							$status = "Pending";
						}
						else if($ot->status == 2)
						{
							$status = "Paid";
						}
						else if($ot->status == 3)
						{
							$status = "Cancelled";
						}
						else if($ot->status == 10)
						{
							$status = "Not Issued";
						}	
					$tbl .='<tr>
							<td align="center" style="width:5%;">'.$i.'</td>
							<td style="width:10%;">'.$ot->ddate.'</td>
							<td style="width:11%;">'.$ot->invNo.'</td>
							<td style="width:12%;">'.$ot->amount.'</td>
							<td style="width:39%;">'.getdbc($ot->pto).'</td>
							<td style="width:10%;">'.$status.'</td>
							<td style="width:13%;">'.$ot->remark.'</td>
						</tr>
						';
						$i++;
					}	
					$tbl .='
						<tr>
							<td colspan="6" align="center" style="font-weight:bold;">Total</td>
							<td colspan="1" style="font-weight:bold;">RM '.number_format($ottotal->totalAmount, 2).'</td>

						</tr>';
					$tbl .='</table>';
					$pdf->writeHTML($tbl, true, false, false, false, '');
					

		}
		
		/*$tb4='';	
		$tb4 .= '
				<table cellspacing="0.1" cellpadding="4" border="0.1" style="width:100%">
					<tr>
						<td align="center" style="font-weight:bold;background-color: #d3d3d3;">All Total</td>
						<td align="center" style="font-weight:bold;background-color: #d3d3d3;">RM '.number_format($allTotal, 2).'</td>
					</tr>
				</table>	
					';
			$pdf->writeHTML($tb4, true, false, true, false, '');*/
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('All Payments-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	
	//print all reports by suppliers
	public function supReports()
    {   
		
		//Bring all the cheques to print
		$supresult = $this->DailyModel->supReports();	
		$total = $this->DailyModel->ptotal();
	
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
	
		$pdf->SetFont('helvetica', '', 8);

		// -----------------------------------------------------------------------------
	 if(1)
	 {		
		$text = '<div style="text-align:center;font-size:20;">Supplier Based Report</div>
			<div style="text-align: center;">
				Date: '.date('Y-m-d H:i').'
			</div>
		';
		$pdf->writeHTML($text, true, false, true, false, '');
		
		$tbl = '';
		$tbl .= '
			<table cellspacing="1" cellpadding="1" border="1" style="width:100%">
				<tr>
					<td colspan="3" align="center" style="font-weight:bold;background-color: #d3d3d3;">Supplier\'s Based Report</td>
				</tr>
				<tr>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;">ROW</td>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;">Supplier</td>
					<td align="center" style="font-weight:bold;background-color: #d3d3d3;">Amount</td>
				</tr>';
			$i=1;	
			foreach($supresult AS $result)
			{			
			$tbl .='<tr>
					<td align="center">'.$i.'</td>
					<td align="center">'.getdbc($result->supplier).'</td>
					<td align="center">RM '.number_format($result->gamount).'</td>
				</tr>
				';
				$i++;
			}	
			$tbl .='
				<tr>
					<td colspan="2" align="center" style="font-weight:bold;">Total</td>
					<td align="center" style="font-weight:bold;" colspan="1">RM '.number_format($total->totalAmount, 2).'</td>

				</tr>';
			$tbl .='</table>';
			$pdf->writeHTML($tbl, true, false, false, false, '');
		}		

		// -----------------------------------------------------------------------------
		$pdf->Output('Supplier-based-reports-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
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
