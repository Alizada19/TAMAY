<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Dbcsearch extends BaseController
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
		$type = $request->getPost('type'); 
		if($type!='')
		{
			$result = $this->DailyModel->searchbytype($type);
			$dbcTotal = $this->DailyModel->dbctypeTotal($type);
		}
		else
		{		
			$result = $this->DailyModel->balanceMainList();
			$dbcTotal = $this->DailyModel->dbcTotal();
		}
		$data['result'] = $result; 
		$data['dbcTotal'] = $dbcTotal; 
		$data['type'] = $type; 
		return view('cdbtors/searchBytype', $data); 
		
		
    }
}
