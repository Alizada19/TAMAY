<?php

namespace App\Controllers;
use App\Models\DailyModel;
use CodeIgniter\I18n\Time;
class Cdbtorsnew extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->DailyModel = new DailyModel();
        helper('fornames');
	}
	
	public function index(): string
    {	
		
		$pChequeCharts = $this->DailyModel->pChequesChart();
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
		$data['pChequeCharts'] = $pChequeCharts;
		$data['aweek'] = $aweek;
        return view('charts/home', $data);
    }
	
	//Invoice Add
	public function add()
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
			return view('cdbtors/add', $data);
	}
	//Save record into database	
	public function save()
	{
		$request = \Config\Services::request();
		
		$ddate = $request->getPost('ddate'); 
		$duedate = $request->getPost('duedate'); 
		$dinvNo = $request->getPost('dinvNo');
		$ddescrip = $request->getPost('ddescrip');
		$damount = $request->getPost('damount');
		$dbc = $request->getPost('dbc');
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
			
			$data = array(
				'ddate'=>$ddate,
				'duedate'=>$duedate,
				'dinvNo'=>$dinvNo,
				'ddescrip'=>$ddescrip,
				'damount'=>$damount,
				'dbc'=>$dbc,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			 //echo "<pre />"; print_r($data); exit;
			 $rid = $this->DailyModel->gadd($data, 'balancesheet'); 
			if($rid)
			{
				return redirect()->to(base_url('codeigniter/public/cdbtorsView/'.$rid.'/1'.'')); exit;
			}
	}	
	
	//View the selected records
	public function view($rid, $flag)
	{
			 //connect Database
			 $db = \Config\Database::connect();
			 
			 //Get username and id from the session
			 $username = $this->session->get('name');
			 $userid = $this->session->get('userid');
			
			 $builder = $db->table('balancesheet');
			 $query = $builder->getWhere(['Id' => $rid]);
			 $query = $query->getRow();
			 
			 $data['sname'] = $username;
			 $data['userid'] = $userid;
			 $data['query'] = $query;
			 $data['suc'] = $flag;
			
			 $data['str'] = '';
			 return view('cdbtors/view', $data);
	}
	
	//List
	public function list($dbc)
	{	 
			$result = $this->DailyModel->balanceList2($dbc);
			$total = $this->DailyModel->dbcSum2($dbc);
			foreach ($total as $item) {
				if (!empty($item['tamount'])) {
					$mergedArray['tamount'] = $item['tamount'];  // Merge tamount
				}
				if (!empty($item['damount'])) {
					$mergedArray['damount'] = $item['damount'];  // Merge damount
				}
			}			
			$data['result'] = $result; //echo "<pre />"; print_r($result); exit;
			$data['dbc'] = $dbc; 
			$data['total'] = $mergedArray;
			//Get post dated cheques
			$pdcresult = $this->DailyModel->postDateCheque($dbc);
			$pdcresultTotal = $this->DailyModel->postDateChequeTotal($dbc);
			$data['pdc'] = $pdcresult;
			$data['pdcTotal'] = $pdcresultTotal;
			return view('cdbtors/list2', $data);
	}
	
	//Add invoice payment
	public function addPay()
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
			return view('cdbtors/addPay', $data);
	}

	//Save invoice payment into database	
	public function savePay()
	{	
		$request = \Config\Services::request();
		
		$ddate = $request->getPost('ddate'); 
		$dinvNo = $request->getPost('dinvNo');
		$ddescrip = $request->getPost('ddescrip');
		$camount = $request->getPost('camount');
		$dbc = $request->getPost('dbc');
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
			
			$data = array(
				'ddate'=>$ddate,
				'dinvNo'=>$dinvNo,
				'ddescrip'=>$ddescrip,
				'camount'=>$camount,
				'dbc'=>$dbc,
				'paid'=>2,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			 //echo "<pre />"; print_r($data); exit;
			 $rid = $this->DailyModel->gadd($data, 'balancesheet'); 
			if($rid)
			{
				return redirect()->to(base_url('codeigniter/public/cdbtorsViewPay/'.$rid.'/1'.'')); exit;
			}
	}	
	
	//Main List
	public function mainList()
	{	
	
			$result = $this->DailyModel->balanceMainList2();
			$dbcTotal = $this->DailyModel->balanceMainListTotal();
			$data['result'] = $result; 
			$data['dbcTotal'] = $dbcTotal; 
			return view('cdbtors/mainList2', $data);
	}
	
	//Edit Invoice Add
	public function edit($rid)
	{		
			 //connect Database
			 $db = \Config\Database::connect();
			 
			 //Get username and id from the session
			 $username = $this->session->get('name');
			 $userid = $this->session->get('userid');
			
			 $builder = $db->table('balancesheet');
			 $query = $builder->getWhere(['Id' => $rid]);
			 $query = $query->getRow();
			 
			 $data['sname'] = $username;
			 $data['userid'] = $userid;
			 $data['query'] = $query;
			 //display Pay to creditors and debtors 
			 $dcquery = $db->query("SELECT * FROM debtorcreditor");
			 $dcquery = $dcquery->getResult();
			 $dcstr='';  
			 foreach($dcquery AS $dc)
			 {
				if($dc->Id == $query->dbc)
				{	
					$dcstr.='<option value="'.$dc->Id.'" selected>'.$dc->dcnames.'</option>';
				}
				else
				{
					$dcstr.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
				}		
			 }
			 $data['str'] = $dcstr;
			 return view('cdbtors/edit', $data);
	}
	
	//Update invoice add in to database	
	public function update($rid)
	{	
		$request = \Config\Services::request();
		
		$ddate = $request->getPost('ddate'); 
		$duedate = $request->getPost('duedate'); 
		$dinvNo = $request->getPost('dinvNo');
		$ddescrip = $request->getPost('ddescrip');
		$damount = $request->getPost('damount');
		$dbc = $request->getPost('dbc');
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
			
			$data = array(
				'ddate'=>$ddate,
				'duedate'=>$duedate,
				'dinvNo'=>$dinvNo,
				'ddescrip'=>$ddescrip,
				'damount'=>$damount,
				'dbc'=>$dbc,
				'paid'=>1,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			 //echo "<pre />"; print_r($data); exit;
			$res = $this->DailyModel->gupdate($data, $rid, 'balancesheet');
			if($res)
			{
				return redirect()->to(base_url('codeigniter/public/cdbtorsView/'.$rid.'/1'.'')); exit;
			}
	}
	
	//Edit Invoice Pay
	public function editPay($rid)
	{		
			 //connect Database
			 $db = \Config\Database::connect();
			 
			 //Get username and id from the session
			 $username = $this->session->get('name');
			 $userid = $this->session->get('userid');
			
			 $builder = $db->table('balancesheet');
			 $query = $builder->getWhere(['Id' => $rid]);
			 $query = $query->getRow();
			 
			 $data['sname'] = $username;
			 $data['userid'] = $userid;
			 $data['query'] = $query;
			 //display Pay to creditors and debtors 
			 $dcquery = $db->query("SELECT * FROM debtorcreditor");
			 $dcquery = $dcquery->getResult();
			 $dcstr='';  
			 foreach($dcquery AS $dc)
			 {
				if($dc->Id == $query->dbc)
				{	
					$dcstr.='<option value="'.$dc->Id.'" selected>'.$dc->dcnames.'</option>';
				}
				else
				{
					$dcstr.='<option value="'.$dc->Id.'">'.$dc->dcnames.'</option>';
				}		
			 }
			 $data['str'] = $dcstr;
			 return view('cdbtors/editPay', $data);
	}
	
	//Update invoice pay into database	
	public function updatePay($rid)
	{	
		$request = \Config\Services::request();
		
		$ddate = $request->getPost('ddate'); 
		$dinvNo = $request->getPost('dinvNo');
		$ddescrip = $request->getPost('ddescrip');
		$camount = $request->getPost('camount');
		$dbc = $request->getPost('dbc');
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
			
			$data = array(
				'ddate'=>$ddate,
				'dinvNo'=>$dinvNo,
				'ddescrip'=>$ddescrip,
				'camount'=>$camount,
				'dbc'=>$dbc,
				'paid'=>2,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );
			 //echo "<pre />"; print_r($data); exit;
			$res = $this->DailyModel->gupdate($data, $rid, 'balancesheet');
			if($res)
			{
				return redirect()->to(base_url('codeigniter/public/cdbtorsViewPay/'.$rid.'/2'.'')); exit;
			}
	}
	
	//View the payment invoice
	public function viewPay($rid, $flag)
	{
			 //connect Database
			 $db = \Config\Database::connect();
			 
			 //Get username and id from the session
			 $username = $this->session->get('name');
			 $userid = $this->session->get('userid');
			
			 $builder = $db->table('balancesheet');
			 $query = $builder->getWhere(['Id' => $rid]);
			 $query = $query->getRow();
			 
			 $data['sname'] = $username;
			 $data['userid'] = $userid;
			 $data['query'] = $query;
			 $data['suc'] = $flag;
			
			 $data['str'] = '';
			 return view('cdbtors/viewPay', $data);
	}
}
