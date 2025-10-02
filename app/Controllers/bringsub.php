<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Bringsub extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index($para=0)
    {	
		$data['para'] = $para;
        return view('bringsub/bringsub', $data);
    }
	
	public function add()
    { 
        
		$request = \Config\Services::request();
		
		$shop = $request->getPost('shname');
		$sdate = $request->getPost('sdate');
		$tsales = $request->getPost('tsales');
		$scard = $request->getPost('scard');
		$scash = $request->getPost('scash');
		$etype = $request->getPost('etype');
		$eamount = $request->getPost('eamount');
		$texpens = $request->getPost('texpens');
		$ncash = $request->getPost('ncash');
		$cname = $request->getPost('cname');
		$rname = $request->getPost('rname');
		$data = array(
			'shop'=>$shop,
			'sdate'=>$sdate,
			'tsales'=>$tsales,
			'scard'=>$scard,
			'scash'=>$scash,
			'etype'=>$etype,
			'eamount'=>$eamount,
			'texpens'=>$texpens,
			'ncash'=>$ncash,
			'cname'=>$cname,
			'rname'=>$rname,
          );
		
		$result = $this->DailyModel->add($data); 
		if($result == 1)
		{
			  //$this->session->setFlashdata('success', 'Your operation was successful.');
			 echo "Record Added Successfully"; exit;
		}
		else
		{
			echo "Record Not Added Successfully";
		}		
		$data = [
			'session' => $this->session,
		];	
		//Database 
		//$db = db_connect('default');
		return view('dailyforms/dailyform', $data);
    }
	
	//Bring the sub expenses for the update form only while adding
	public function bringUpdate($para=0)
    {	
		
		$data['para'] = $para;
        return view('bringsub/bringsub2', $data);
    }
	
	//Remove subrecord based on given id
	public function removesub($id=0)
    {	
			$res = $this->DailyModel->removesub($id); 
			return $res;
    }
}
