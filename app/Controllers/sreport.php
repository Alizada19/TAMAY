<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Sreport extends BaseController
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
	public function rsearch()
    {    
		$request = \Config\Services::request();		
		$sdate = $request->getPost('sdate');
		$edate = $request->getPost('edate');
		$slocation = $request->getPost('slocation');
		//echo "<pre />"; print_r($request); exit;
		//echo '<pre>';print_r($_POST);echo '</pre>';die;
		$data=array(
			'sdate' => $sdate,
			'edate' => $edate,
			'shop' => $slocation
		);
		$sname='';
		if($slocation == 20)
		{
					
			$data['tamay'] = $this->DailyModel->tamay($data);			
			$data['tamayTotal'] = $this->DailyModel->tamayTotal($data);			
			$data['bergayaTotal'] = $this->DailyModel->bergayaTotal($data);			
			$data['glsChocolate'] = $this->DailyModel->tamayChocolate($data);			
			$data['bergaya'] = $this->DailyModel->bergaya($data);			
			$data['eden'] = $this->DailyModel->eden($data);			
			$data['edensi'] = $this->DailyModel->edensi($data);			
			$data['js'] = $this->DailyModel->js($data);			
			$data['edensw'] = $this->DailyModel->edensw($data);			
			$data['edenjo'] = $this->DailyModel->edenjo($data);				
			$data['edenjo2'] = $this->DailyModel->edenjo2($data);		
			$data['edena'] = $this->DailyModel->edena($data);			
			$data['allshops'] = $this->DailyModel->allshops($data);

			$data['sdate'] = $sdate;
			$data['edate'] = $edate;
			$data['loc'] = $slocation;
			return view('reports/allshops', $data);
		}
		else if($slocation == 21)
		{
			
			//Get sales report day by day
			//1. ESI
			$resultEsi = $this->DailyModel->dailySales($sdate, $edate, '3');
			//2. ESW
			$resultEsw = $this->DailyModel->dailySales($sdate, $edate, '4');
			//3. Johoni-q
			$resultJohoniq = $this->DailyModel->dailySales($sdate, $edate, '5');
			//4. E66a
			$resultE66a = $this->DailyModel->dailySales($sdate, $edate, '6');
			//5. GLC
			$resultGlc = $this->DailyModel->dailySales($sdate, $edate, '2');
			//All shops
			$data['allshops'] = $this->DailyModel->allshops($data);
			//All Eden shops by given date ranges
			$data['eden'] = $this->DailyModel->eden($data);
			//sum of esi shop
			$data['sesi'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '3'); //echo "<pre />"; print_r($glcsum); exit;
			//sum of esw shop
			$data['sesw'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '4'); //echo "<pre />"; print_r($glcsum); exit;
			//sum of johoni-q shop
			$data['sjohoniq'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '5'); //echo "<pre />"; print_r($glcsum); exit;
			//sum of se66a shop
			$data['se66a'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '6'); //echo "<pre />"; print_r($glcsum); exit;
			//sum of glc shop
			$data['glcsum'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '2'); //echo "<pre />"; print_r($glcsum); exit;
			$data['resultEsi'] = $resultEsi;
			$data['resultEsw'] = $resultEsw;
			$data['resultJohoniq'] = $resultJohoniq;
			$data['resultE66a'] = $resultE66a;
			$data['resultGlc'] = $resultGlc;
			$data['loc'] = $slocation;
			return view('reports/allshopsBydates', $data);
		}
		else if($slocation == 22)
		{
			//Get sales report day by day
			//1. ESI
			$resultEsi = $this->DailyModel->expensesType($sdate, $edate, '3'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of esi shop
			$data['sesi'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '3');
			//2. ESW
			$data['resultEsw'] = $this->DailyModel->expensesType($sdate, $edate, '4'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of esw shop
			$data['sesw'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '4');
			//3. Johoni-q
			$data['johoniq'] = $this->DailyModel->expensesType($sdate, $edate, '5'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of JOHONIQ shop
			$data['sjohoni'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '5');
			//4. 66A
			$data['r66a'] = $this->DailyModel->expensesType($sdate, $edate, '6'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of 66A shop
			$data['s66a'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '6');
			
			//5. glc
			$data['glc'] = $this->DailyModel->expensesType($sdate, $edate, '2'); //echo "<pre />"; print_r($resultEsi); exit;
			//sum of glc shop
			$data['sglc'] = $this->DailyModel->sumofgivenshops($sdate, $edate, '2');
			
			$data['resultEsi']=$resultEsi;
			$data['sdate']=$sdate;
			$data['edate']=$edate; 
			$data['loc'] = $slocation;
			return view('reports/allshopsByexpenses', $data);
		}
		else if($slocation == 23)
		{   	//echo "<pre />"; print_r($data); exit;
				$data['result'] = $this->DailyModel->getInvestment($data); 
				$data['total'] = $this->DailyModel->getInvestmentTotal($data); 
				return view('reports/investment', $data);
		}		
		else
		{		
			$data['sdate'] = $sdate;
			$data['edate'] = $edate;
			$data['sname'] = $slocation;
			$data['result'] = $this->DailyModel->displaysearch($data); 
			return view('reports/displayreport', $data); 
		}
		
    }
}
