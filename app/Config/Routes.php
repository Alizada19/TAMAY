<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
//Display perfume
$routes->get('/perfumes/display', 'perfumes\Home::display');
$routes->get('/dailyform', 'Dailyform::index');
$routes->post('/dailyformAdd', 'Dailyform::add');
$routes->post('/dailyformAdd', 'Dailyform::update');
$routes->post('/updatedRecord/(:any)', 'Rfupdate::update/$1');
$routes->get('/dailyformUpdate/(:any)', 'Dailyform::update/$1');
$routes->get('/login', 'Login::index');
$routes->post('/loginadd', 'Login::add');
$routes->get('/nightlyreport', 'nightlyreport::index');
$routes->get('/bringsub/(:any)', 'bringsub::index/$1');
$routes->get('/bringsub2/(:any)', 'bringsub::bringUpdate/$1');
$routes->get('/dailyformview/(:any)/(:any)', 'Dailyform::view/$1/$2');
$routes->get('/sreport', 'sreport::index');
$routes->post('/sreport/rsearch', 'sreport::rsearch');
$routes->get('/printpdf/(:any)', 'printpdf::index/$1');
$routes->post('/removesub/(:any)', 'bringsub::removesub/$1');
$routes->get('/printpdfNightReports/', 'printpdfNightReports::index/');
$routes->get('/printpdfsreport/(:any)/(:any)/(:any)', 'printpdfsreport::index/$1/$2/$3');
//Payment Routs
$routes->get('/payment', 'Payment::index');
$routes->get('/addCheque', 'Payment::addCheque');
$routes->post('/paymentAddc', 'Payment::addc');
$routes->get('/paymentViewc/(:any)/(:any)', 'Payment::viewc/$1/$2');
$routes->get('/paymentViewoc/(:any)/(:any)', 'Payment::viewoc/$1/$2');
$routes->get('/paymenttype/(:any)', 'Payment::bringPtype/$1');
$routes->get('/debtorcreditor/(:any)', 'Debtorcreditor::index/$1');
//View Debtors&Creditors main
$routes->get('/debtorcreditorView/(:any)/(:any)', 'Debtorcreditor::view/$1/$2');

$routes->post('/savedebtorcreditor', 'Debtorcreditor::save');
$routes->get('/paymentupdatec/(:any)', 'Payment::updatec/$1');
//save the updated cheque/cash
$routes->post('/paymentupdatecs/(:any)', 'Payment::updatecs/$1');
//online transfer/cash update view
$routes->get('/paymentupdateoc/(:any)', 'Payment::updateoc/$1');
//Payments Reports
$routes->get('/chequereports', 'Paymentreports::index');
$routes->get('/ocashreports', 'Paymentreports::ocash');
//Print pdf cheque
$routes->get('/printpdfcheque/', 'Paymentprintpdf::cheque/');
//Bring the cheque search
$routes->post('/searchcheque', 'Paymentsearch::index/');
//Print pdf specefic records
$routes->get('/printpdfchequesearch', 'Paymentprintpdf::printcheque');

//Print pdf OT/Cash
$routes->get('/printpdfot/', 'Paymentprintpdf::ot/');
//Bring the date spececified search OTS
$routes->get('/searchot', 'Paymentsearch::searchot/');
//Print pdf OT Search
$routes->get('/printpdfotsearch', 'Paymentprintpdf::printotsearch');
//Bring All payments
$routes->get('/apayments', 'Paymentreports::apayments');
//All report search
$routes->post('/allReportSearch', 'Paymentsearch::allReportSearch');
//All report search sub
$routes->get('/allReportSearchSub', 'Paymentsearch::allReportSearchSub');
//Print pdf all payments
$routes->get('/printpdfAllPayments', 'Paymentprintpdf::pdfAllPayments');
//Print pdf all search by date
$routes->get('/printpdfAllSearchBydate', 'Paymentprintpdf::printpdfAllSearchBydate');
//Print pdf by suppliers
$routes->get('/supReports', 'Paymentprintpdf::supReports');
//Pending cheques graphp for 7 days
$routes->get('/pendingChequesCharts', 'Charts::index');
//Debtors and creditors list
$routes->get('/debtorcreditorlist', 'Debtorcreditor::list');
//Edit creditors and debtors
$routes->get('/debtorcreditoredit/(:any)', 'Debtorcreditor::edit/$1');
//update save debtor creditor
$routes->post('/debtorcreditoresave/(:any)', 'Debtorcreditor::editsave/$1');
//Customer inout main controller
$routes->get('/cinoutmain', 'Cinout::index');
//Customer inout main save
$routes->post('/cinoutsave', 'Cinout::save');
//Add record int to database
$routes->get('/paymentun/(:any)/(:any)', 'Payment::viewun/$1/$2');
//Update view of the records
$routes->get('/paymentschedupv/(:any)', 'Payment::schedupv/$1');
//Unscheduled cash Reports
$routes->get('/uncashreports', 'Paymentreports::uncash');
//Daily sales report list
$routes->get('/dailySalesReportList', 'Dailyform::list');
//Byoneday list
$routes->get('/byonedaylist/(:any)', 'Byoneday::index/$1');
//Print pdf datebased
$routes->get('/printpdfDatebased/(:any)', 'Printpdfdatebased::index/$1');
//Inout chart
$routes->get('/inoutchart', 'Inoutchart::index');
//Print pdf between by two dates
$routes->get('/printpdfbydates/(:any)/(:any)', 'Printpdfdatebased::bygivendates/$1/$2');

//Add Balancesheet creditors and debtors
$routes->get('/cdbtorsAdd', 'Cdbtors::add');
//Save debtors and creditors into database
$routes->post('/cdbtorsSave', 'Cdbtors::save');
//Creditors and debtor view
$routes->get('/cdbtorsView/(:any)/(:any)', 'Cdbtors::view/$1/$2');
//Balancesheet list
$routes->get('/cdbtorsList/(:any)', 'Cdbtors::list/$1');
//Invoice Payment Add
$routes->get('/cdbtorsAddPay', 'Cdbtors::addPay');
//Save invoice payment into database
$routes->post('/cdbtorsSavePay', 'Cdbtors::savePay');
//Invoice payment view
$routes->get('/cdbtorsViewPay/(:any)/(:any)', 'Cdbtors::viewPay/$1/$2');
//Balancesheet Main list
$routes->get('/cdbtorsMainList', 'Cdbtors::mainList');
//Edit invoice
$routes->get('/cdbtorsEdit/(:any)', 'Cdbtors::edit/$1');
//Edit invoice pay
$routes->get('/cdbtorsEditPay/(:any)', 'Cdbtors::editPay/$1');
//save edited invoice add 
$routes->post('/cdbtorsUpdate/(:any)', 'Cdbtors::update/$1');
//save edited invoice pay 
$routes->post('/cdbtorsUpdatePay/(:any)', 'Cdbtors::updatePay/$1');
//Print pdf cdbc
$routes->get('/printpdfcdbc/(:any)', 'Printpdfcdbc::index/$1');
$routes->get('/printpdfcdbc2/(:any)', 'Printpdfcdbc2::index/$1');

//Debtor creditor Search
$routes->post('/dbcsearch', 'Dbcsearch::search');
$routes->get('/dbcsearchnew', 'Dbcsearchnew::search');
//Print pdf Mainlist of Balance Sheet
$routes->get('/printpdfbal/', 'Printpdfbal::index');
$routes->get('/printpdfbal2/', 'Printpdfbal2::index');
//Print by type
$routes->get('/printpdfbaltype/(:any)', 'Printpdfbal::printbytype/$1');
$routes->get('/printpdfbaltype2/(:any)', 'Printpdfbal2::printbytype/$1');


//Print exel Expenses
$routes->post('/expenses/printExcel', 'expenses\Expenses::printExel');
//Print Daily excel
$routes->post('/expenses/printDailyExcel', 'expenses\Expenses::printDailyExel');
//Groupe add
$routes->get('/expenses/groupeAdd', 'expenses\Groupe::groupeAdd');
//Groupe save
$routes->post('/expenses/groupeSave', 'expenses\Groupe::groupeSave');
//Groupe view
$routes->get('/expenses/groupeView/(:any)/(:any)', 'expenses\Groupe::groupeView/$1/$2');
//Groupe edit view
$routes->get('/expenses/groupeEditView/(:any)', 'expenses\Groupe::groupeEditView/$1');
//Groupe Save Edit
$routes->post('/expenses/groupeEditSave/(:any)', 'expenses\Groupe::groupeEditSave/$1');
//Groupe List
$routes->get('/expenses/groupeList', 'expenses\Groupe::index');

//Category add
$routes->get('/expenses/categoryAdd', 'expenses\Category::categoryAdd');
//Category save
$routes->post('/expenses/categorySave', 'expenses\Category::categorySave');
//Category view
$routes->get('/expenses/categoryView/(:any)/(:any)', 'expenses\Category::categoryView/$1/$2');
//Category edit view
$routes->get('/expenses/categoryEditView/(:any)', 'expenses\Category::categoryEditView/$1');
//Category Save Edit
$routes->post('/expenses/categoryEditSave/(:any)', 'expenses\Category::categoryEditSave/$1');
//Category List
$routes->get('/expenses/categoryList', 'expenses\Category::index');

//Sub Category add
$routes->get('/expenses/subcategoryAdd', 'expenses\Subcategory::subcategoryAdd');
//Sub Category save
$routes->post('/expenses/subcategorySave', 'expenses\Subcategory::subcategorySave');
//Sub Category view
$routes->get('/expenses/subcategoryView/(:any)/(:any)', 'expenses\Subcategory::subcategoryView/$1/$2');
//Sub Category edit view
$routes->get('/expenses/subcategoryEditView/(:any)', 'expenses\Subcategory::subcategoryEditView/$1');
//Sub Category Save Edit
$routes->post('/expenses/subcategoryEditSave/(:any)', 'expenses\Subcategory::subcategoryEditSave/$1');
//Sub Category List
$routes->get('/expenses/subcategoryList', 'expenses\Subcategory::index');

//expenses
//expenses Add
$routes->get('/expenses/add', 'expenses\Expenses::add');
//expenses save
$routes->post('/expenses/save', 'expenses\Expenses::save');
//Expenses view
$routes->get('/expenses/view/(:any)/(:any)', 'expenses\Expenses::view/$1/$2');
//Expenses edit view
$routes->get('/expenses/editView/(:any)', 'expenses\Expenses::editView/$1');
//Expenses Save Edit
$routes->post('/expenses/editSave/(:any)', 'expenses\Expenses::editSave/$1');
//Expenses List
$routes->get('/expenses/list', 'expenses\Expenses::index');
//Filter Search
$routes->get('/expenses/searchFilter', 'expenses\Expenses::filterSearch');
//Print Expenses
$routes->get('/expenses/printpdf', 'expenses\Printpdf::index');
//groupebased Expenses
$routes->get('/expenses/groupebased/(:any)', 'expenses\Expenses::groupebased/$1');
//category based Expenses
$routes->get('/expenses/getcategory', 'expenses\Expenses::getCategory');
//groupe sub parts
$routes->get('/expenses/groupesub', 'expenses\Expenses::groupeSub');
//Category Based expenses
$routes->get('/expenses/categorybased/(:any)', 'expenses\Expenses::categorybased/$1');
//Balancesheet Main list
$routes->get('/cdbtorsMainListNew', 'Cdbtorsnew::mainList');
$routes->get('/cdbtorsList2/(:any)', 'Cdbtorsnew::list/$1');
//Bring cheque by cheque no
$routes->get('/expenses/bringCheque/(:any)', 'expenses\Expenses::bringCheque/$1');
//Eden Expenses Plan
$routes->get('/excelreport/excelplan', 'excelreport\excelplan::index');

//Customer in/out main report page
$routes->get('/cinoutreport/home', 'cinoutreport\Home::index');
//Search based on purchase
$routes->get('/cinoutreport/bypurchase', 'cinoutreport\Home::bypurchase');
//Cinout report
$routes->get('/cinoutreport/cinout', 'cinoutreport\Printpdf::print');
//Attendance Dashboard
$routes->get('/attendance/index', 'attendance\Attendance::index');
//Add employee
$routes->get('/attendance/addemp', 'attendance\Attendance::addemp');
//save
$routes->post('/attendance/saveemp', 'attendance\Attendance::saveemp');
//view employees
$routes->get('/attendance/viewemp/(:any)/(:any)', 'attendance\Attendance::viewemp/$1/$2');
//Edit view employees
$routes->get('/attendance/editViewemp/(:any)', 'attendance\Attendance::editViewemp/$1');
//Save Update
$routes->post('/attendance/saveEmpUpdate/(:any)', 'attendance\Attendance::saveEmpUpdate/$1');
//Employees list
$routes->get('/attendance/empList', 'attendance\Attendance::empList');
//Add Attendance
$routes->get('/attendance/addPunch', 'attendance\Attendance::addPunch');
//Save Punches
$routes->get('/attendance/savePunch/(:any)', 'attendance\Attendance::savePunch/$1');
//Bring Attendance by id
$routes->get('/attendance/bringAtt', 'attendance\Attendance::bringAtt');
//Attendance Search Layout
$routes->get('/attendance/searchlayout', 'attendance\Attendance::searchlayout');
//Search attendance
$routes->get('/attendance/search', 'attendance\Attendance::search');
//view punch
$routes->get('/attendance/viewPunch/(:any)', 'attendance\Attendance::viewPunch/$1');
//Edit View Punch
$routes->get('/attendance/editViewPunch/(:any)', 'attendance\Attendance::editViewPunch/$1');
//Save edited punchcdbtorsList
$routes->post('/attendance/saveEditPunch/(:any)', 'attendance\Attendance::saveEditPunch/$1');
//Delete Punch
$routes->get('/attendance/deletePunch/(:any)', 'attendance\Attendance::deletePunch/$1');
//Download Id
$routes->get('/attendance/downloadId/(:any)', 'attendance\Attendance::downloadId/$1');
//Download Profile Picture
$routes->get('/attendance/downloadProfile/(:any)', 'attendance\Attendance::downloadProfile/$1');
//Search employee
$routes->get('/attendance/searchEmp', 'attendance\Attendance::searchEmp');
//Attanden Report Layout
$routes->get('/attendance/reportLayout', 'attendance\Attendance::reportLayout');
//Attandence report
$routes->get('/attendance/report', 'attendance\Attendance::report');
$routes->get('/attendance/bringEmp', 'attendance\Attendance::bringEmp');
//Calender
$routes->get('/expenses/calender', 'expenses\Expenses::calender');

//Perfumes
$routes->get('/perfumes/home', 'perfumes\Home::index');
//Add Perfume
$routes->get('/perfumes/add', 'perfumes\Home::add');
//Bring category
$routes->get('/perfumes/bringCat', 'perfumes\Home::bringCat');
//Save Perfume
$routes->post('/perfumes/save', 'perfumes\Home::save');
//View
$routes->get('/perfumes/view/(:any)', 'perfumes\Home::view/$1');
//Edit view of Perfume
$routes->get('/perfumes/editView/(:any)', 'perfumes\Home::editView/$1');
//Save Edit
$routes->post('/perfumes/editSave/(:any)', 'perfumes\Home::editSave/$1');
//Display perfume
$routes->get('/perfumes/display', 'perfumes\Home::display');
//Filter Perfumes
$routes->get('/perfumes/searchFilter', 'perfumes\Home::searchFilter');
//Show floral notes
$routes->get('/perfumes/floral', 'perfumes\Home::floral');
//Show Oriental
$routes->get('/perfumes/oriental', 'perfumes\Home::oriental');
//Show Woody
$routes->get('/perfumes/woody', 'perfumes\Home::woody');
//Show fresh
$routes->get('/perfumes/fresh', 'perfumes\Home::fresh');
//Fruity
$routes->get('/perfumes/fruity', 'perfumes\Home::fruity');
//Floral Sub
$routes->get('/perfumes/floralSub', 'perfumes\Home::floralSub');
//Floral Soft
$routes->get('/perfumes/floralSoft', 'perfumes\Home::floralSoft');
//Floral Oriental
$routes->get('/perfumes/floralOriental', 'perfumes\Home::floralOriental');
//Soft Oriental
$routes->get('/perfumes/softOriental', 'perfumes\Home::softOriental');
//Orintal Sub
$routes->get('/perfumes/orientalSub', 'perfumes\Home::OrientalSub');
//Woody Oriental
$routes->get('/perfumes/woodyOriental', 'perfumes\Home::woodyOriental');
//Woody Sub
$routes->get('/perfumes/woodySub', 'perfumes\Home::woodySub');
//Mossy wood
$routes->get('/perfumes/mossyWood', 'perfumes\Home::mossyWood');
//Dry Wood
$routes->get('/perfumes/dryWood', 'perfumes\Home::drywood');
//Aromatic
$routes->get('/perfumes/aromatic', 'perfumes\Home::aromatic');
//Citrus
$routes->get('/perfumes/citrus', 'perfumes\Home::citrus');
//Water
$routes->get('/perfumes/water', 'perfumes\Home::water');
//Green
$routes->get('/perfumes/green', 'perfumes\Home::green');
//Get attendance report based on status
$routes->get('/attendance/bringStatus', 'attendance\Attendance::bringStatus');
//Attandence report with tolerance
$routes->get('/attendance/reportTol', 'attendance\Attendance::reportTol');
//Salary Dashboard
$routes->get('/salary/salaryDashboard', 'salary\Salary::salaryDashboard');
//Bring salary Main layout
$routes->get('/salary/mainLayout', 'salary\Salary::mainLayout');
//Leav list
$routes->get('/attendance/leaveList', 'attendance\Attendance::leaveList');
//Leav type
$routes->get('/attendance/leaveAdd', 'attendance\Attendance::leaveAdd');
//Print the attendance
$routes->get('/attendance/printpdf', 'attendance\Printpdf::index');

//Save salary
$routes->post('/salary/save', 'salary\Salary::save');
//View the salary details
$routes->get('/salary/view/(:any)', 'salary\Salary::view/$1');
//Update the salary record
$routes->get('/salary/update/(:any)', 'salary\Salary::update/$1');
//Update Save
$routes->post('/salary/updateSave/(:any)', 'salary\Salary::updateSave/$1');
//Salary List
$routes->get('/salary/salaryList', 'salary\Salary::salaryList');
//Search Salary
$routes->post('/salary/searchSalary', 'salary\Salary::searchSalary');
//Generate File
$routes->post('/salary/generateFile', 'salary\Salary::generateFile');
//Generate payslipt
$routes->get('/salary/generatePayslipt/(:any)', 'salary\Printpdf::generatePayslipt/$1');

$routes->get('upload', 'UploadController::uploadImage');

//Upload view 
$routes->get('excel', 'uploadexcel\Excel::index');
$routes->post('/uploadexcel/excel', 'uploadexcel\Excel::import');
//Search stock
$routes->post('/searchExcel', 'uploadexcel\Excel::search');
$routes->post('/ungroup', 'uploadexcel\Excel::ungroup');
$routes->post('/removeExcel/(:any)', 'uploadexcel\Excel::removeExcel/$1');
$routes->get('stockList', 'uploadexcel\Excel::stockList');
$routes->post('/uploadexcel/Printpdf', 'uploadexcel\Printpdf::index');
$routes->post('/schart', 'uploadexcel\Excel::schart');
$routes->post('/gcategory', 'uploadexcel\Excel::gcategory');
$routes->post('/printCategory', 'uploadexcel\Printpdf::printCategory');

//Add Fund 
$routes->get('addFund', 'johoni\Johoni::addFund');
$routes->post('saveFund', 'johoni\Johoni::saveFund');
$routes->get('viewFund/(:any)', 'johoni\Johoni::viewFund/$1');
$routes->get('editFund/(:any)', 'johoni\Johoni::editFund/$1');
$routes->post('editFundSave/(:any)', 'johoni\Johoni::editFundSave/$1');