<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group(['middleware' => 'jwt.auth'], function ($router) {
	//system setup routes

	//earning routes
    Route::post('add/earning', 'EarnController@add');
    Route::get('earning', 'EarnController@show');
    Route::post('edit/earning', 'EarnController@edit');
    Route::get('get/earnings', 'EarnController@getAll');


    //Bank routes
    Route::post('add/bank', 'BankController@add');
    Route::get('bank', 'BankController@show');
    Route::post('edit/bank', 'BankController@edit');
    Route::post('get/bank', 'BankController@get');
    

    //Deductions routes
    Route::post('add/deduction', 'DeductController@add');
    Route::get('deduction', 'DeductController@show');
    Route::post('edit/deduction', 'DeductController@edit');
    Route::get('get/deductions', 'DeductController@getAll');

     //Colors routes
    Route::post('add/color', 'ColorController@add');
    Route::get('color', 'ColorController@show');
    Route::post('edit/color', 'ColorController@edit');
    Route::get('get/color', 'ColorController@get');


     //User Role routes
    Route::post('add/role', 'RoleController@add');
    Route::get('role', 'RoleController@show');
    Route::post('edit/role', 'RoleController@edit');
    Route::get('get/role', 'RoleController@get');


    //Permission routes
    Route::post('get/role-permissions', 'PermissionController@get');
    Route::post('edit/permissions', 'PermissionController@edit');

    //Notifications routes
    Route::post('get/role-notifications', 'SubscriptionController@get');
    Route::post('edit/role-notifications', 'SubscriptionController@edit');
    

     //User Departments routes
    Route::post('add/departments', 'DepartmentController@add');
    Route::get('department', 'DepartmentController@show');
    Route::post('edit/departments', 'DepartmentController@edit'); 
     Route::get('get/department', 'DepartmentController@get');  



     //ChartOfAccounts routes
    Route::post('add/chartofaccount', 'ChartOfAccountController@add');
    Route::get('chartofaccount', 'ChartOfAccountController@show');
    Route::post('edit/chartofaccount', 'ChartOfAccountController@edit');
    Route::get('get/chartofaccount', 'ChartOfAccountController@get');
    Route::post('get/chart_of_accounts', 'ChartOfAccountController@get');//merging error

     //Months routes
    Route::get('months', 'MonthController@show');


     //PayPeriod routes
    Route::post('add/payperiod', 'PayPeriodController@add');
    Route::get('payperiod', 'PayPeriodController@show');
    Route::get('saved-payperiod', 'PayPeriodController@showSaved');
    Route::post('edit/payperiod', 'PayPeriodController@edit');
    Route::post('get/payperiod', 'PayPeriodController@get');
    Route::post('save/payperiod', 'PayPeriodController@save');

     //Asset Category routes
    Route::post('add/assetcategory', 'AssetCategoryController@add');
    Route::get('assetcategory', 'AssetCategoryController@show');
    Route::post('edit/assetcategory', 'AssetCategoryController@edit');
    Route::get('get/assetcategory', 'AssetCategoryController@get');

      //Asset Manufacturer routes
    Route::post('add/assetmanufacturer', 'AssetManufacturerController@add');
    Route::get('assetmanufacturer', 'AssetManufacturerController@show');
    Route::post('edit/assetmanufacturer', 'AssetManufacturerController@edit');
    Route::post('get/assetmanufacturer', 'AssetManufacturerController@get');
    
   
      //Asset Model routes
    Route::post('add/assetmodel', 'AssetModelController@add');
    Route::get('assetmodel', 'AssetModelController@show');
    Route::post('edit/assetmodel', 'AssetModelController@edit');
    Route::get('get/assetmodel', 'AssetModelController@get');
    Route::post('get/assetmodel/assetmanufacturer', 'AssetModelController@getManufacturer');
    Route::get('get/assetmodel/vehicle', 'AssetModelController@getVehicleModels');

      //Material and Servoices Category routes  //Material and Servoices Category routes
    Route::post('add/material_and_service', 'MaterialAndServiceCategoryController@add');
    Route::get('material_and_service', 'MaterialAndServiceCategoryController@show');
    Route::post('edit/material_and_service', 'MaterialAndServiceCategoryController@edit'); 
    Route::get('get/material_and_service', 'MaterialAndServiceCategoryController@get');
   

      //Material and Services Category routes
    Route::get('get/material_and_service_type', 'MaterialAndServiceTypeController@get');
    Route::post('get/material_and_service_categories/all', 'MaterialAndServiceCategoryController@getAll');

      //Material and Services routes
    Route::post('add/material&service', 'MaterialAndServiceController@add');
    Route::get('material&service', 'MaterialAndServiceController@show');
    Route::get('get-all/material_and_service', 'MaterialAndServiceController@getAll');
    Route::post('edit/material&service', 'MaterialAndServiceController@edit');
    //Route for Searches
    Route::post('get/materials', 'MaterialAndServiceController@getMaterial');
    Route::post('get/services', 'MaterialAndServiceController@getService');
    //Get services only
    Route::get('get/service', 'MaterialAndServiceController@getS');
    //Get material only
    Route::get('get/material', 'MaterialAndServiceController@getM');

     Route::post('get/category-materials', 'MaterialAndServiceController@categoryMaterials');
    
      //Project Phases routes
    Route::post('add/projectphase', 'ProjectPhaseController@add');
    Route::get('projectphase', 'ProjectPhaseController@show');
    Route::post('edit/projectphase', 'ProjectPhaseController@edit'); 
    Route::get('get/projectphase', 'ProjectPhaseController@get');

     //Inventory Location routes
    Route::post('add/inventorylocation', 'InventoryLocationController@add');
    Route::get('inventorylocation', 'InventoryLocationController@show');
    Route::post('edit/inventorylocation', 'InventoryLocationController@edit');
    //Get inventory Locations
     Route::get('get/inventorylocation', 'InventoryLocationController@get');

 //Payment Category routes
    Route::post('add/paymentcategory', 'PaymentCategoryController@add');
    Route::get('paymentcategory', 'PaymentCategoryController@show');
    Route::post('edit/paymentcategory', 'PaymentCategoryController@edit');
    Route::get('get/paymentcategories', 'PaymentCategoryController@getAll');

    //HighLevelProjecPhase routes
    Route::post('add/highlevelprojectphase', 'HighLevelProjectPhaseController@add');
    Route::get('highlevelprojectphase', 'HighLevelProjectPhaseController@show');
    Route::post('edit/highlevelprojectphase', 'HighLevelProjectPhaseController@edit');

     //Vendor Category routes
    Route::post('add/vendorcategory', 'VendorCategoryController@add');
    Route::get('vendorcategory', 'VendorCategoryController@show');
    Route::post('edit/vendorcategory', 'VendorCategoryController@edit');
    Route::post('get/vendorcategory', 'VendorCategoryController@get');

    //Project Phases Activities routes
    Route::post('add/projectphaseactivities', 'ProjectPhaseActivityController@add');
    Route::get('projectphaseactivities', 'ProjectPhaseActivityController@show');
    Route::post('edit/projectphaseactivities', 'ProjectPhaseActivityController@edit');

    //User Position routes
    Route::post('add/position', 'UserPositionController@add');
    Route::get('position', 'UserPositionController@show');
    Route::post('edit/position', 'UserPositionController@edit');
     Route::get('get/position', 'UserPositionController@get');   

      //User  routes
    Route::post('add/user', 'UserController@add');
    Route::get('user', 'UserController@show');
    Route::post('edit/user', 'UserController@edit');
    Route::post('edit-second/user', 'UserController@edit_second');
    Route::post('edit-third/user', 'UserController@edit_third');
    Route::post('edit-fourth/user', 'UserController@edit_fourth');
    Route::post('edit-fifth/user', 'UserController@edit_fifth');
    Route::post('edit/user-login', 'UserController@editLogin');
    Route::post('get/user', 'UserController@get');
    Route::post('get/user/all', 'UserController@getAll');
    Route::get('get/user/salary/all', 'UserController@getAllSalary');
    Route::post('get/singleuser/salary', 'UserController@getSalary');
    Route::get('get/user/without-paye', 'UserController@userPaye');
    Route::get('get/user/without-imprest', 'UserController@userImprest');

      //Client routes
    Route::post('add/client', 'ClientController@add');
    Route::get('client', 'ClientController@show');
    Route::post('edit/client', 'ClientController@edit');
    Route::post('edit-second/client', 'ClientController@edit_second');
    Route::post('edit-third/client', 'ClientController@edit_third');
    Route::post('edit-fourth/client', 'ClientController@edit_fourth');
    Route::post('edit-fifth/client', 'ClientController@edit_fifth');
    Route::post('get/client', 'ClientController@get');
    Route::get('get/client/all', 'ClientController@getAll');

    //Country Routes
    Route::get('get/country','CountryController@get');

    //City Routes
    Route::get('get/city','CityController@get');

    //State Routes
    Route::get('get/state','StateController@get');

     //Vendor routes
    Route::post('add/vendor', 'VendorController@add');
    Route::get('vendor', 'VendorController@show');
    Route::post('edit/vendor', 'VendorController@edit');
    Route::post('get/vendor', 'VendorController@get');
    Route::post('vendor/delete', 'VendorController@delete');
    Route::post('vendor/flag', 'VendorController@flag');
    Route::post('vendor/unflag', 'VendorController@unflag');
    Route::get('get/vendor/all', 'VendorController@getAll');
    Route::get('get/vendor/without-imprest', 'VendorController@vendorImprest');
    

    //VendorPricing Routes
    Route::get('vendorpricing', 'VendorServiceController@show');


     //Projects William
    Route::post('add/project', 'ProjectController@add');
    Route::get('project', 'ProjectController@show');
    Route::get('get-project-costing', 'ProjectController@showCosting');
    Route::get('get-project-contract', 'ProjectController@showContract');
    Route::post('edit/project', 'ProjectController@edit');
    Route::post('edit/project/active', 'ProjectController@editactive');
    Route::post('get/project', 'ProjectController@get');
    Route::get('getAllProjects', 'ProjectController@getAllProjects');
    Route::post('add/project-costing', 'ProjectController@addProjectCosting');
    Route::post('add/vendor-contract', 'ProjectController@addVendorContract');
    Route::get('project-receivables', 'ProjectController@getReceivables');
    //search through projects
    Route::post('search/projects', 'ProjectController@search');

     Route::get('get-requisition-projects', 'ProjectController@showRequisition');//All projects with prs
    Route::post('add/requisition-project', 'ProjectController@addPurchaseRequisition');

    //Purchase Requisition
    Route::post('get/purchase-requisitions', 'PurchaseRequisitionController@get');//All prs for a project
    Route::post('get/purchase-requisition-view', 'PurchaseRequisitionController@get_view');//when entering view reqs
    Route::post('add/purchase-requisition', 'PurchaseRequisitionController@add');
    Route::post('update/purchase-requisition', 'PurchaseRequisitionController@update');

    //Purchase Requisition Material
    Route::post('get/requisition-materials', 'PurchaseRequisitionMaterialController@show');
    Route::post('add/requisition-materials', 'PurchaseRequisitionMaterialController@add');
    Route::post('approve/requisition-material', 'PurchaseRequisitionMaterialController@approve');
    Route::post('decline/requisition-material', 'PurchaseRequisitionMaterialController@decline');
    Route::post('delivered/requisition-material', 'PurchaseRequisitionMaterialController@delivered');
    Route::post('requisition-material/add-payment', 'PurchaseRequisitionMaterialController@add_payment');
    Route::post('requisition-material/assign-vendor', 'PurchaseRequisitionMaterialController@assign_vendor');


    //Individaul Project Phases -- William
    Route::post('add/invividualprojectphase', 'IndividualProjectPhasesController@add');
    Route::post('delete/invividualprojectphase', 'IndividualProjectPhasesController@delete');
    Route::post('get/invividualprojectphase', 'IndividualProjectPhasesController@get');
    Route::post('review/invividualprojectphase', 'IndividualProjectPhasesController@review');
    Route::post('approve/invividualprojectphase', 'IndividualProjectPhasesController@approve');
    Route::post('decline/invividualprojectphase', 'IndividualProjectPhasesController@decline');
    Route::post('cancel/invividualprojectphase', 'IndividualProjectPhasesController@cancel');
    Route::post('singleGet/invividualprojectphase', 'IndividualProjectPhasesController@singleGet'); //William

    Route::post('get/project/invividualprojectphases', 'IndividualProjectPhasesController@getProjectPhases'); //William

    //Project Files
    Route::post('project/file-upload','ProjectFileController@add');

    //Project Staff
    Route::post('add/projectstaff', 'ProjectStaffAllocationController@add');


    //Liquid assets
    Route::post('add/liquidasset', 'LiquidAssetController@add');
    Route::get('liquidasset', 'LiquidAssetController@show');
    Route::post('edit/liquidasset', 'LiquidAssetController@edit');
    Route::post('edit-second/liquidasset', 'LiquidAssetController@edit_second');
    Route::post('edit-third/liquidasset', 'LiquidAssetController@edit_third');
    Route::post('edit/liquidasset/active', 'LiquidAssetController@editactive');
    Route::post('get/liquidasset', 'LiquidAssetController@get');

    //AssignLiquid assets
    Route::post('add/assignliquidasset', 'LiquidAssetassignmentController@add');
    Route::get('assignliquidasset', 'LiquidAssetassignmentController@show');
    Route::post('edit/assignliquidasset', 'LiquidAssetassignmentController@edit');
    // Route::post('edit/liquidasset/active', 'LiquidAssetController@editactive');

     //Project Materials -- William
    Route::post('update/projectmaterial', 'ProjectMaterialController@update');//Used for updating existing records
    Route::post('add/projectmaterial', 'ProjectMaterialController@add');//Used for inserting new ones
    Route::post('delete/projectmaterial', 'ProjectMaterialController@delete');//Used for inserting new ones

     Route::post('add/operational-projectmaterial', 'ProjectMaterialController@addForOperationalProjects');//Used for inserting new ones
    Route::post('delete/operational-projectmaterial', 'ProjectMaterialController@deleteForOperationalProjects');//Used for deleting new ones
    Route::post('update/operational-projectmaterial', 'ProjectMaterialController@updateForOperationalProjects');//Used for updating existing records

    //Project Labours
    Route::post('update/projectlabour', 'ProjectLabourController@update');
    Route::post('add/projectlabour', 'ProjectLabourController@add');//Used for inserting new ones
    Route::post('delete/projectlabour', 'ProjectLabourController@delete');


       //William
    Route::post('add/operational-projectlabour', 'ProjectLabourController@addForOperationalProjects');//Used for inserting new ones
    Route::post('delete/operational-projectlabour', 'ProjectLabourController@deleteForOperationalProjects');//Used for deleting new ones
    Route::post('update/operational-projectlabour', 'ProjectLabourController@updateForOperationalProjects');//Used for updating existing records

   // Vehicle Requests Routes
    Route::post('add/vehiclerequest', 'VehicleRequestController@add');
    Route::get('vehiclerequest', 'VehicleRequestController@show');
     Route::post('edit/vehiclerequest', 'VehicleRequestController@edit');
     Route::post('approve/vehiclerequest', 'VehicleRequestController@approve');
     Route::post('return/vehiclerequest/vehicle', 'VehicleRequestController@return');
     Route::post('vehicle/search', 'VehicleRequestController@search');
     Route::get('vehicle/assignments', 'VehicleRequestController@getAssignedVehicles');
 
       //Costing Weeks
    Route::post('get/costing-weeks','CostingWeekController@get');
    Route::post('add/costing-week', 'CostingWeekController@add');
    Route::post('review/week', 'CostingWeekController@review');
    Route::post('approve/week', 'CostingWeekController@approve');
    Route::post('decline/week', 'CostingWeekController@decline');
    Route::post('cancel/week', 'CostingWeekController@cancel');


     //Employee Imprest
     Route::post('add/employeeimprest', 'EmployeeImprestController@add');
    Route::get('employeeimprest', 'EmployeeImprestController@show');
     Route::post('edit/employeeimprest', 'EmployeeImprestController@edit');

     //Employee Imprest TopUp
     Route::post('add/employeeimpresttopup', 'EmployeeImprestTopupController@add');
    Route::get('employeeimpresttopup', 'EmployeeImprestTopupController@show');
     Route::post('edit/employeeimpresttopup', 'EmployeeImprestTopupController@edit');
     Route::post('get/imprest/user', 'EmployeeImprestTopupController@imprestUser');

     //Employee Imprest TopUp withdrawal
     Route::post('add/employeeimpresttopupwithdrawal', 'EmployeeImprestTopupWithdrawalsController@add');
      Route::get('employeeimpresttopupwithdrawal', 'EmployeeImprestTopupWithdrawalsController@show');


     //Bank Accounts
     Route::get('bankaccounts', 'BankAccountController@getAll');

     //Inventory Store Routes
     Route::post('add/inventorystore', 'InventoryController@add');
    Route::get('inventorystore', 'InventoryController@show');
     Route::post('edit/inventorystore', 'InventoryController@edit'); 

     //Inventory Store Top ups Routes
     Route::post('add/inventorystore_tops', 'InventoryTopupController@add');
    Route::get('inventorystore_tops', 'InventoryTopupController@show');
     // Route::post('edit/inventorystore_tops', 'InventoryTopupController@edit');
     Route::post('get/material', 'InventoryTopupController@inventoryMaterial');

      //Inventory Store Topups withdrawals  Routes
     Route::post('add/inventorywithdrawal', 'InventoryTopupWithdrawalController@add');
     Route::post('add/new_invoice', 'InventoryTopupWithdrawalController@addInvoice');
     Route::post('add/to_invoice', 'InventoryTopupWithdrawalController@addToInvoice');
    // Route::get('inventorystore_tops', 'InventoryTopupController@show');
    //  Route::post('edit/inventorystore_tops', 'InventoryTopupController@edit');



      //Invoices Routes
     Route::post('add/invoice', 'InvoiceController@add');
     Route::post('add/recievable', 'InvoiceController@addRecievable');
    Route::get('invoice', 'InvoiceController@show');
    Route::post('invoice/print', 'InvoiceController@print');
     Route::post('edit/inventorystore', 'InvoiceController@edit');
     Route::get('getInvoice', 'InvoiceController@get'); 
     Route::get('invoice/count', 'InvoiceController@getCount'); 



      //Tax/Payee Routes
     Route::post('add/tax', 'TaxController@add');
     Route::get('tax', 'TaxController@show');
     Route::post('edit/tax', 'TaxController@edit'); 


     //Vendor Contracts Routes
     Route::post('add/vendor-contracts', 'VendorContractController@add');
     Route::get('vendor-contracts', 'VendorContractController@show');
     Route::post('edit/tax', 'VendorContractController@edit');

     //user earnings route
     Route::post('edit/user/earnings', 'EarningController@update');

     //user deductions route
     Route::post('edit/user/deductions', 'DeductionController@update');


      //Payroll Archive Routes
     Route::post('add/payment', 'ArchiveController@add');
   
});