<?php

namespace App\Controllers;
use App\Models\DailyModel;
use CodeIgniter\I18n\Time;
class Byoneday extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		//$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index($sdate): string
    {
		
		//Bring all the Payments
		$presult = $this->DailyModel->givendatepayments($sdate);	
		$ptotal = $this->DailyModel->givenDateTotalPayments($sdate);
		$ctotal = $this->DailyModel->chequeTotalBydate($sdate);
		$cretotal = $this->DailyModel->creditorsTotal($sdate);
		$data['presult'] = $presult;
		$data['ptotal'] = $ptotal;
		$data['sdate'] = $sdate;
		$data['ctotal'] = $ctotal;
		$data['crtotal'] = $cretotal;
		
        return view('byoneday/home', $data);
    }
	
	
}
