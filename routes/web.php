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

    use App\Http\Controllers\Backend\ProductController;
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
        Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard_data', [DashboardController::class, 'dashBoardData'])->name('dashboard_data');


//        Route::controller(ProductController::class)->group(function () {
//            Route::get('products',[ 'middleware' => ['permission:product_list'], 'as' => 'products.index'], 'index');
//            Route::get('products/create', [ 'middleware' => ['permission:product_create'], 'as' => 'products.create'], 'create');
//            Route::post('products/store', [ 'middleware' => ['permission:product_create'], 'as' => 'products.store'], 'store');
//            Route::post('products/edit', [ 'middleware' => ['permission:product_edit'], 'as' => 'products.edit'], 'edit');
//            Route::post('products/update', [ 'middleware' => ['permission:product_edit'], 'as' => 'products.update'], 'update');
//            Route::post('products/{id}', [ 'middleware' => ['permission:product_delete'], 'as' => 'products.destroy'], 'destroy');
//        });

            Route::get('product', [ProductController::class, 'index'])->name('product.index')->middleware('permission:product_list');
            Route::get('/product/create', [ProductController::class, 'create'])->name('product.create')->middleware('permission:product_create');
            Route::post('/product/store', [ProductController::class, 'store'])->name('product.store')->middleware('permission:product_create');
            Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit')->middleware('permission:product_edit');
            Route::get('product/show/{id}', [ProductController::class, 'show'])->name('product.show')->middleware('permission:product_view');
            Route::patch('product/update/{id}', [ProductController::class, 'update'])->name('product.update')->middleware('permission:product_edit');
            Route::delete('product/{id}', [ProductController::class, 'destroy'])->name('product.delete')->middleware('permission:product_delete');

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

        });
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
