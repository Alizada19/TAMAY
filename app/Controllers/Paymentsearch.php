<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Paymentsearch extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		//$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index(): string
    {
		
		$request = \Config\Services::request();			
		$sdate = $request->getPost('sdate');
		$edate = $request->getPost('edate');
		$status = $request->getPost('status');
		$cno = $request->getPost('cno');
						
		
		$data = array(
			'sdate'=>$sdate,
			'edate'=>$edate,
			'status'=>$status,
			'cno'=>$cno
		  );
		 
		//Bring all the cheques
		$chequeresult = $this->DailyModel->chequesearch($data);		
		$chequetotal = $this->DailyModel->chequesearcht($data);		//echo $chequetotal->totalAmount; exit;
		$data['chequeresult'] = $chequeresult;
		$data['chequetotal'] = $chequetotal;
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['status'] = $status;
        return view('payments/bchequesearch', $data);
    }
	//Search date specefied OTS
	public function searchot(): string
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
		
		//Bring all the OTS/Cash
		$otresult = $this->DailyModel->otsearch($data);		
		$ottotal = $this->DailyModel->otsearchtTotal($data);	
		$data['otresult'] = $otresult;
		$data['ottotal'] = $ottotal;
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;  
		$data['status'] = $status; 
		$data['nsdate'] = $nsdate;
		$data['nedate'] = $nedate;	
		$data['invNo'] = $invNo;	
		$data['creditor'] = $creditor;	
        return view('reports/searchot', $data);
    }
	
	//All Payment Search
	public function allReportSearch(): string
    {
		
		$request = \Config\Services::request();			
		$sdate = $request->getPost('sdate');
		$edate = $request->getPost('edate');
		
					
		
		$data = array(
			'sdate'=>$sdate,
			'edate'=>$edate,
		  );
	
		//Bring all the OTS/Cash
		$otresult = $this->DailyModel->otsearch($data);		
		$ottotal = $this->DailyModel->otsearchtTotal($data);	
		$data['otresult'] = $otresult;
		$data['ottotal'] = $ottotal;
		$data['sdate'] = $sdate;
		$data['edate'] = $edate;  
        return view('reports/searchot', $data);
    } 
	
	//All Payment Search sub
	public function allReportSearchSub()
    {
		
		$request = \Config\Services::request();			
		$sdate = $request->getGet('sdate');
		$edate = $request->getGet('edate');
		$status = $request->getGet('status');
		$nsdate = $request->getGet('nsdate');
		$nedate = $request->getGet('nedate');
		$invNo = $request->getGet('invNo');
		$creditor = $request->getGet('creditor');
		$cno = $request->getGet('cno');	
		$type = $request->getGet('type');	
		
		//Search and show result based on date
		if($status == 'byDate')
		{
				
				$data = array(
					'sdate'=>$sdate,
					'edate'=>$edate
				  ); 
				//Get dates between two ranges  
				$dates = $this->displayDates($sdate, $edate);   //echo "<pre />"; print_r($dates); exit;
				//Bring records by Date
				$allresult = $this->DailyModel->searchAmountBydate($data); //echo "<pre />"; print_r($allresult); exit;	
				$total = $this->DailyModel->totalsearchBydate($data);
				$data['allresult'] = $allresult; 
				//$data['alltotal'] = $alltotal;
				$data['sdate'] = $sdate;  
				$data['edate'] = $edate;   
				$data['total'] = $total;   
				return view('bydate/home', $data);
		}
		else
		{		
					
			$data = array(
				'sdate'=>$sdate,
				'edate'=>$edate,
				'status'=>$status,
				'nsdate'=>$nsdate,
				'nedate'=>$nedate,
				'invNo'=>$invNo,
				'creditor'=>$creditor,
				'cno'=>$cno,
				'type'=>$type
			  );
			
			//Bring all the OTS/Cash
			$allresult = $this->DailyModel->allReportSearch($data);		
			$alltotal = $this->DailyModel->allReportSearchTotal($data);	
			$data['allresult'] = $allresult;
			$data['alltotal'] = $alltotal;
			$data['sdate'] = $sdate;  
			$data['edate'] = $edate; 
			$data['nsdate'] = $nsdate;
			$data['nedate'] = $nedate;	
			$data['invNo'] = $invNo;	
			$data['creditor'] = $creditor;	
			$data['cno'] = $cno;	
			$data['type'] = $type;
			return view('reports/paymentReputSubSearch', $data);
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
