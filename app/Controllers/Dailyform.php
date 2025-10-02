<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Dailyform extends BaseController
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
		$data['shop'] = $this->session->get('shop'); 
		
		//$this->session->close();
		//$this->session->destroy();
		//$this->session->remove('name');
		//echo $this->session->get('name'); exit;
        return view('dailyforms/dailyform', $data);
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
		$texpens = $request->getPost('texpens');
		$ncash = $request->getPost('ncash');
		$cname = $request->getPost('cname');
		$rname = $request->getPost('rname');
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
			'shop'=>$shop,
			'sdate'=>$sdate,
			'tsales'=>$tsales,
			'scard'=>$scard,
			'scash'=>$scash,
			'etype'=>$etype,
			'texpens'=>$texpens,
			'ncash'=>$ncash,
			'cname'=>$cname,
			'rname'=>$rname,
			'userid'=>$userid,
			'username'=>$username,
			"saveDate" => date('Y-m-d H:i:s')
          );
		//subtable
		 
		 $sub1 = $request->getPost('1sub'); 
		 $sub2 = $request->getPost('2sub'); 
		 $sub3 = $request->getPost('3sub'); 
		 $sub4 = $request->getPost('4sub'); 
		 $sub5 = $request->getPost('5sub'); 
		 $sub6 = $request->getPost('6sub'); 
		 $sub7 = $request->getPost('7sub'); 
		 $sub8 = $request->getPost('8sub'); 
		 
		//Check if shop record inserted within 24 hours
		$db = \Config\Database::connect();
		$query = $db->query("SELECT shop FROM daily WHERE shop=$shop AND sdate = '$sdate'");
		$sameDay = $query->getNumRows();
		//Get username from the session 
		$userName=$this->session->get('name'); 

		if($sameDay<1)
		{	
			$rid = $this->DailyModel->add($data); 
			if($rid !=0)
			{	
				//add sub1
				if(empty($sub1) ==1 OR !array_filter($sub1))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub1 as $value) 
					{
						$subData = array(
							"rdid" => $rid,
							"sub1" => $value,
							"allsubs" => 'sub1',
							'userid'=>$userid,
							'username'=>$username,
							"saveDate" => date('Y-m-d H:i:s')
						);
						$result = $this->DailyModel->addsub($subData);
					}
				}		
				
				//add sub2
				if(empty($sub2) ==1 OR !array_filter($sub2))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub2 as $value2) 
					{
						$subData2 = array(
							"rdid" => $rid,
							"sub2" => $value2,
							"allsubs" => 'sub2',
							'userid'=>$userid,
							'username'=>$username,
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub2 = $this->DailyModel->addsub($subData2);
					}
				}
				
				//add sub3
				if(empty($sub3) ==1 OR !array_filter($sub3))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub3 as $value3) 
					{
						$subData3 = array(
							"rdid" => $rid,
							"sub3" => $value3,
							"allsubs" => 'sub3',
							'userid'=>$userid,
							'username'=>$username,
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub4 = $this->DailyModel->addsub($subData3);
					}
				}
				
				//add sub4
				if(empty($sub4) ==1 OR !array_filter($sub4))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub4 as $value4) 
					{
						$subData4 = array(
							"rdid" => $rid,
							"sub4" => $value4,
							"allsubs" => 'sub4',
							'userid'=>$userid,
							'username'=>$username,
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub4 = $this->DailyModel->addsub($subData4);
					}
				}
				
				//add sub5
				if(empty($sub5) ==1 OR !array_filter($sub5))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub5 as $value5) 
					{
						$subData5 = array(
							"rdid" => $rid,
							"sub5" => $value5,
							"allsubs" => 'sub5',
							'userid'=>$userid,
							'username'=>$username,
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub5 = $this->DailyModel->addsub($subData5);
					}
				}
				
				//add sub6
				if(empty($sub6) ==1 OR !array_filter($sub6))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub6 as $value6) 
					{
						$subData6 = array(
							"rdid" => $rid,
							"sub6" => $value6,
							"allsubs" => 'sub6',
							'userid'=>$userid,
							'username'=>$username,
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub6 = $this->DailyModel->addsub($subData6);
					}
				}
				
				//add sub7
				if(empty($sub7) ==1 OR !array_filter($sub7))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub7 as $value7) 
					{
						$subData7 = array(
							"rdid" => $rid,
							"sub7" => $value7,
							"allsubs" => 'sub7',
							'userid'=>$userid,
							'username'=>$username,
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub7 = $this->DailyModel->addsub($subData7);
					}
				}
				
				//Promoter
				if(empty($sub8) ==1 OR !array_filter($sub8))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub8 as $value8) 
					{
						$subData8 = array(
							"rdid" => $rid,
							"sub8" => $value8,
							"allsubs" => 'sub8',
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub8 = $this->DailyModel->addsub($subData8);
					}
				}
				
				//Hamid Advance
				/*if(empty($sub9) ==1 OR !array_filter($sub9))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub9 as $value9) 
					{
						$subData9 = array(
							"rdid" => $rid,
							"sub9" => $value9,
							"allsubs" => 'sub9',
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub9 = $this->DailyModel->addsub($subData9);
					}
				}
				
				//Voucher
				if(empty($sub10) ==1 OR !array_filter($sub10))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub10 as $value10) 
					{
						$subData10 = array(
							"rdid" => $rid,
							"sub10" => $value10,
							"allsubs" => 'sub10',
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub10 = $this->DailyModel->addsub($subData10);
					}
				}
				
				//Utilities
				if(empty($sub11) ==1 OR !array_filter($sub11))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub11 as $value11) 
					{
						$subData11 = array(
							"rdid" => $rid,
							"sub11" => $value11,
							"allsubs" => 'sub11',
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub11 = $this->DailyModel->addsub($subData11);
					}
				}
				
				//Sherin Asla
				if(empty($sub12) ==1 OR !array_filter($sub12))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub12 as $value12) 
					{
						$subData12 = array(
							"rdid" => $rid,
							"sub12" => $value12,
							"allsubs" => 'sub12',
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub12 = $this->DailyModel->addsub($subData12);
					}
				}
				
				//Other
				if(empty($sub13) ==1 OR !array_filter($sub13))
				{	
					//echo "empty"; exit;
				}
				else
				{	
					foreach ($sub13 as $value13) 
					{
						$subData13 = array(
							"rdid" => $rid,
							"sub13" => $value13,
							"allsubs" => 'sub13',
							"saveDate" => date('Y-m-d H:i:s')
						);
						$resultsub13 = $this->DailyModel->addsub($subData13);
					}
				} */
				//echo $this->session->get('name'); exit;
				//echo "<pre />"; print_r($sub1); exit;
				 //redirect and display data
				 //$this->session->setFlashdata('success', 'Your operation was successful.');
				 return redirect()->to(base_url('codeigniter/public/dailyformview/'.$rid.'/1'.'')); exit;
				 //return view('dailyforms/dailyformview', $data);
			}
			else
			{
				echo "Record Not Added Successfully";
			}		
			$data = [
				'session' => $this->session,
			];	
		}
		else
		{
			echo "You can not insert report of same date twoice!";
		}		
    }
	
	//Daily form view
	public function view($rid,$suc)
    { 
		 
		 $db = \Config\Database::connect();
		 $builder = $db->table('daily');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();
		 
		 
		 //Get sub1 records
		 $qsub1 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub1'");
		 $bsub1 = $qsub1->getResult();
		 //echo  $db->getLastQuery(); exit;
		 
		 //Get sub2 records
		 $qsub2 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub2'");
		 $bsub2 = $qsub2->getResult();
		 
		 //Get sub3 records
		 $qsub3 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub3'");
		 $bsub3 = $qsub3->getResult();
		 
		 //Get sub4 records
		 $qsub4 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub4'");
		 $bsub4 = $qsub4->getResult();
		 
		 //Get sub5 records
		 $qsub5 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub5'");
		 $bsub5 = $qsub5->getResult();
		 
		 //Get sub6 records
		 $qsub6 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub6'");
		 $bsub6 = $qsub6->getResult();
		 
		 //Get sub7 records
		 $qsub7 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub7'");
		 $bsub7 = $qsub7->getResult();
		 
		 //Get sub8 records
		 $qsub8 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub8'");
		 $bsub8 = $qsub8->getResult();
		 
		 //Get sub9 records
		 $qsub9 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub9'");
		 $bsub9 = $qsub9->getResult();
		 
		  //Get sub10 records
		 $qsub10 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub10'");
		 $bsub10 = $qsub10->getResult();
		 
		 //Get sub11 records
		 $qsub11 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub11'");
		 $bsub11 = $qsub11->getResult();
		 
		 //Get sub12 records
		 $qsub12 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub12'");
		 $bsub12 = $qsub12->getResult();
		 
		 //Get sub13 records
		 $qsub13 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub13'");
		 $bsub13 = $qsub13->getResult();
		 $data['username']=$this->session->get('name'); 
		 //echo  $db->getLastQuery(); exit;
		// echo "<pre />"; print_r($bsub1); exit;
		 $data['sub1'] =  $bsub1;
		 $data['sub2'] =  $bsub2;
		 $data['sub3'] =  $bsub3;
		 $data['sub4'] =  $bsub4;
		 $data['sub5'] =  $bsub5;
		 $data['sub6'] =  $bsub6;
		 $data['sub7'] =  $bsub7;
		 $data['sub8'] =  $bsub8;
		 $data['sub9'] =  $bsub9;
		 $data['sub10'] =  $bsub10;
		 $data['sub11'] =  $bsub11;
		 $data['sub12'] =  $bsub12;
		 $data['sub13'] =  $bsub13;
		 $data['success'] = $suc;
		 $data['query'] = $query;
		return view('dailyforms/dailyformview', $data);
	}
	
	//Daily form update
	public function update($rid)
    {    
		 $db = \Config\Database::connect();
		 $builder = $db->table('daily');
		 $query = $builder->getWhere(['Id' => $rid]);
		 $query = $query->getRow();
		 
		 $data['sname'] = $this->session->get('name'); 
		 //Get sub1 records
		 $qsub1 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub1'");
		 $bsub1 = $qsub1->getResult();
		 //echo  $db->getLastQuery(); exit;
		 
		 //Get sub2 records
		 $qsub2 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub2'");
		 $bsub2 = $qsub2->getResult();
		 
		 //Get sub3 records
		 $qsub3 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub3'");
		 $bsub3 = $qsub3->getResult();
		 
		 //Get sub4 records
		 $qsub4 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub4'");
		 $bsub4 = $qsub4->getResult();
		 
		 //Get sub5 records
		 $qsub5 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub5'");
		 $bsub5 = $qsub5->getResult();
		 
		 //Get sub6 records
		 $qsub6 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub6'");
		 $bsub6 = $qsub6->getResult();
		 
		 //Get sub7 records
		 $qsub7 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub7'");
		 $bsub7 = $qsub7->getResult();
		 
		 //Get sub8 records
		 $qsub8 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub8'");
		 $bsub8 = $qsub8->getResult();
		 
		 //Get sub9 records
		 /*$qsub9 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub9'");
		 $bsub9 = $qsub9->getResult();
		 
		  //Get sub10 records
		 $qsub10 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub10'");
		 $bsub10 = $qsub10->getResult();
		 
		 //Get sub11 records
		 $qsub11 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub11'");
		 $bsub11 = $qsub11->getResult();
		 
		 //Get sub12 records
		 $qsub12 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub12'");
		 $bsub12 = $qsub12->getResult();
		 
		 //Get sub13 records
		 $qsub13 = $db->query("SELECT * FROM exsub WHERE rdid=$rid AND allsubs='sub13'");
		 $bsub13 = $qsub13->getResult(); */
		 
		 //echo  $db->getLastQuery(); exit;
		// echo "<pre />"; print_r($bsub1); exit;
		 $data['sub1'] =  $bsub1;
		 $data['sub2'] =  $bsub2;
		 $data['sub3'] =  $bsub3;
		 $data['sub4'] =  $bsub4;
		 $data['sub5'] =  $bsub5;
		 $data['sub6'] =  $bsub6;
		 $data['sub7'] =  $bsub7;
		 $data['sub8'] =  $bsub8;
		 /*$data['sub9'] =  $bsub9;
		 $data['sub10'] =  $bsub10;
		 $data['sub11'] =  $bsub11;
		 $data['sub12'] =  $bsub12;
		 $data['sub13'] =  $bsub13;*/
		 $data['Id'] = $rid;
		 $data['success'] = 0;
		 $data['query'] = $query;
		return view('dailyforms/dailyformupdate', $data);
	}
	
	//Update Daily form into Database
	public function updated()
    { 
		echo "dfa"; exit;
		$request = \Config\Services::request();
		
		$shop = $request->getPost('shname');
		$sdate = $request->getPost('sdate');
		$tsales = $request->getPost('tsales');
		$scard = $request->getPost('scard');
		$scash = $request->getPost('scash');
		$etype = $request->getPost('etype');
		$texpens = $request->getPost('texpens');
		$ncash = $request->getPost('ncash');
		$cname = $request->getPost('cname');
		$rname = $request->getPost('rname');
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
			'shop'=>$shop,
			'sdate'=>$sdate,
			'tsales'=>$tsales,
			'scard'=>$scard,
			'scash'=>$scash,
			'etype'=>$etype,
			'texpens'=>$texpens,
			'ncash'=>$ncash,
			'cname'=>$cname,
			'rname'=>$rname,
			'userid'=>$userid,
			'username'=>$username,
			"saveDate" => date('Y-m-d H:i:s')
          );
		//subtable
		 
		 $sub1 = $request->getPost('1sub'); 
		 $sub2 = $request->getPost('2sub'); 
		 $sub3 = $request->getPost('3sub'); 
		 $sub4 = $request->getPost('4sub'); 
		 $sub5 = $request->getPost('5sub'); 
		 $sub6 = $request->getPost('6sub'); 
		 $sub7 = $request->getPost('7sub'); 
		 $sub8 = $request->getPost('8sub'); 
		 /*$sub9 = $request->getPost('9sub'); 
		 $sub10 = $request->getPost('10sub'); 
		 $sub11 = $request->getPost('11sub'); 
		 $sub12 = $request->getPost('12sub'); 
		 $sub13 = $request->getPost('13sub');*/ 
		
	 
		
		$rid = $this->DailyModel->add($data); 
		if($rid !=0)
		{	
			//update sub1
			if(empty($sub1) ==1 OR !array_filter($sub1))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub1 as $value) 
				{
					$subData = array(
						"rdid" => $rid,
						"sub1" => $value,
						"allsubs" => 'sub1',
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$result = $this->DailyModel->addsub($subData);
				}
			}		
			
			//update sub2
			if(empty($sub2) ==1 OR !array_filter($sub2))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub2 as $value2) 
				{
					$subData2 = array(
						"rdid" => $rid,
						"sub2" => $value2,
						"allsubs" => 'sub2',
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub2 = $this->DailyModel->addsub($subData2);
				}
			}
			
			//update sub3
			if(empty($sub3) ==1 OR !array_filter($sub3))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub3 as $value3) 
				{
					$subData3 = array(
						"rdid" => $rid,
						"sub3" => $value3,
						"allsubs" => 'sub3',
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub4 = $this->DailyModel->addsub($subData3);
				}
			}
			
			//update sub4
			if(empty($sub4) ==1 OR !array_filter($sub4))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub4 as $value4) 
				{
					$subData4 = array(
						"rdid" => $rid,
						"sub4" => $value4,
						"allsubs" => 'sub4',
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub4 = $this->DailyModel->addsub($subData4);
				}
			}
			
			//update sub5
			if(empty($sub5) ==1 OR !array_filter($sub5))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub5 as $value5) 
				{
					$subData5 = array(
						"rdid" => $rid,
						"sub5" => $value5,
						"allsubs" => 'sub5',
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub5 = $this->DailyModel->addsub($subData5);
				}
			}
			
			//update sub6
			if(empty($sub6) ==1 OR !array_filter($sub6))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub6 as $value6) 
				{
					$subData6 = array(
						"rdid" => $rid,
						"sub6" => $value6,
						"allsubs" => 'sub6',
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub6 = $this->DailyModel->addsub($subData6);
				}
			}
			
			//update sub7
			if(empty($sub7) ==1 OR !array_filter($sub7))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub7 as $value7) 
				{
					$subData7 = array(
						"rdid" => $rid,
						"sub7" => $value7,
						"allsubs" => 'sub7',
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub7 = $this->DailyModel->addsub($subData7);
				}
			}
			
			//promoter
			if(empty($sub8) ==1 OR !array_filter($sub8))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub8 as $value8) 
				{
					$subData8 = array(
						"rdid" => $rid,
						"sub8" => $value8,
						"allsubs" => 'sub8',
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub8 = $this->DailyModel->addsub($subData8);
				}
			}
			
			//Hamid Advance
			/*if(empty($sub9) ==1 OR !array_filter($sub9))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub9 as $value9) 
				{
					$subData9 = array(
						"rdid" => $rid,
						"sub9" => $value9,
						"allsubs" => 'sub9',
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub9 = $this->DailyModel->addsub($subData9);
				}
			}
			
			//Voucher
			if(empty($sub10) ==1 OR !array_filter($sub10))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub10 as $value10) 
				{
					$subData10 = array(
						"rdid" => $rid,
						"sub10" => $value10,
						"allsubs" => 'sub10',
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub10 = $this->DailyModel->addsub($subData10);
				}
			}
			
			//Utilities
			if(empty($sub11) ==1 OR !array_filter($sub11))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub11 as $value11) 
				{
					$subData11 = array(
						"rdid" => $rid,
						"sub11" => $value11,
						"allsubs" => 'sub11',
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub11 = $this->DailyModel->addsub($subData11);
				}
			}
			
			//Sherin Asla
			if(empty($sub12) ==1 OR !array_filter($sub12))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub12 as $value12) 
				{
					$subData12 = array(
						"rdid" => $rid,
						"sub12" => $value12,
						"allsubs" => 'sub12',
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub12 = $this->DailyModel->addsub($subData12);
				}
			}
			
			//Other
			if(empty($sub13) ==1 OR !array_filter($sub13))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($sub13 as $value13) 
				{
					$subData13 = array(
						"rdid" => $rid,
						"sub13" => $value13,
						"allsubs" => 'sub13',
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub13 = $this->DailyModel->addsub($subData13);
				}
			} */
			//echo $this->session->get('name'); exit;
			//echo "<pre />"; print_r($sub1); exit;
			 //redirect and display data
			 //$this->session->setFlashdata('success', 'Your operation was successful.');
			 return redirect()->to(base_url('codeigniter/public/dailyformview/'.$rid.'/1'.'')); exit;
			 //return view('dailyforms/dailyformview', $data);
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
		//return view('dailyforms/dailyform', $data);
    }
	
	//Daily form list
	public function list(): string
    {	
		$result = $this->DailyModel->dailyList();
		$total = $this->DailyModel->dailyListt();
		$data['sname'] = $this->session->get('name'); //echo "<pre />"; print_r($result); exit;
		$data['result'] = $result; 
		$data['total'] = $total; 
        return view('dailyforms/list', $data);
    }
}
