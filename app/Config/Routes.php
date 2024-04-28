<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Authentication
$routes->get('/login', 'auth\LoginController::index',['filter' => 'usercheck']);

$routes->get('/register', 'auth\RegisterController::index');


//Admin Panel
$routes->get('/', 'Home::index');


$routes->add('view-user', 'ViewUserController::index',['filter' => 'authGuard']);
$routes->add('view-transaction', 'ViewTransactionController::index',['filter' => 'authGuard']);
$routes->add('view-rfa', 'ViewRFA::index',['filter' => 'authGuard']);

//Sign out
$routes->get('api/auth/sign_out', 'api\Auth::sign_out');
//Login
$routes->post('api/auth/verify', 'api\Auth::verify');

//Admin Panel
$routes->group('admin', ['filter' => 'authGuard'], function($routes) {
    $routes->add('dashboard', 'admin\DashboardController::index');
    $routes->add('rfa-dashboard', 'admin\RFADashboardController::index');
    $routes->add('completed-transactions', 'admin\CompletedTransactionsController::index');
    $routes->add('pending-transactions', 'admin\PendingTransactionsController::index');
    $routes->add('cso', 'admin\CsoController::index',['filter' => 'authGuard']);
    $routes->add('responsibility-center', 'admin\ResponsibilityCenterController::index');
    $routes->add('responsible-section', 'admin\ResponsibleSectionController::index');
    $routes->add('type-of-activity', 'admin\TypeofActivityController::index');
    $routes->add('users', 'admin\UserController::index');
    $routes->add('completed-rfa', 'admin\CompletedRFAController::index');
    $routes->add('pending-rfa', 'admin\PendingRFAController::index');
    $routes->add('back-up-database', 'admin\BackupDatabaseController::index');
    $routes->add('activity-logs', 'admin\ActivityLogsController::index');
    $routes->add('type-of-request', 'admin\TypeofRequestController::index');
    $routes->add('clients', 'ClientsController::index');


    $routes->add('cso/view-officers', 'admin\CsoController::view_officers');
    $routes->add('cso/cso-information', 'admin\CsoController::view_cso');
});







//User Panel
$routes->group('user', ['filter' => 'authGuard'], function($routes) {
    $routes->add('dashboard', 'user\DashboardController::index');
    $routes->add('rfa-dashboard', 'user\RFADashboardController::index');
    $routes->add('completed-transactions', 'user\CompletedTransactionsController::index');
    $routes->add('pending-transactions', 'user\PendingTransactionsController::index');
    $routes->add('completed-rfa', 'user\CompletedRFAController::index');
    $routes->add('pending-rfa', 'user\PendingRFAController::index');
    $routes->add('activity-logs', 'user\ActivityLogsController::index');

    $routes->add('request-for-assistance', 'user\RequestForAssistanceController::index');
    $routes->add('clients', 'ClientsController::index');
    $routes->add('referred', 'user\ReferredController::index');

    $routes->add('calendar-of-activities', 'user\CalendarController::index');

    $routes->add('rfa/received', 'user\ReceivedController::index');
    $routes->add('rfa/track', 'user\TrackRFAController::index');


    $routes->add('pending-transactions/add-transaction', 'user\PendingTransactionsController::add_transaction');
    $routes->add('update-pmas', 'user\PendingTransactionsController::update_transaction');

    $routes->add('pending/update-rfa', 'user\PendingRFAController::update_rfa');

});




$routes->group('api', ['filter' => 'authGuard'], function($routes) {

    //Admin Actions

    //Database
    $routes->post('back-up-db', 'api\BackupDB::index');
    $routes->post('get-database', 'api\BackupDB::get_database');


    //Users
    $routes->post('register', 'api\Users::register');
    $routes->post('add-user', 'api\Users::add_user');
    $routes->post('get-active-user', 'api\Users::get_user_active');
    $routes->post('get-inactive-user', 'api\Users::get_user_inactive');
    $routes->post('update-user-status', 'api\Users::update_user_status');
    $routes->post('get-user-data', 'api\Users::get_user_data');
    $routes->post('update-user-information', 'api\Users::update_user_information');

    $routes->post('update-user-profile', 'api\Users::update_user_profile');

    $routes->post('delete-user', 'api\Users::delete_user');



    $routes->post('verify-old-password', 'api\Users::verify_old_password');
    $routes->post('update-password', 'api\Users::update_password');
    //CSO
    $routes->post('add-cso', 'api\Cso::add_cso');
    $routes->post('get-cso', 'api\Cso::get_cso');
    $routes->post('delete-cso', 'api\Cso::delete_cso');


    $routes->post('get-cso-infomation', 'api\Cso::get_cso_information');
    $routes->post('update-cso-information', 'api\Cso::update_cso_information');
    $routes->post('update-cso-status', 'api\Cso::update_cso_status');

    $routes->post('upload-cso-file', 'api\Cso::upload_cso_file');

    
    $routes->post('get-cor', 'api\Cso::get_cso_cor');
    $routes->post('get-bylaws', 'api\Cso::get_cso_bylaws');
    $routes->post('get-aoc', 'api\Cso::get_cso_aoc');



    //CSO Officers
    $routes->post('add-officer', 'api\Cso::add_cso_officer');
    $routes->post('get-officers', 'api\Cso::get_officers');
    $routes->post('update-officer-information', 'api\Cso::update_officer');
    $routes->post('delete-cso-officer', 'api\Cso::delete_cso_officer');


    //Add Implemented Project
    $routes->post('add-project', 'api\Cso::add_project');
    $routes->post('get-projects', 'api\Cso::get_projects');
    $routes->post('update-project', 'api\Cso::update_project');
    $routes->post('delete-cso-project', 'api\Cso::delete_project');


    $routes->post('generate-for-print', 'api\Cso::generate_for_print');



    $routes->post('count-cso-per-barangay', 'api\Cso::count_cso_per_barangay');

    //Responsibility Center
    $routes->post('add-responsibility', 'api\Responsibility::add_responsibiliy');
    $routes->post('get-responsiblity', 'api\Responsibility::get_responsibility');
    $routes->post('delete-center', 'api\Responsibility::delete_responsibility');
    $routes->post('update-center', 'api\Responsibility::update_responsibility');


    //Responsible Section
    $routes->post('add-responsible', 'api\ResponsibleSection::add_responsible');
    $routes->post('get-responsible', 'api\ResponsibleSection::get_responsible');
    $routes->post('delete-responsible', 'api\ResponsibleSection::delete_responsible');
    $routes->post('update-responsible', 'api\ResponsibleSection::update_responsible');


    //Type of Activity
    $routes->post('add-type-of-activity', 'api\TypeOfActivity::add_type_of_activity');
    $routes->post('get-activities', 'api\TypeOfActivity::get_activities');
    $routes->post('delete-activity','api\TypeOfActivity::delete_activity');
    $routes->post('update-type-of-activity','api\TypeOfActivity::update_activity');

    //Under Type of Activity 
    $routes->post('add-under-type-of-activity', 'api\TypeOfActivity::add_under_type_of_activity');
    $routes->post('get_under_type_of_activity', 'api\TypeOfActivity::get_under_type_of_activity');
    $routes->post('delete-under-activity','api\TypeOfActivity::delete_under_activity');
    $routes->post('update-under-type-of-activity','api\TypeOfActivity::update_under_activity');

    //Type of Request
    $routes->post('add-type-of-request', 'api\TypeofRequest::add_type_of_request');
    $routes->post('get-request', 'api\TypeofRequest::get_request');
    $routes->post('update-type-of-request', 'api\TypeofRequest::update_request');
    $routes->post('delete-request','api\TypeOfRequest::delete_request');


    //RFA Pending Transactions

    $routes->post('get-admin-pending-rfa','api\PendingRFATransactions::get_admin_pending_rfa_transactions');


    //Pending Transactions
    $routes->post('admin/get-admin-pending-transactions', 'api\PendingTransactions::get_admin_pending_transactions');
    $routes->post('admin/add-remark', 'api\PendingTransactions::add_remark');

    //Generate PMAS Report
    $routes->post('admin/generate-pmas-report', 'api\Transactions::generate_pmas_report');
    $routes->post('admin/generate-rfa-report', 'api\CompletedRFATransactions::generate_rfa_report');
    $routes->post('admin/get_total_report', 'api\Transactions::get_total_report');

    //Admin Dashboard
    $routes->post('load-admin-chart-transaction-data', 'api\Transactions::get_admin_chart_transaction_data');
    $routes->post('load-admin-chart-cso-data', 'api\Cso::get_admin_chart_cso_data');

    $routes->post('get-pending-transaction-limit', 'api\PendingTransactions::get_admin_pending_transaction_limit');
    $routes->post('get-pending-rfa-transaction-limit', 'api\PendingRFATransactions::get_admin_pending_rfa_transaction_limit');


    $routes->post('load-admin-chart-rfa-transaction-data', 'api\CompletedRFATransactions::get_admin_chart_rfa_transaction_data');


    $routes->post('count-pending-transactions', 'api\PendingTransactions::count_pending_transactions');
    $routes->post('get-rfa-data', 'api\PendingRFATransactions::get_rfa_data');

    $routes->post('view-rfa-data', 'api\PendingRFATransactions::view_rfa_data');

    $routes->post('refer-to', 'api\PendingRFATransactions::refer_to');

    //User Api:
    $routes->post('get-last-pmas-number', 'api\PendingTransactions::get_last_pmas_number');
    $routes->post('get-last-reference-number', 'api\PendingRFATransactions::get_last_ref_number');

    //Pending Transactions
    $routes->post('add-transaction', 'api\PendingTransactions::add_transaction');
    $routes->post('user/get-user-pending-transactions', 'api\PendingTransactions::get_user_pending_transactions');
    $routes->post('user/delete-transaction', 'api\PendingTransactions::user_delete_transaction');
    $routes->post('get-transaction-data', 'api\PendingTransactions::get_transaction_data');


    $routes->post('update-transaction', 'api\PendingTransactions::update_transaction');



    $routes->post('pass-pmas', 'api\PendingTransactions::pass_pmas');


    $routes->post('view-remark', 'api\PendingTransactions::view_remark');
    $routes->post('accomplished', 'api\PendingTransactions::accomplished');
    $routes->post('completed', 'api\PendingTransactions::update_completed');


    //Completed RFA
    $routes->post('user/get-user-completed-rfa', 'api\CompletedRFATransactions::get_user_completed_transactions');


    //Completed Transactions
    $routes->post('get-all-transactions', 'api\Transactions::get_all_transactions');
    $routes->post('get-project-transaction-data', 'api\Transactions::get_project_transaction_data');
    $routes->post('user/get-user-completed-transactions', 'api\Transactions::get_user_completed_transactions');


    //User Dashboard
    $routes->post('load-user-chart-transaction-data', 'api\Transactions::get_user_chart_transaction_data');
    $routes->post('load-user-chart-rfa-transaction-data', 'api\CompletedRFATransactions::get_user_chart_rfa_transaction_data');

    ///Client
    $routes->post('search-names', 'api\Clients::search_name');
    $routes->post('add-client', 'api\Clients::add_client');
    $routes->post('get-clients', 'api\Clients::get_clients');
    $routes->post('delete-client', 'api\Clients::delete_client');
    $routes->post('update-client', 'api\Clients::update_client');


    //For RFA Dashbaord Gender Total
    $routes->post('bygender-total', 'api\Clients::get_by_gender_total');
    $routes->post('l-g-c-b-m', 'api\Clients::load_gender_client_by_month');

    //RFA
    $routes->post('add-rfa', 'api\PendingRFATransactions::add_rfa');
    $routes->post('get-all-rfa-transactions', 'api\CompletedRFATransactions::get_all_rfa_transactions');
    $routes->post('get-user-pending-rfa', 'api\PendingRFATransactions::get_user_pending_rfa_transactions');

    $routes->post('update-rfa', 'api\PendingRFATransactions::update_rfa');

    $routes->post('get-user-pending-rfa', 'api\PendingRFATransactions::get_user_pending_rfa_transactions');

    $routes->post('view-action', 'api\PendingRFATransactions::view_action');
    $routes->post('view-action-taken', 'api\PendingRFATransactions::view_action_taken');


    $routes->post('approved-rfa', 'api\PendingRFATransactions::approved_rfa');

    $routes->post('get-user-reffered-rfa', 'api\PendingRFATransactions::get_user_referred_rfa');
    $routes->post('count-reffered-rfa', 'api\PendingRFATransactions::count_reffered_rfa');
    $routes->post('accomplish-rfa', 'api\PendingRFATransactions::accomplished');

    $routes->post('received-rfa', 'api\PendingRFATransactions::received_rfa');

    $routes->post('add-rfa-action-taken', 'api\PendingRFATransactions::add_rfa_action_taken');


    $routes->post('count-pending-rfa', 'api\PendingRFATransactions::count_pending_rfa');


    $routes->post('get-pmas-activities', 'api\PendingTransactions::get_pmas_activities');


});











/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
