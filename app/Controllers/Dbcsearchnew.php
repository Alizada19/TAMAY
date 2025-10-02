<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Dbcsearchnew extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index(): string
    {   
        
		$data['result'] = $this->DailyModel->display();
		
		return view('reports/sreport', $data);
    }
	//Search
	public function search()
    {    
		$request = \Config\Services::request();		
		$type = $request->getGet('type'); 
		if($type!='')
		{
			$result = $this->DailyModel->searchbytypeNew($type);	//echo "<pre />"; print_r($result); exit;
			$dbcTotal = $this->DailyModel->dbctypeTotalNew($type);
		}
		else
		{		
			$result = $this->DailyModel->balanceMainList2();
			$dbcTotal = $this->DailyModel->balanceMainListTotal();
		}
		$data['result'] = $result; 
		$data['dbcTotal'] = $dbcTotal; 
		$data['type'] = $type; 
		return view('cdbtors/searchBytypeNew', $data); 
		
		
    }
}
