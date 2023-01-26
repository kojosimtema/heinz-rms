<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('server', function () {
    return view('application-error');
});

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');
Route::get('home/index', 'HomeController@index');
Route::get('home/samples', 'HomeController@samples');
Route::get('home/printersinfo', 'HomeController@printersinfo');
Route::get('home/printHtmlCard', 'HomeController@printHtmlCard');
Route::get('PrintHtmlCardController', 'PrintHtmlCardController@printFile');
Route::get('haha', 'PrintHtmlCardController@index');
Route::post('StoreImageFileController', 'StoreImageFileController@createFile');
Route::any('WebClientPrintController', 'WebClientPrintController@processRequest');

Route::get('DemoPrintCommands', 'DemoPrintCommandsController@index');
Route::get('DemoPrintCommandsController', 'DemoPrintCommandsController@printCommands');

Route::get('DemoPrintFile', 'DemoPrintFileController@index');
Route::get('DemoPrintFileController', 'DemoPrintFileController@printFile');

Route::get('DemoPrintFilePDF', 'DemoPrintFilePDFController@index');
Route::get('DemoPrintFilePDFController', 'DemoPrintFilePDFController@printFile');

Route::get('test/sms', 'ApiController@testSMS');
Route::get('test/htk', 'ApiController@htk');

Auth::routes();

Route::prefix('console')->group(function () {
    Route::get('/', 'ConsoleController@index');
    Route::get('back/response', 'ConsoleController@back')->name('console.back');
    Route::get('dashboard', 'ConsoleController@dashboard')->name('console.dashboard');
    Route::get('constuction', 'ConsoleController@construction')->name('console.construction');
    Route::get('constuction2', 'ConsoleController@construction2');
    Route::get('constuction4', 'ConsoleController@construction4');
    Route::get('constuction5', 'ConsoleController@construction5');
    Route::get('constuction6', 'ConsoleController@construction6');
    Route::get('clean/bills/location', 'ConsoleController@construction3');
    Route::resource('accountants', 'AccountantController');
    Route::resource('supervisors', 'SupervisorController');
    Route::resource('collectors', 'CollectorController');
    Route::resource('cashiers', 'CashierController');
    Route::resource('stock', 'StockController');
    Route::get('issue/stock', 'StockController@createIssue')->name('stock.issue');
    Route::post('issue/stock', 'StockController@storeIssue')->name('stock.issue');
    Route::get('find/gcr', 'StockController@findStock')->name('stock.find');
    Route::get('return/gcr', 'StockController@returnStock')->name('stock.return');
    Route::get('filter/cashier/form', 'CashierController@filterForm')->name('cashier.filter.payment');
    Route::post('payment/cashier/checkout', 'CashierController@checkoutPayment')->name('cashier.checkout.payment');
    Route::get('m/collectors/payment', 'CollectorController@payment')->name('collectors.payment');
    Route::get('p/collectors/payment/{collector}', 'CollectorController@makePayment')->name('collectors.payment.pay');
    Route::post('p/collectors/payment/{collector}', 'CollectorController@makePaymentPost')->name('collectors.payment.pay');

    /** Location routes */
    Route::get('location/zonals', 'LocationController@createZonals')->name('location.zonals');
    Route::post('location/zonals', 'LocationController@saveZonals')->name('location.zonals');
    Route::get('location/tas', 'LocationController@createTas')->name('location.tas');
    Route::post('location/tas', 'LocationController@saveTas')->name('location.tas');
    Route::get('location/electorals', 'LocationController@createElectorals')->name('location.electorals');
    Route::post('location/electorals', 'LocationController@saveElectorals')->name('location.electorals');
    Route::get('location/communities', 'LocationController@createCommunities')->name('location.communities');
    Route::post('location/communities', 'LocationController@saveCommunities')->name('location.communities');
    Route::get('location/constituencies', 'LocationController@createConstituencies')->name('location.constituencies');
    Route::post('location/constituencies', 'LocationController@saveConstituencies')->name('location.constituencies');
    Route::get('location/units', 'LocationController@createUnits')->name('location.units');
    Route::post('location/units', 'LocationController@saveUnits')->name('location.units');
    Route::get('location/streets', 'LocationController@createStreets')->name('location.streets');
    Route::post('location/streets', 'LocationController@saveStreets')->name('location.streets');

    /** Property routes */
    // Route::get('properties', 'PropertyController@index')->name('property.index');
    Route::get('property/types', 'PropertyController@addTypes')->name('property.types');
    Route::post('property/types', 'PropertyController@saveTypes')->name('property.types');
    Route::get('property/categories', 'PropertyController@addCategories')->name('property.categories');
    Route::post('property/categories', 'PropertyController@saveCategories')->name('property.categories');
    Route::get('property/owners', 'PropertyController@addOwners')->name('property.owners');
    Route::post('property/owners', 'PropertyController@saveOwners')->name('property.owners');
    Route::get('property/occupants', 'PropertyController@createOccupants')->name('property.occupants');
    Route::get('property/filter', 'PropertyController@filterPropertyByColumn')->name('property.filter.column');
    Route::resource('property', 'PropertyController');

    /** */
    Route::get('property/records/bills', 'RecordController@getBills')->name('property.records.bills');
    Route::get('prepare/bill/{query}', 'PropertyController@prepareBill')->name('property.prepare.bill');
    Route::get('property/payments/entry', 'RecordController@getpaymentsProperty')->name('property.payments.payment');
    Route::post('property/payments/entry', 'RecordController@savePaymentProperty')->name('property.payments.payment');
    Route::get('property/filter/owner', 'PropertyController@filterOwner')->name('property.filter.owner');

    Route::post('property/prepare/bills', 'PropertyController@preparePropertyBills')->name('property.prepare.bills');
    Route::get('property/records/bills/preview/{query}', 'RecordController@previewBill')->name('preview.bill');

    /** */
    Route::get('property/lgt/prepare/bill', 'BillingController@propertyBillPrepare')->name('lgt.property.bills');
    Route::get('property/lgt/prepare/bill/property/bulk', 'BillingController@propertyBillPrepareBulk')->name('lgt.property.bills.bulk');
    Route::get('account/bills/advanced/account/{query?}', 'BillingController@filterBillsQuery')->name('lgt.property.bills.bulk.query');
    Route::get('property/lgt/prepare/bill/business/bulk', 'BillingController@businessBillPrepareBulk')->name('lgt.business.bills.bulk');
    // Route::get('account/bills/advanced/business/{query?}', 'BillingController@filterBillsQuery')->name('lgt.property.bills.bulk.query');
    Route::get('property/lgt/custom/sms', 'SetupController@propertySMS')->name('lgt.property.sms');
    Route::post('property/lgt/custom/sms', 'SetupController@postPropertySMS')->name('lgt.property.sms');
    Route::get('property/lgt/custom/bg/{query?}', 'SetupController@filterPropertySMSQuery')->name('lgt.property.sms.query');
    Route::get('business/lgt/custom/sms', 'SetupController@businessSMS')->name('lgt.business.sms');
    Route::post('business/lgt/custom/sms', 'SetupController@postBusinessSMS')->name('lgt.business.sms');
    Route::get('business/lgt/custom/bg/{query?}', 'SetupController@filterBusinessSMSQuery')->name('lgt.business.sms.query');

    /** Business routes */
    // Route::get('properties', 'PropertyController@index')->name('property.index');
    Route::get('business/types', 'BusinessController@addTypes')->name('business.types');
    Route::post('business/types', 'BusinessController@saveTypes')->name('business.types');
    Route::get('business/categories', 'BusinessController@addCategories')->name('business.categories');
    Route::post('business/categories', 'BusinessController@saveCategories')->name('business.categories');
    Route::get('business/owners', 'BusinessController@addOwners')->name('business.owners');
    Route::post('business/owners', 'BusinessController@saveOwners')->name('business.owners');
    Route::get('business/occupants', 'BusinessController@createOccupants')->name('business.occupants');
    Route::get('business/filter', 'BusinessController@filterBusinessByColumn')->name('business.filter.column');
    Route::resource('business', 'BusinessController');

    /** */
    Route::get('business/records/bills', 'RecordController@getBills')->name('business.records.bills');
    Route::get('prepare/bill/{query}', 'BusinessController@prepareBill')->name('business.prepare.bill');
    Route::get('business/payments/entry', 'RecordController@getpaymentsBusiness')->name('business.payments.payment');
    Route::post('business/payments/entry', 'RecordController@savePaymentBusiness')->name('business.payments.payment');

    /** */
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::post('settings/store', 'SettingsController@store')->name('settings.store');

    Route::get('clients', 'ClientController@index')->name('clients');
    Route::post('clients/store', 'ClientController@store')->name('clients.store');

    /** */
    Route::get('setup/sms', 'SetupController@sms')->name('setups.sms');
    Route::get('setup/sms/business', 'SetupController@bsms')->name('setups.sms.business');
    Route::post('setup/sms', 'SetupController@sendNewSMS1')->name('setups.sms');
    Route::post('setup/property/bills/sms', 'SetupController@sendBillsSMS')->name('setups.property.bills.sms');
    Route::get('setup/filter/sms', 'SetupController@propertyFilterSMS')->name('setups.sms.filter.zonal');

    Route::get('account/bills', 'BillingController@propertyBills')->name('account.bills');
    Route::get('account/fix', 'BillingController@fixingBill')->name('account.fix');
    Route::get('account/bills/filter', 'BillingController@filterBillsByColumn')->name('bills.filter.column');
    Route::post('account/bills', 'BillingController@postBills')->name('account.bills');
    Route::post('account/bills/single', 'BillingController@postBillsPerUnit')->name('account.bills.single');
    Route::post('account/bills/category', 'BillingController@postBillsPerCategory')->name('account.bills.category');
    Route::post('adjust/arrears', 'BillingController@postAdjustArrears')->name('adjust.arrears');
    Route::get('adjust/arrears/property', 'BillingController@adjustArrearsP')->name('adjust.arrears.property');
    Route::get('adjust/arrears/business', 'BillingController@adjustArrearsB')->name('adjust.arrears.business');

    Route::get('processing/response', 'BillingController@processing')->name('processing');
    Route::get('download/links', 'AdvancedReportController@downloadLink')->name('download.link');

    /** */
    Route::get('reports/property/account', 'ReportController@propertyAccountIndex')->name('report.property.account');
    Route::post('reports/property/account', 'ReportController@propertyAccountIndexPost')->name('report.property.account');
    Route::get('reports/business/account', 'ReportController@businessAccountIndex')->name('report.business.account');
    Route::post('reports/business/account', 'ReportController@businessAccountIndexPost')->name('report.business.account');
    Route::get('reports/bills/account', 'ReportController@billsAccountIndex')->name('report.bills.account');
    Route::post('reports/bills/account', 'ReportController@billsAccountIndexPost')->name('report.bills.account');
    Route::get('reports/defaulters', 'AdvancedReportController@defaultersReport')->name('report.defaulters');
    Route::get('reports/adv/defaulters', 'AdvancedReportController@defaultersReportPost')->name('report.defaulters.get');
    Route::get('reports/adv/defaulters/details', 'AdvancedReportController@defaultersReportPostDetails')->name('report.defaulters.details');

    /** */
    // Route::get('print/bills', 'PrintingCardController@bills');
    Route::get('print/bills/{bill}', 'PrintingCardController@bills')->name('init.bill.print');
    Route::get('print/notice', 'PrintingCardController@notice');
    Route::get('auth/print/property/notice', 'PrintingCardController@printPropertyBills')->name('print.property.bills');
    Route::get('auth/print/business/notice', 'PrintingCardController@printBusinessBills')->name('print.business.bills');

    /** */
    Route::get('customize/bill/format', 'PrintingCardController@formatBill')->name('customize.bill.format');
    Route::put('customize/bill/format', 'PrintingCardController@P')->name('customize.bill.format');

    /** */
    Route::get('advanced/report/search/property', 'AdvancedReportController@propertyListingSearch')->name('advanced.report.search.property');
    Route::get('advanced/report/property', 'AdvancedReportController@propertyListing')->name('advanced.report.property');
    Route::get('advanced/report/property/{location}/{query}/{year}', 'AdvancedReportController@propertyListingDetails')->name('advanced.report.property.details');
    Route::get('/api/advanced/report/property', 'AdvancedReportController@test');
    Route::get('/advanced/property/export/{year}/{electoral}/{type?}', 'AdvancedReportController@exportProperty')->name('property.export.excel');


    Route::get('advanced/report/search/business', 'AdvancedReportController@businessListingSearch')->name('advanced.report.search.business');
    Route::get('advanced/report/business', 'AdvancedReportController@businessListing')->name('advanced.report.business');
    Route::get('advanced/report/business/{location}/{query}/{year}', 'AdvancedReportController@businessListingDetails')->name('advanced.report.business.details');
    Route::get('/advanced/business/export/{year}/{electoral}/{type?}', 'AdvancedReportController@exportBusiness')->name('business.export.excel');

    Route::get('advanced/report/search/feefixing', 'AdvancedReportController@feefixingListingSearch')->name('advanced.report.search.feefixing');
    Route::get('advanced/report/feefixing', 'AdvancedReportController@feefixingListing')->name('advanced.report.feefixing');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('fix/collectors', 'FixRequestsController@fixCollectorID')->name('fix.collectors');
Route::get('fix/owners/property', 'FixRequestsController@fixOwnerID1')->name('fix.owners.property');
Route::get('fix/owners/business', 'FixRequestsController@fixOwnerID2')->name('fix.owners.business');
Route::get('fix/enumgcr', 'FixRequestsController@fixCollectorIDEnumGCR')->name('fix.enum');
Route::get('fix/payment', 'FixRequestsController@fixCollectorIDPayment')->name('fix.payment');
Route::get('fix/property/owner', 'FixRequestsController@fixPropertyOwner')->name('fix.property.owner');
Route::get('fix/business/owner', 'FixRequestsController@fixBusinessOwner')->name('fix.business.owner');
Route::get('fix/business/id', 'FixRequestsController@businessID')->name('fix.business.id');
Route::get('fix/property/id', 'FixRequestsController@propertyID')->name('fix.property.id');
Route::get('fix/feefixing/property', 'FixRequestsController@feeFixingProperty')->name('fix.feefixing.property');
Route::get('fix/feefixing/business', 'FixRequestsController@feeFixingBusiness')->name('fix.feefixing.business');

Route::prefix('statements')->group(function () {
    Route::get('index', 'StatementController@index')->name('statements.index');
    Route::get('preview', 'StatementController@preview')->name('statements.preview');
    Route::get('payment', 'StatementController@paymentsIndex')->name('statements.payment.index');
    Route::get('payment/preview', 'StatementController@paymentsPreview')->name('statements.payment.preview');
});

Route::prefix('api/v1/console')->group(function () {
    Route::get('get_data_from/{query}', 'ApiController@getFromData');
    Route::get('get_stock_from/{query}/{id?}', 'ApiController@getFromStock');
    Route::get('get_data_to/{query}', 'ApiController@getToData');
    Route::get('find-gcr/{query}', 'ApiController@findPaymentGcr');
    Route::get('find-gcr-enum/{query}', 'ApiController@findGcr');
    Route::get('get/cashier/gcr/{query}', 'ApiController@getCashierGCR');

    /** */
    Route::get('get_collectors', 'ApiController@getCollectors');
    Route::get('get_cashiers', 'ApiController@getCashiers');

    /**Location apis */
    Route::get('get_zonals', 'ApiController@getZonals');
    Route::get('get_tas', 'ApiController@getTas');
    Route::get('get_electorals', 'ApiController@getElectorals');
    Route::get('get_communities', 'ApiController@getCommunities');
    Route::get('get_units', 'ApiController@getUnits');
    Route::get('get_streets', 'ApiController@getStreets');
    Route::get('get_constituencies', 'ApiController@getConstituencies');

    /** */
    Route::get('get_properties', 'ApiController@getProperties');
    Route::get('get_properties_d', 'ApiController@getPropertiesD');
    Route::get('get_property_types', 'ApiController@getPropertyTypes');
    Route::get('get_property_categories', 'ApiController@getPropertyCategories');
    Route::get('get_property_owners', 'ApiController@getPropertyOwners');
    Route::get('get_property_owner/{id}', 'ApiController@getPropertyOwnerData');
    Route::get('get_property_type/{id}', 'ApiController@getPropertyTypeData');
    Route::get('get_property_category/{id}', 'ApiController@getPropertyCategoryData');
    Route::get('get_categories_property/{id}', 'ApiController@getPropertyTC');

    Route::get('get_property_type_name_2/{id}', 'ApiController@getPropertyTypeName2');
    Route::get('get_property_type_name/{id}', 'ApiController@getPropertyTypeName');
    Route::get('get_property_cat_name/{id}', 'ApiController@getPropertyCatName');
    Route::get('get_property_owner_name/{id}', 'ApiController@getPropertyOwnerName');
    Route::get('get_property_zonal/{id}', 'ApiController@getPropertyZonal');

    Route::get('get_tas_location/{id}', 'ApiController@getTasLocation');
    Route::get('get_electorals_location/{id}', 'ApiController@getElectoralsLocation');
    Route::get('get_communities_location/{id}', 'ApiController@getCommunitiesLocation');


    /** */
    Route::get('get_property_bills/{query}', 'ApiController@getPropertyBills');
    Route::get('get_account_bills/{query}', 'ApiController@getAccountBills');
    Route::get('get_desktop_property_bills/{query}', 'ApiController@getDesktopPropertyBills');
    Route::get('get_collectors_stock/{query}', 'ApiController@getCollectorStock');
    Route::get('get_all_bills', 'ApiController@getAllPropertyBills');
    Route::get('filter_bill_by_ac/{query}/{account?}', 'ApiController@filterBillByAc');

    /** */
    Route::post('save_property_from_mobile', 'ApiController@savePropertyFromMobile');
    Route::get('get_property_from_mobile/{property}', 'ApiController@getPropertyFromMobile');
    Route::get('get_properties_from_mobile/{email}/{number?}', 'ApiController@getPropertiesFromMobile');
    Route::put('update_property_from_mobile/{property}/{owner}', 'ApiController@updatePropertyFromMobile');

    Route::get('get_bulk_location/{street}', 'ApiController@getLocationDataSet');
    Route::get('get_bulk_detail/{category}', 'ApiController@getLocationDataSet');


    /** */
    Route::get('get_businesses', 'BusinessApiController@getBusinesses');
    Route::get('get_businesses_d', 'BusinesspiController@getBusinessesD');
    Route::get('get_business_types', 'BusinessApiController@getBusinessTypes');
    Route::get('get_business_categories', 'BusinessApiController@getBusinessCategories');
    Route::get('get_business_owners', 'BusinessApiController@getBusinessOwners');
    Route::get('get_business_owner/{id}', 'BusinessApiController@getBusinessOwnerData');
    Route::get('get_business_type/{id}', 'BusinessApiController@getBusinessTypeData');
    Route::get('get_business_category/{id}', 'BusinessApiController@getBusinessCategoryData');
    Route::get('get_categories_business/{id}', 'BusinessApiController@getBusinessTC');

    Route::get('get_business_type_name_2/{id}', 'BusinessApiController@getBusinessTypeName');
    Route::get('get_business_type_name/{id}', 'BusinessApiController@getBusinessTypeName2');
    Route::get('get_business_cat_name_2/{id}', 'BusinessApiController@getBusinessCatName2');
    Route::get('get_business_cat_name/{id}', 'BusinessApiController@getBusinessCatName');
    Route::get('get_business_owner_name/{id}', 'BusinessApiController@getBusinessOwnerName');
    Route::get('get_business_zonal/{id}', 'BusinessApiController@getBusinessZonal');


    /** */
    Route::get('get_business_bills/{query}', 'BusinessApiController@getBusinessBills');
    // Route::get('get_collectors_stock/{query}', 'BusinessApiController@getCollectorStock');

    /** */
    Route::post('save_business_from_mobile', 'BusinessApiController@saveBusinessFromMobile');
    Route::get('get_business_from_mobile/{business}', 'BusinessApiController@getBusinessFromMobile');
    Route::get('get_businesses_from_mobile/{email}/{number?}', 'BusinessApiController@getBusinessesFromMobile');
    Route::put('update_business_from_mobile/{business}/{owner}', 'BusinessApiController@updateBusinessFromMobile');

    /** */
    Route::get('get_clients', 'ApiController@getClients');
    Route::get('get_colectors_payment/{collector}/{type}', 'ApiController@getCollectorPaymentStatus');


    Route::get('check_process_status', 'ApiController@checkProcessStatus');
    Route::get('check/link/available', 'AdvancedReportController@checkLinkAvailable');
});
