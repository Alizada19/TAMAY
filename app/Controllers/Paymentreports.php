<?php

namespace App\Controllers;
use App\Models\DailyModel;

use TCPDF;  

class Paymentreports extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index(): string
    {   
		 
		$perPage = 2;
		$cpage = isset($_GET['page_no']) ? $_GET['page_no'] : 1;
		$offset=($cpage - 1) * $perPage;
		//$data['links'] = $pager->makeLinks($offset, $perPage, 7, 'default_full');
		//$data['links'] = 
		//for paginataion
		$data['PageNo'] = $cpage;
		$data['total_no_of_pages'] = ceil(7 / 6);
		//$chequeresult = $this->DailyModel->chequereports($perPage, $offset);
		//Bring all the cheques
		$chequeresult = $this->DailyModel->chequereports();				
		$chequetotal = $this->DailyModel->chequeTotal();		//echo $chequetotal->totalAmount; exit;
		$data['chequeresult'] = $chequeresult;
		$data['chequetotal'] = $chequetotal; 
		return view('reports/chequereports', $data);
    }
	
	//Online transfer / Cash reports
	public function ocash(): string
    {   
        
		//Bring all the the online transfer and cash reports
		$ocashresult = $this->DailyModel->ocashreports();
		$ottotal = $this->DailyModel->otTotal();

		//Bring the debtors and creditors
		 $db = \Config\Database::connect();
		 $dc = $db->query("SELECT * FROM debtorcreditor");
		 $dcres = $dc->getResult();
		 //echo "<pre />"; print_r($dcres); exit;
		 $str='';
		 foreach($dcres AS $dc)
		 {
			$str.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
		 }	 
		$data['str'] = $str;
		$data['ocashresult'] = $ocashresult; 
		$data['ottotal'] = $ottotal; 
		return view('reports/ocashreports', $data);
    }
   
	public function apayments()
    {   
        //Bring the debtors and creditors
		 $db = \Config\Database::connect();
		 $dc = $db->query("SELECT * FROM debtorcreditor");
		 $dcres = $dc->getResult();
		 //echo "<pre />"; print_r($dcres); exit;
		 $str='';
		 foreach($dcres AS $dc)
		 {
			$str.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
		 }	 
		$data['str'] = $str;
		//Bring all the cheques
		$presult = $this->DailyModel->apayments();	
		$ptotal = $this->DailyModel->ptotal();
		$data['presult'] = $presult;
		$data['ptotal'] = $ptotal;
		return view('reports/apaymentreports', $data);
    }
	
	//Unscheduled cash
	public function uncash(): string
    {   
        
		//Bring all the the unschedule  reports
		$uncashresult = $this->DailyModel->uncashreports();
		$untotal = $this->DailyModel->unTotal();	
		$data['uncashresult'] = $uncashresult; 
		$data['untotal'] = $untotal; 
		return view('reports/uncashreports', $data);
    }
	
	   
}
