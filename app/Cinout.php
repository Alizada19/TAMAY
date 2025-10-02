<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Cinout extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		//$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index(): string
    {
		
		$data['sname'] = $this->session->get('name'); 
		$shop = $this->session->get('shop'); 
		$data['dvalue'] = 2; 
		//Bring today's inout 
		$str = '';
		if($shop !='')
		{	
			//Check my role
			$myrole = $this->session->get('myRole');
			$shops = array(
				'1'=>'B&S',
				'2'=>'GILASCO',
				'3'=>'ESI',
				'4'=>'ESW',
				'5'=>'JOHONI-Q',
				'6'=>'E66A',
				'10'=>'ME Perfume'
				 );
			if($myrole == 1)
			{
				  
				 foreach($shops AS $key=>$value)
				 {
					if($key == $shop)
					{	
						$str.='<option value="'.$key.'" selected>'.$value.'</option>';
					}
					else
					{
						$str.='<option value="'.$key.'">'.$value.'</option>';
					}		
				 }
			}
			else
			{		
				foreach($shops AS $key=>$value)
				 {
					if($key == $shop)
					{	
						$str.='<option value="'.$key.'" selected>'.$value.'</option>';
					}		
				 }			
			}
			$cdate = date('Y-m-d');	
			$res2 = $this->DailyModel->todayrecords($shop, $cdate);
			$total = $this->DailyModel->totalrecordsoftoday($shop, $cdate); 
			$percentage = '';
			if($total->customers)
			{	
				$percentage = round($total->purchased / $total->customers * 100); 
			}
			
		}
		else
		{
			$res2 = '';
			$total = 0;
			$percentage='';
		}		
		
		//echo "<pre />"; print_r($total); exit;
		$data['res2'] = $res2;
		$data['total'] = $total;
		$data['percentage'] = $percentage;
		$data['str'] = $str;
		return view('cinout/home', $data);
		
    }
	
	public function save()
    { 
        
		$request = \Config\Services::request();
		$shop = $request->getPost('shop');
		
		
		$cin = $request->getPost('cin');
				
		$pur = $request->getPost('parchase');
		$lf = $request->getPost('lf');
		$remark = $request->getPost('remark');
		$purchase =0;
		$purchasenot =0;
		if($pur == 1)
		{		
			$purchase = 1;
		}
		else
		{
			$purchasenot = 1; 
		}
		$local=0;
		$foreigner=0;
		if($lf == 1)
		{		
			$local = 1;
		}
		else
		{
			$foreigner = 1; 
		}		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
			'shop'=>$shop,
			'cin'=>$cin,
			'purchase'=>$purchase,
			'purchasenot'=>$purchasenot,
			'local'=>$local,
			'foreigner'=>$foreigner,
			'remark'=>$remark,
			'userid'=>$userid,
			'username'=>$username,
			"saveDate" => date('Y-m-d H:i:s')
          );
		//echo "<pre />"; print_r($data); exit;
		//Add data
		$res = $this->DailyModel->savedc($data, 'cinout');
		if($res)
		{
			
			//Check my role
			$str = '';
			$myrole = $this->session->get('myRole');
			$shops = array(
				'1'=>'B&S',
				'2'=>'GILASCO',
				'3'=>'ESI',
				'4'=>'ESW',
				'5'=>'JOHONI-Q',
				'6'=>'E66A',
				'10'=>'ME Perfume'
				 );
			if($myrole == 1)
			{
				  
				 foreach($shops AS $key=>$value)
				 {
					if($key == $shop)
					{	
						$str.='<option value="'.$key.'" selected>'.$value.'</option>';
					}
					else
					{
						$str.='<option value="'.$key.'">'.$value.'</option>';
					}		
				 }
			}
			else
			{		
				foreach($shops AS $key=>$value)
				 {
					if($key == $shop)
					{	
						$str.='<option value="'.$key.'" selected>'.$value.'</option>';
					}		
				 }			
			}
			$cdate=date('Y-m-d'); 
			$res2 = $this->DailyModel->todayrecords($shop, $cdate);
			$total = $this->DailyModel->totalrecordsoftoday($shop, $cdate);
			$percentage = '';
			if($total->customers)
			{	
				$percentage = round($total->purchased / $total->customers * 100); 
			}
			$data['res2'] = $res2;
			$data['total'] = $total;
			$data['percentage'] = $percentage;
			$data['str'] = $str;
			return view('cinout/dailysub', $data);
		}		
		else
		{
			echo "Not inserted";
		}		
		
    }
	
}
