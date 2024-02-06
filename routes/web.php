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

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Route;

    //use App\Http\Middleware\Logger;

    Route::get('/welcome', function () {
        return view('welcome');
    });

    Route::get('/', function () {
        return redirect('/dashboard');
    });
    Route::get('/maktoob', function () {
        return redirect('/index');
    });

    // FC9 routes

    Route::post('/login', '\App\Http\Controllers\CustomLoginController@login');

    Route::get('/forbidden', function () {
        return view('forbidden');
    })->name('forbidden');

    Route::middleware(['logger'])->group(function () {
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard_data', [DashboardController::class, 'dashBoardData'])->name('dashboard_data');


        // General Routes


    //Documents routes
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index')->middleware('permission:document_list');
        Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create')->middleware('permission:document_create');
        Route::post('/documents/store', [DocumentController::class, 'store'])->name('documents.store')->middleware('permission:document_create');
        Route::get('documents/edit/{document}', [DocumentController::class, 'edit'])->name('documents.edit')->middleware('permission:document_edit');
        Route::get('documents/show/{document}', [DocumentController::class, 'show'])->name('documents.show')->middleware('permission:document_view');
        Route::get('documents/details/{document}', [DocumentController::class, 'details'])->name('documents.details')->middleware('permission:document_view');
        Route::patch('documents/update/{document}', [DocumentController::class, 'update'])->name('documents.update')->middleware('permission:document_edit');
        Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.delete')->middleware('permission:document_delete');

    //Tracker routes

        Route::get('/trackers', [TrackerController::class, 'index'])->name('trackers.index')->middleware('permission:tracker_list');
        Route::get('/trackers/create', [TrackerController::class, 'create'])->name('trackers.create')->middleware('permission:tracker_create');
        Route::post('/trackers/store', [TrackerController::class, 'store'])->name('trackers.store')->middleware('permission:tracker_create');
        Route::get('trackers/edit/{tracker}', [TrackerController::class, 'edit'])->name('trackers.edit')->middleware('permission:tracker_edit');
        Route::get('trackers/show/{tracker}', [TrackerController::class, 'show'])->name('trackers.show')->middleware('permission:tracker_view');
        Route::patch('trackers/update/{tracker}', [TrackerController::class, 'update'])->name('trackers.update')->middleware('permission:tracker_edit');
        Route::delete('trackers/{tracker}', [TrackerController::class, 'destroy'])->name('trackers.delete')->middleware('permission:tracker_delete');

        Route::get('trackers/attachments/{tracker}', [TrackerController::class, 'attachments'])->name('trackers.attachments')->middleware('permission:tracker_view');
        Route::get('trackers/receivers/{tracker}', [TrackerController::class, 'receivers'])->name('trackers.receivers')->middleware('permission:tracker_view');
        Route::get('trackers/refresh/{document_id}', [TrackerController::class, 'reloadTrackers'])->name('trackers.reload');

    //SuggestionRoutes
        Route::get('/suggestions', [SuggestionController::class, 'index'])->name('suggestions.index');

        Route::patch('/tracker/updateIsChecked/{id}', [TrackerController::class, 'updateIsChecked'])->name('trackers.updateIsChecked');
        Route::patch('/tracker/update-status/{id}', [TrackerController::class, 'updateStatus'])->name('trackers.update-status');

    //SecurityLevels routes
        Route::get('/security-levels', [SecurityLevelController::class, 'index'])->name('security-levels.index')->middleware('permission:security_level_list');
        Route::get('/security-levels/create', [SecurityLevelController::class, 'create'])->name('security-levels.create')->middleware('permission:security_level_create');
        Route::post('/security-levels/store', [SecurityLevelController::class, 'store'])->name('security-levels.store')->middleware('permission:security_level_create');
        Route::get('security-levels/edit/{security_level}', [SecurityLevelController::class, 'edit'])->name('security-levels.edit')->middleware('permission:security_level_edit');
        Route::patch('security-levels/update/{security_level}', [SecurityLevelController::class, 'update'])->name('security-levels.update')->middleware('permission:security_level_edit');
        Route::delete('security-levels/{id}', [SecurityLevelController::class, 'destroy'])->name('security-levels.delete')->middleware('permission:security_level_delete');

    //DocumentTypes routes
        Route::get('/document-types', [DocTypeController::class, 'index'])->name('document-types.index')->middleware('permission:document_type_list');
        Route::get('/document-types/create', [DocTypeController::class, 'create'])->name('document-types.create')->middleware('permission:document_type_create');
        Route::post('/document-types/store', [DocTypeController::class, 'store'])->name('document-types.store')->middleware('permission:document_type_create');
        Route::get('document-types/edit/{documentType}', [DocTypeController::class, 'edit'])->name('document-types.edit')->middleware('permission:document_type_edit');
        Route::patch('document-types/update/{documentType}', [DocTypeController::class, 'update'])->name('document-types.update')->middleware('permission:document_type_edit');

    //Status routes
        Route::get('/document-status', [StatusController::class, 'index'])->name('document-status.index')->middleware('permission:document_status_list');
        Route::get('/document-status/create', [StatusController::class, 'create'])->name('document-status.create')->middleware('permission:document_status_create');
        Route::post('/document-status/store', [StatusController::class, 'store'])->name('document-status.store')->middleware('permission:document_status_create');
        Route::get('document-status/edit/{status}', [StatusController::class, 'edit'])->name('document-status.edit')->middleware('permission:document_status_edit');
        Route::patch('document-status/update/{status}', [StatusController::class, 'update'])->name('document-status.update')->middleware('permission:document_status_edit');

    //deadline routes

        Route::get('/fetch-deadlines', [DeadlineController::class, 'index'])->name('fetch-deadlines');

        //followupTypes routes
        Route::get('/followup-types', [FollowupTypeController::class, 'index'])->name('followup-types.index')->middleware('permission:followup_type_list');
        Route::get('/followup-types/create', [FollowupTypeController::class, 'create'])->name('followup-types.create')->middleware('permission:followup_type_create');
        Route::post('/followup-types/store', [FollowupTypeController::class, 'store'])->name('followup-types.store')->middleware('permission:followup_type_create');
        Route::get('followup-types/edit/{followupType}', [FollowupTypeController::class, 'edit'])->name('followup-types.edit')->middleware('permission:followup_type_edit');
        Route::patch('followup-types/update/{followupType}', [FollowupTypeController::class, 'update'])->name('followup-types.update')->middleware('permission:followup_type_edit');

    //External Directorate routes
        Route::get('/external-directorates', [ExternalDirectorateController::class, 'index'])->name('external-directorates.index')->middleware('permission:external_directorate_list');
        Route::get('/external-directorates/create', [ExternalDirectorateController::class, 'create'])->name('external-directorates.create')->middleware('permission:external_directorate_create');
        Route::post('/external-directorates/store', [ExternalDirectorateController::class, 'store'])->name('external-directorates.store')->middleware('permission:external_directorate_create');
        Route::get('external-directorates/edit/{externalDir}', [ExternalDirectorateController::class, 'edit'])->name('external-directorates.edit')->middleware('permission:external_directorate_edit');
        Route::patch('external-directorates/update/{externalDir}', [ExternalDirectorateController::class, 'update'])->name('external-directorates.update')->middleware('permission:external_directorate_edit');
        Route::delete('external-directorates/{externalDir}', [ExternalDirectorateController::class, 'destroy'])->name('external-directorates.delete')->middleware('permission:external_directorate_delete');

    //users routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:user_list');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('permission:user_create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store')->middleware('permission:user_create');
        Route::get('user/edit/{user}', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:user_edit');
        Route::get('user/show/{id}', [UserController::class, 'show'])->name('user.show')->middleware('permission:user_view');
        Route::patch('user/update/{id}', [UserController::class, 'update'])->name('user.update')->middleware('permission:user_edit');
        Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.delete')->middleware('permission:user_delete');
        Route::post('user/deactivate/{id}', [UserController::class, 'deactivate'])->name('user.deactivate')->middleware('permission:user_delete');
        Route::post('/user/changePassword', [UserController::class, 'changePassword'])->name('user.changePassword')->middleware('permission:user_create');

    //role routes
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:role_list');
        Route::get('/role/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:role_create');
        Route::post('/role/store', [RoleController::class, 'store'])->name('role.store')->middleware('permission:role_create');
        Route::get('role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('permission:role_edit');
        Route::get('role/show/{id}', [RoleController::class, 'show'])->name('role.show')->middleware('permission:role_view');
        Route::patch('role/update/{id}', [RoleController::class, 'update'])->name('role.update')->middleware('permission:role_edit');
        Route::delete('role/{id}', [RoleController::class, 'destroy'])->name('role.delete')->middleware('permission:role_delete');

    // Doc Mgt System Routing start
        Route::get('/maktoob', [MaktobController::class, 'index'])->name('index');
        Route::get('/get-dropdown-items', [DTSController::class, 'getDropdownItems'])->name('get-dropdown-items');
        Route::post('/upload', [AttachmentController::class, 'store'])->name('upload');
        Route::get('check_email', [DTSController::class, 'checkEmail'])->name('check_email');
        Route::get('get-deputy-directorates', [DTSController::class, 'getDeputyDirectorates'])->name('get-deputy-directorates');
        Route::get('get-directorate-users', [DTSController::class, 'getDirectorateUsers'])->name('get-directorate-users');


        Route::get('get-general-dir-directorates', [DTSController::class, 'getGeneralDirDirectorates'])->name('get-general-dir-directorates');


        Route::get('get-directorate-employees', [DTSController::class, 'getDirectorateEmployees'])->name('get-directorate-employees');
        Route::get('search-users', [DTSController::class, 'searchUser'])->name('search-users');
        Route::post('comment.store', [CommentController::class, 'store'])->name('comment.store');
        Route::delete('comment/{id}', [CommentController::class, 'destroy'])->name('user.delete')->middleware('permission:user_delete');
        Route::patch('comment/update/{id}', [CommentController::class, 'update'])->name('comment.update');
        Route::patch('reply/update/{id}', [ReplyController::class, 'update'])->name('reply.update');
        Route::post('comment/reply/{parent_id}', [ReplyController::class, 'store'])->name('comment.reply');
        Route::get('/search', [DTSController::class, 'search'])->name('search');
        Route::delete('/comment/delete-reply/{commentId}/{replyId}', [ReplyController::class, 'destroy'])->name('comment.delete-reply');
//        Route::delete('/comment/delete-reply/{commentId}/{replyId}', 'ReplyController@destroy')->name('comment.delete-reply');


        Route::post('flow', [DTSController::class, 'flow'])->name('flow');

        Route::get('/notification/{id}', [UserController::class, 'readNotification'])->name('read-notification');

        // End of Doc Mgt System
        Route::get('/general', function () {
            return view('reports.general');
        });
        Route::get('/404', function () {
            return view('404');
        });


        Route::get('/form-wizard', function () {
            return view('form-wizard');
        });
        Route::get('/process', function () {
            return view('process');
        });

        Route::get('download/{id}', [AttachmentController::class, 'download'])->name('download');
        Route::get('reports', [ReportsController::class, 'report'])->name('reports.index');
        Route::get('get-report-data', [ReportsController::class, 'getReportData'])->name('get-report-data');
        Route::get('excel', [ExcelController::class, 'export'])->name('excel');
        Route::get('print-receipt/{document_id}', [DocumentController::class, 'printReceipt'])->name('print-receipt');
//        Route::get('check-userName', [DTSController::class, 'checkUserName'])->name('check-userName');
// web.php
        Route::post('/check-username', [UserController::class,'checkUsername']);

    //language
        Route::get('lang.switch/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

    });
