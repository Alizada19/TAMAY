<?php

namespace App\Controllers;
use App\Models\DailyModel;

use TCPDF;  
class Printpdf extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index($rid): string
    {   
        
		 
		 $db = \Config\Database::connect();
		 
		 //Get Main Record
		 $builder = $db->table('daily');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();
		 
		 //Get sub1 records
		 $qsub1 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub1'");
		 $sub1 = $qsub1->getResult();
		 
		 //Get sub2 records
		 $qsub2 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub2'");
		 $sub2 = $qsub2->getResult();
		 
		 //Get sub3 records
		 $qsub3 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub3'");
		 $sub3 = $qsub3->getResult();
		 
		 //Get sub4 records
		 $qsub4 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub4'");
		 $sub4 = $qsub4->getResult();
		 
		 //Get sub5 records
		 $qsub5 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub5'");
		 $sub5 = $qsub5->getResult();
		 
		 //Get sub6 records
		 $qsub6 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub6'");
		 $sub6 = $qsub6->getResult();
		 
		 //Get sub7 records
		 $qsub7 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub7'");
		 $sub7 = $qsub7->getResult();
		 
		 //Get sub8 records
		 $qsub8 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub8'");
		 $sub8 = $qsub8->getResult();
		 
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

		// set font
		$pdf->SetFont('helvetica', 'B', 18);

		// add a page
		$pdf->AddPage('p','A4');

		$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', '', 18);

		// -----------------------------------------------------------------------------
	 if($query)
	 {		
		$tsales = $query->tsales; 
		$scard = number_format($query->scard, 2);
		$scash = number_format($query->scash, 2);
		$texpens = number_format($query->texpens, 2);
		$ncash = number_format($query->ncash, 2);
		$sname = bname($query->shop);
		
		$text = '<div style="text-align:center;font-size:20; font-weight:bold;">NIGHTLY SHOP REPORT</div>
				<div style="text-align: center;">
					DATE: '.date_format(date_create($query->sdate), 'd/m/Y').'
				</div>
			';
			$pdf->writeHTML($text, true, false, true, false, '');
		$tbl = '';
		$tbl .= '
			<table cellspacing="1" cellpadding="5" border="1">
				<tr>
					<td COLSPAN="4" align="center" style="font-weight:bold;background-color: #d3d3d3">'.$sname.' NIGHTLY SALES RECORD</td>
				</tr>
				<tr>
					<td COLSPAN="2">SHOP NAME:</td>
					<td COLSPAN="2">'.$sname.'</td>
				</tr>
				<tr>
					<td COLSPAN="2">DATE:</td>
					<td COLSPAN="2">'.date_format(date_create($query->sdate), 'd/m/Y').'</td>
				</tr>
				<tr>
					<td COLSPAN="2">TOTAL SALES:</td>
					<td COLSPAN="2">RM '.$tsales.'</td>
				</tr>
				<tr>
					<td COLSPAN="2">CARD:</td>
					<td COLSPAN="2">RM '.$scard.'</td>
				</tr>
				<tr>
					<td COLSPAN="2">CASH:</td>
					<td COLSPAN="2">RM '.$scash.'</td>
				</tr>
				<tr>
					<td style="" COLSPAN="4">EXPENSES</td>
				</tr>
		';
		if($sub1)
		{	
			$i=1;
			foreach($sub1 AS $subr)
			{
				$tbl.='		
					<tr>
						<td COLSPAN="2">'.$i.'. Target:</td>
						<td COLSPAN="2">RM '.number_format($subr->sub1).'</td>
					</tr>';
			 $i++;		
			}
		}
		if($sub2)
		{	
			$i=1;
			foreach($sub2 AS $subr)
			{
				$tbl.='		
					<tr>
						<td COLSPAN="2">'.$i.'. Commission:</td>
						<td COLSPAN="2">RM '.number_format($subr->sub2).'</td>
					</tr>';
				$i++;	
			}
		}
		if($sub3)
		{	
			$i=1;
			foreach($sub3 AS $subr)
			{
				$tbl.='		
					<tr>
						<td COLSPAN="2">'.$i.'. Transport:</td>
						<td COLSPAN="2">RM '.number_format($subr->sub3).'</td>
					</tr>';
				$i++;	
			}
		}
		if($sub4)
		{	
			$i=1;
			foreach($sub4 AS $subr)
			{
				$tbl.='		
					<tr>
						<td COLSPAN="2">'.$i.'. Voucher:</td>
						<td COLSPAN="2">RM '.number_format($subr->sub4).'</td>
					</tr>';
				$i++;	
			}
		}
		if($sub5)
		{	
			$i=1;
			foreach($sub5 AS $subr)
			{
				$tbl.='		
					<tr>
						<td COLSPAN="2">'.$i.'. Advance:</td>
						<td COLSPAN="2">RM '.number_format($subr->sub5).'</td>
					</tr>';
				$i++;	
			}
		}
		if($sub6)
		{	
			$i=1;
			foreach($sub6 AS $subr)
			{
				$tbl.='		
					<tr>
						<td COLSPAN="2">'.$i.'. Utility:</td>
						<td COLSPAN="2">RM '.number_format($subr->sub6).'</td>
					</tr>';
				$i++;	
			}
		}
		if($sub7)
		{	
			$i=1;
			foreach($sub7 AS $subr)
			{
				$tbl.='		
					<tr>
						<td COLSPAN="2">'.$i.'. Other:</td>
						<td COLSPAN="2">RM '.number_format($subr->sub7).'</td>
					</tr>';
				$i++;	
			}
		}	
		if($sub8)
		{	
			$i=1;
			foreach($sub8 AS $subr)
			{
				$tbl.='		
					<tr>
						<td COLSPAN="2">'.$i.'. Promoter:</td>
						<td COLSPAN="2">RM '.number_format($subr->sub8).'</td>
					</tr>';
				$i++;	
			}
		}
		$tbl.='	
			<tr>
				<td style="font-weight:bold;">TOTAL EXP:</td>
				<td style="font-weight:bold;">RM '.$texpens.'</td>
				<td style="font-weight:bold;">NET CASH:</td>
				<td style="font-weight:bold;">RM '.$ncash.'</td>
			</tr>
		</table>
		';
		
		}
		$pdf->writeHTML($tbl, true, false, false, false, '');

		// -----------------------------------------------------------------------------
		
		$tbl = '
		<table cellspacing="3" cellpadding="3" >
			<tr>
				<td>CASHIER:</td>
				<td>'.$query->cname.'</td>
				<td>Receiver:</td>
				<td>'.$query->rname.'</td>
			</tr>
			<tr>
				<td COLSPAN="2">SETTLEMENT:</td>
				<td COLSPAN="1">DONE</td>
			</tr>
		</table>
		';
		$pdf->writeHTML($tbl, true, false, false, false, '');

		// -----------------------------------------------------------------------------
		
		//header('Content-Type: application/pdf');
		//header('Content-Disposition: attachment; filename=nightlyReportPDF.pdf');
		//Close and output PDF document
		$pdf->Output('Nightly_Sales_Report-'.date('Y-m-d').'.pdf', 'I');
		
		
		echo APPPATH; exit;
		return view('printpdf/singleprint');
    }
	
}
