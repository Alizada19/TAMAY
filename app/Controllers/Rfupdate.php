<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Rfupdate extends BaseController
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
		//$this->session->close();
		//$this->session->destroy();
		//$this->session->remove('name');
		//echo $this->session->get('name'); exit;
        return view('dailyforms/dailyform', $data);
    }
	
	public function update($rid)
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
			'username'=>$username,
			'userid'=>$userid,
			"saveDate" => date('Y-m-d H:i:s')
          ); //echo "<pre />"; print_r($data); exit;
		//subtable
		 
		 $sub1 = $request->getPost('1sub'); 
		 $subh1 = $request->getPost('1subh'); 
		 $sub2 = $request->getPost('2sub'); 
		 $subh2 = $request->getPost('2subh'); 
		 $sub3 = $request->getPost('3sub'); 
		 $subh3 = $request->getPost('3subh'); 
		 $sub4 = $request->getPost('4sub'); 
		 $subh4 = $request->getPost('4subh'); 
		 $sub5 = $request->getPost('5sub'); 
		 $subh5 = $request->getPost('5subh'); 
		 $sub6 = $request->getPost('6sub'); 
		 $subh6 = $request->getPost('6subh'); 
		 $sub7 = $request->getPost('7sub'); 
		 $subh7 = $request->getPost('7subh'); 
		 $sub8 = $request->getPost('8sub'); 
		 $subh8 = $request->getPost('8subh'); 
		 
		//Update additional sub items
		 $updatesub1 = $request->getPost('1updatesub'); 
		 $updatesub2 = $request->getPost('2updatesub'); 
		 $updatesub3 = $request->getPost('3updatesub'); 
		 $updatesub4 = $request->getPost('4updatesub'); 
		 $updatesub5 = $request->getPost('5updatesub'); 
		 $updatesub6 = $request->getPost('6updatesub'); 
		 $updatesub7 = $request->getPost('7updatesub');
		 $updatesub8 = $request->getPost('8updatesub');
		
		$up = $this->DailyModel->updateRecord($data,$rid); 
		if($up !=0)
		{	
			//update sub1
			if(empty($sub1) ==1 OR !array_filter($sub1))
			{	
				//echo "empty"; exit;
			}
			else
			{	//echo "<pre />"; print_r($subh1); exit;
				$ca = array_combine($sub1, $subh1); 
				foreach ($ca as $v=>$i) 
				{
						$subData = array(
							"sub1" => $v,
							"allsubs" => 'sub1',
							'username'=>$username,
							'userid'=>$userid,
							"saveDate" => date('Y-m-d H:i:s')
						);
						$result = $this->DailyModel->updateSub2($subData, $i, 'sub1');
					
				}
			}		
			
			//update sub2
			if(empty($sub2) ==1 OR !array_filter($sub2))
			{	
				//echo "empty"; exit;
			}
			else
			{	//echo "dfa"; exit;
				$cb = array_combine($sub2, $subh2);
				foreach ($cb as $v=>$i) 
				{
					$subData2 = array(
						"sub2" => $v,
						"allsubs" => 'sub2',
						'username'=>$username,
						'userid'=>$userid,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub2 = $this->DailyModel->updateSub2($subData2, $i, 'sub2');
				}
			}
			
			//Update sub3
			if(empty($sub3) ==1 OR !array_filter($sub3))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				$ca = array_combine($sub3, $subh3);
				foreach ($ca as $v=>$i)
				{
					$subData3 = array(
						"sub3" => $v,
						"allsubs" => 'sub3',
						'username'=>$username,
						'userid'=>$userid,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub4 = $this->DailyModel->updateSub2($subData3, $i, 'sub3');
				}
			}
			
			//Update sub4
			if(empty($sub4) ==1 OR !array_filter($sub4))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				$ca = array_combine($sub4, $subh4);
				foreach ($ca as $v=>$i)
				{
					$subData4 = array(
						"sub4" => $v,
						"allsubs" => 'sub4',
						'username'=>$username,
						'userid'=>$userid,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub4 = $this->DailyModel->updateSub2($subData4, $i, 'sub4');
				}
			}
			
			//Update sub5
			if(empty($sub5) ==1 OR !array_filter($sub5))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				$ca = array_combine($sub5, $subh5);
				foreach ($ca as $v=>$i) 
				{
					$subData5 = array(
						"sub5" => $v,
						"allsubs" => 'sub5',
						'username'=>$username,
						'userid'=>$userid,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub5 = $this->DailyModel->updateSub2($subData5, $i, 'sub5');
				}
			}
			
			//Update sub6
			if(empty($sub6) ==1 OR !array_filter($sub6))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				$ca = array_combine($sub6, $subh6);
				foreach ($ca as $v=>$i) 
				{
					$subData6 = array(
						"sub6" => $v,
						"allsubs" => 'sub6',
						'username'=>$username,
						'userid'=>$userid,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub6 = $this->DailyModel->updateSub2($subData6, $i, 'sub6');
				}
			}
			
			//Update sub7
			if(empty($sub7) ==1 OR !array_filter($sub7))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				$ca = array_combine($sub7, $subh7);
				foreach ($ca as $v=>$i) 
				{
					$subData7 = array(
						"sub7" => $v,
						"allsubs" => 'sub7',
						'username'=>$username,
						'userid'=>$userid,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub7 = $this->DailyModel->updateSub2($subData7, $i, 'sub7');
				}
			}
			
			//Update sub8
			if(empty($sub8) ==1 OR !array_filter($sub8))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				$ca = array_combine($sub8, $subh8);
				foreach ($ca as $v=>$i) 
				{
					$subData8 = array(
						"sub8" => $v,
						"allsubs" => 'sub8',
						'username'=>$username,
						'userid'=>$userid,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub8 = $this->DailyModel->updateSub2($subData8, $i, 'sub8');
				}
			}
			//Insert aditional sub records into Database
			//add sub1
			if(empty($updatesub1) ==1 OR !array_filter($updatesub1))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($updatesub1 as $value) 
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
			if(empty($updatesub2) ==1 OR !array_filter($updatesub2))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($updatesub2 as $value2) 
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
			if(empty($updatesub3) ==1 OR !array_filter($updatesub3))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($updatesub3 as $value3) 
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
			if(empty($updatesub4) ==1 OR !array_filter($updatesub4))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($updatesub4 as $value4) 
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
			if(empty($updatesub5) ==1 OR !array_filter($updatesub5))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($updatesub5 as $value5) 
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
			if(empty($updatesub6) ==1 OR !array_filter($updatesub6))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($updatesub6 as $value6) 
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
			if(empty($updatesub7) ==1 OR !array_filter($updatesub7))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($updatesub7 as $value7) 
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
			
			//add sub8
			if(empty($updatesub8) ==1 OR !array_filter($updatesub8))
			{	
				//echo "empty"; exit;
			}
			else
			{	
				foreach ($updatesub8 as $value8) 
				{
					$subData8 = array(
						"rdid" => $rid,
						"sub8" => $value8,
						"allsubs" => 'sub8',
						'userid'=>$userid,
						'username'=>$username,
						"saveDate" => date('Y-m-d H:i:s')
					);
					$resultsub8 = $this->DailyModel->addsub($subData8);
				}
			}
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
	
}
