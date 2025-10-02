<?php

namespace App\Controllers\expenses;
use App\Controllers\BaseController;

use App\Models\expenses\ExpensesModel;

use CodeIgniter\I18n\Time;
class Groupe extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->ExpensesModel = new ExpensesModel();
		$request = \Config\Services::request();
        helper('fornames');
	}
	
	public function index()
    {	
			
			$result = $this->ExpensesModel->getAllResult('groupe');  
			$data['result']=$result; //echo $total; exit;
			$hdata['title']='List Groupes';
			echo view('expenses/header', $hdata);
			echo view('expenses/groupe/list', $data);
			echo view('expenses/footer');
    }
	
	//Add Groupe
	public function groupeAdd()
	{
			$data['']='';
			$hdata['title']='Add Groupe';
			echo view('expenses/header', $hdata);
			echo  view('expenses/groupe/add', $data);
			echo view('expenses/footer');
	}
	
	//Save Groupe
	public function groupeSave()
	{
		
		$gname = $this->request->getPost('gname');
		//Check if groupe is already created
		$check = $this->ExpensesModel->checkRecord('gname',$gname, 'groupe'); 
		if($check<1)
		{	
			//Get username and id from the session
			$username = $this->session->get('name');
			$userid = $this->session->get('userid');
			$data = array(
					'gname'=>$gname,
					'userid'=>$userid,
					'username'=>$username,
					"saveDate" => date('Y-m-d H:i:s')
				  );
				 //echo "<pre />"; print_r($data); exit;
				 $rid = $this->ExpensesModel->saveRecord($data, 'groupe'); 
				if($rid)
				{
					return redirect()->to(base_url('codeigniter/public/expenses/groupeView/'.$rid.'/1'.'')); exit;
				}
				else
				{
					echo "Your record is not saved successfully";
				}		
		}
		else
		{
			echo "Groupe Name Aready exist in the database!";
		}		
	}
	
	//Groupe view
	public function groupeView($rid,$flag)
	{
		    
		$row = $this->ExpensesModel->displayRecord($rid, 'groupe');
		$data['row'] = $row;
		$data['flag'] = $flag;
		$hdata['title'] = 'View Groupe';
		echo view('expenses/header', $hdata);
		echo view('expenses/groupe/view', $data);
		echo view('expenses/footer');
	}
	//Groupe edit view
	public function groupeEditView($rid)
	{
		
		$row = $this->ExpensesModel->displayRecord($rid, 'groupe');
		$data['row'] = $row;
		$hdata['title'] = 'Edit Groupe';
		echo view('expenses/header', $hdata);
		echo view('expenses/groupe/edit', $data);
		echo view('expenses/footer');
	}
	
	//Save Edit Groupe
	public function groupeEditSave($rid)
	{
		
		$gname = $this->request->getPost('gname');
		//Get username and id from the session
		$username = $this->session->get('name');
		$userid = $this->session->get('userid');
		$data = array(
				'gname'=>$gname,
			  );
			  
			$update = $this->ExpensesModel->updateRecord($data, $rid, 'groupe'); 
			
			//Log table
			$dataLog = array(
				'gname'=>$gname,
				'tname'=>'groupe',
				'pid'=>$rid,
				'userid'=>$userid,
				'username'=>$username,
				"saveDate" => date('Y-m-d H:i:s')
			  );	  
			 //echo "<pre />"; print_r($data); exit;
			$this->ExpensesModel->saveRecord($dataLog, 'logs'); 
			
			if($update==1)
			{
				return redirect()->to(base_url('codeigniter/public/expenses/groupeView/'.$rid.'/1'.'')); exit;
			}
			else
			{
				echo "Record Not Update";
			}		
	}
}
