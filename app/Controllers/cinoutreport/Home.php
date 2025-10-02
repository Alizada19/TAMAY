<?php

namespace App\Controllers\cinoutreport;
use App\Controllers\BaseController;
use App\Models\cinoutreport\CinoutreportModel;
use CodeIgniter\I18n\Time;

require_once(APPPATH . '/ThirdParty/vendor2/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Home extends BaseController
{
    //my constructor
	public function __construct() 
	{

        $this->CinoutreportModel = new CinoutreportModel();
		$request = \Config\Services::request();
        helper('fornames');
	}
	
	public function index()
    {		
			
			$data['a']='b';
			$hdata['title']='Customer IN/OUT Report';
			echo view('expenses/header', $hdata);
			echo  view('cinoutreport/home', $data);
			echo view('expenses/footer');
    }
	
	
	public function bypurchase()
	{	
			
			$sdate = $this->request->getGet('sdate'); 
			$edate = $this->request->getGet('edate'); 
			$type = $this->request->getGet('type'); 
			$shop = $this->request->getGet('shop'); 
			
			$data = array(
				'sdate'=>$sdate,
				'edate'=>$edate,
				'shop'=>$shop
			  );
			if($type==1)
			{
					
					$purchases = $this->CinoutreportModel->getPurchase($data);
					$all = $this->CinoutreportModel->getPurchaseAll($data);
					$data['result']=$purchases;
					$data['sdate']=$sdate;
					$data['edate']=$edate;
					$data['type']=$type;
					$data['shop']=$shop;
					$data['all']=$all;
					echo  view('cinoutreport/purchase', $data);
					
			}
			else if($type==2)
			{
					$locality = $this->CinoutreportModel->locality($data);
					$all = $this->CinoutreportModel->localityAll($data);
					$data['locality']=$locality;
					$data['all']=$all;
					echo  view('cinoutreport/locality', $data);
			}		
			
	}
	
}
