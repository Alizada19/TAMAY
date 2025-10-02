<?php

namespace App\Controllers;
use App\Models\DailyModel;
use CodeIgniter\I18n\Time;
class Charts extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		//$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index(): string
    {
		$pChequeCharts = $this->DailyModel->pChequesChart();
		//echo "<pre />"; print_r($pChequeCharts); exit;
		$aweek = array(
			 $date = date("Y-m-d"), 
			 date("Y-m-d", strtotime("+1 days")), 
			 date("Y-m-d", strtotime("+2 days")), 
			 date("Y-m-d", strtotime("+3 days")), 
			 date("Y-m-d", strtotime("+4 days")), 
			 date("Y-m-d", strtotime("+5 days")), 
			 date("Y-m-d", strtotime("+6 days")),
			 date("Y-m-d", strtotime("+7 days")),
			 date("Y-m-d", strtotime("+8 days")),
			 date("Y-m-d", strtotime("+9 days")),
		);	
		//$a='2024-09-17';
		//echo date('l', strtotime($a)); exit;
		//echo in_array(104, $a); exit;
		/*$values=array();
		foreach($pChequeCharts AS $cheque)
		{
			if(in_array($cheque->dates, $aweek))
			{	
				 $values[]['date']=$cheque->dates."<pre />";
				 $values[]['amount'] = $cheque->tamount;
			}
		}*/	
		//echo "<pre />"; print_r($values); exit;
		$data['pChequeCharts'] = $pChequeCharts;
		$data['aweek'] = $aweek;
        return view('charts/home', $data);
    }
	
	
}
