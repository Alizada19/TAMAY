<?php

namespace App\Controllers;
use App\Models\DailyModel;
class Debtorcreditor extends BaseController
{
    //my constructor
	public function __construct() {

        $this->DailyModel = new DailyModel();
		//$this->session = \Config\Services::session();
        helper('fornames');
	}
	
	public function index($def): string
    {
		$data['sname'] = $this->session->get('name'); 
		$data['dvalue'] = $def;
        return view('debtorcreditor/home', $data);
    }
	
	public function save()
    { 
        
		
		$request = \Config\Services::request();
		$dcname = $request->getPost('dcname');
		$pname = $request->getPost('pname');
		$type = $request->getPost('type');
		$addr = $request->getPost('addr');
		$phone = $request->getPost('phone');
		
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
			'dcnames'=>$dcname,
			'type'=>$type,
			'addr'=>$addr,
			'phone'=>$phone,
			'pname'=>$pname,
			'userid'=>$userid,
			'username'=>$username,
			"saveDate" => date('Y-m-d H:i:s')
          );
		//echo "<pre />"; print_r($data); exit;
		//Add data
		$rid = $this->DailyModel->gadd($data, 'debtorcreditor');
		if($rid)
		{		
			return redirect()->to(base_url('codeigniter/public/debtorcreditorView/'.$rid.'/1'));
		}
		else 
		{
			echo "You record is not saved successfully!";
		}		
		
    }
	//view
	public function view($id, $flag)
    {		
		$data['sname'] = $this->session->get('name'); 
		//Get all records
		$result = $this->DailyModel->gselect('debtorcreditor', $id); //echo "<pre />"; print_r($result); exit;
		$data['result'] = $result;
		$data['value'] = $flag;
        return view('debtorcreditor/view', $data);
    }
	//List all the creditors and debtors
	public function list(): string
    {
		
		/*$perPage = 4;
		$cpage = isset($_GET['page_no']) ? $_GET['page_no'] : 1; 
		$previous_page = $cpage - 1;
		$next_page = $cpage + 1;
		$offset=($cpage - 1) * $perPage;
		$total = $this->DailyModel->geTotaldbc();
		$total_no_of_pages = ceil($total / $perPage); 
		$bita['perPage'] = $perPage;
		$bita['offset'] = $offset;
		$bita['cpage'] = $cpage;
		$bita['total_no_of_pages'] = $total_no_of_pages;
		$bita['previous_page'] = $previous_page;
		$bita['next_page'] = $next_page;
		$a = displayPagination($bitas);
		$result = $this->DailyModel->temp($perPage, $offset);*/
		
		$result = $this->DailyModel->dcList();
		
		$total = $this->DailyModel->dcListt();
		$data['sname'] = $this->session->get('name'); //echo "<pre />"; print_r($result); exit;
		$data['result'] = $result; 
		$data['total'] = $total; 
        return view('debtorcreditor/list', $data);
    }
	
	//Edit view
	public function edit($id)
    {
	
		$data['sname'] = $this->session->get('name'); 
		//Get all records
		$result = $this->DailyModel->gselect('debtorcreditor', $id); //echo "<pre />"; print_r($result); exit;
		$data['result'] = $result;
		//display Pay to creditors and debtors 
		 $types = array(
			'Owner'=>1,
			'Supplier'=>2,
			'Third Party'=>3,
			'Government'=>4,
			'Old Outstanding'=>5,
			'Services'=>6
		 );
		 //echo "<pre />"; print_r($types); exit;
		 $str='';  
		 foreach($types AS $key=>$value)
		 {
			if($value == $result->type)
			{	
				$str.='<option value="'.$value.'" selected>'.$key.'</option>';
			}
			else
			{
				$str.='<option value="'.$value.'">'.$key.'</option>';
			}		
		 }
		 $data['str'] = $str;
        return view('debtorcreditor/edit', $data);
    }
	
	//Update creditor/debtor
	public function editsave($id)
	{		
		$request = \Config\Services::request();
		$dcname = $request->getPost('dcname'); 
		$type = $request->getPost('type'); 
		$addr = $request->getPost('addr'); 
		$phone = $request->getPost('phone'); 
		$pname = $request->getPost('pname'); 
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		
		$data = array(
			'dcnames'=>$dcname,
			'type'=>$type,
			'addr'=>$addr,
			'phone'=>$phone,
			'pname'=>$pname
          );
		
		//Add data
		$res = $this->DailyModel->gupdate($data, $id, 'debtorcreditor');
		if($res == 1)
		{			
			return redirect()->to(base_url('codeigniter/public/debtorcreditorView/'.$id.'/1')); 
		}
		else
		{
			echo "Your record is not saved successfully!";
		}		
	}	
}
