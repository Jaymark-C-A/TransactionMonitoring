<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\PinMail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pin;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\VisitorQueueController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PendingVisitorController;
use App\Http\Controllers\OfficeDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyResponseController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Request;


Route::post('/handle-date-range', function () {
    // Retrieve the start and end dates from the request
    $startDate = Request::input('startDate');
    $endDate = Request::input('endDate');

    // You can process these dates however you'd like here

    return response()->json([
        'status' => 'success',
        'message' => 'Date range received successfully',
        'startDate' => $startDate,
        'endDate' => $endDate,
    ]);
});




// Get all announcements
Route::get('/announcements', [AnnouncementController::class, 'index']);

// Store a new announcement
Route::post('/announcements', [AnnouncementController::class, 'store']);

// Get a specific announcement
Route::get('/announcements/{id}', [AnnouncementController::class, 'show']);

// Update an announcement
Route::put('/announcements/{id}', [AnnouncementController::class, 'update']);

// Delete an announcement
Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy']);


// Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
// Route::get('/generate-report', [SurveyResponseController::class, 'generateReport']);
Route::post('/get-filtered-visitors', [SurveyResponseController::class, 'filterSurveyResponses']);


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// smtp

Route::get('/test-email', function () {
    \Mail::raw('This is a test email.', function ($message) {
        $message->to('azurin.jaymark.tshs@gmail.com')
                ->subject('Test Email');
    });
    
    return 'Test email sent successfully!';
});



// Feedback report page
Route::get('/super-admin/reports/feedbackReport', function () {
    return view('super-admin.reports.feedbackReport');
})->name('feedback.report')->middleware('auth');

// AJAX route to get feedback data
Route::get('/super-admin/reports/get-feedback', [FeedbackController::class, 'getFeedback'])->name('feedback.get')->middleware('auth');


// Route::get('/fetch-data', 'VisitorController@fetchData')->middleware('auth');

Route::get('/survey-data', [SurveyController::class, 'getSurveyData']);
Route::get('/survey-count', [SurveyController::class, 'getSurveyCount']);

Route::get('/lobbyMonitor', [CustomAuthController::class,'lobbyMonitor']);
// for survey(visitor)
Route::get('/survey', [CustomAuthController::class,'survey']);

Route::post('/storeForm', [CustomAuthController::class, 'storeForm'])->name('feedback.storeForm');
// web.php (routes file)
Route::post('/set-service-start-time', [DataController::class, 'setServiceStartTime']);
Route::get('/get-service-start-time', [DataController::class, 'getServiceStartTime']);
Route::get('/super-admin/view', [DataController::class, 'getServiceStartTime']);
Route::post('/update-status-to-serving', [CustomAuthController::class, 'updateStatusToServing'])->name('updateStatusToServing');

// test of realtime function
Route::get('/api/visitors/today', [VisitorQueueController::class, 'getTodayVisitors']);
Route::get('/api/visitors/served', [VisitorQueueController::class, 'getTodayServed']);
Route::get('/api/visitors/no-show', [VisitorQueueController::class, 'getTodayNoShow']);
Route::get('/api/visitors/serving', [VisitorQueueController::class, 'getTodayServing']);

Route::get('/api/visitors/pending-inform', [VisitorQueueController::class, 'fetchPendingPrincipalVisitors']);

// routes/api.php
Route::get('/api/visitors/{id}', [VisitorQueueController::class, 'show']);
Route::get('/api/feedback/', [VisitorQueueController::class, 'shows']);


Route::get('/visitor-count', [DataController::class, 'getVisitorCount']);
Route::get('/visitor-data', [DataController::class, 'getVisitorData']);

Route::get('/monitor-fetch-data', [DataController::class, 'monitorFetchData']);

// accounting
Route::get('/fetch-data', [DataController::class, 'fetchData']);
Route::post('/next-ticket', [DataController::class, 'nextTicket']);
Route::post('/cancel-ticket', [DataController::class, 'cancelTicket']);
Route::post('/skip-ticket', [DataController::class, 'skipTicket']);

// Emis/Records
Route::get('/fetch-datas', [DataController::class, 'fetchdatas']);
Route::post('/next-ticket1', [DataController::class, 'nextTicket1']);
Route::post('/cancel-ticket1', [DataController::class, 'cancelTicket1']);
Route::post('/skip-ticket1', [DataController::class, 'skipTicket1']);


Route::get('/fetch-dataAdmin', [DataController::class, 'fetchdataAdmin']);
Route::post('/next-ticket2', [DataController::class, 'nextTicket2']);
Route::post('/cancel-ticket2', [DataController::class, 'cancelTicket2']);
Route::post('/skip-ticket2', [DataController::class, 'skipTicket2']);

// Guidance
Route::get('/fetch-datahead', [DataController::class, 'fetchdatahead']);
Route::post('/next-ticket3', [DataController::class, 'nextTicket3']);
Route::post('/cancel-ticket3', [DataController::class, 'cancelTicket3']);
Route::post('/skip-ticket3', [DataController::class, 'skipTicket3']);

// clinic
Route::get('/fetch-dataPrin', [DataController::class, 'fetchdataPrin']);
Route::post('/next-ticket4', [DataController::class, 'nextTicket4']);
Route::post('/cancel-ticket4', [DataController::class, 'cancelTicket4']);
Route::post('/pending-ticket4', [DataController::class, 'pendingTicket4']);
Route::post('/skip-ticket4', [DataController::class, 'skipTicket4']);


// end of test

Route::get('/survey-data', [SurveyController::class, 'getSurveyData']);



// Route::post('/visitors/store', [VisitorController::class, 'store'])->name('visitors.store');
Route::post('/generate-stub', [VisitorController::class, 'store'])->name('visitors.store');
Route::post('/visitor/store', [VisitorController::class, 'store'])->name('visitor.store');

Route::fallback(function () {
    // Redirect users to login if the path doesn't exist
    return redirect()->route('login.view');
});


Route::get('/', function () {
    return view('auth.login');
})->name('login.view');

Route::get('printEx', function () {
    return view('super-admin.reports.printEx');
});
Route::get('printEx', function () {
    return view('TransactionMonitoring.reports.printEx');
});
Route::get('printEx', function () {
    return view('admin.reports.printEx');
});
Route::get('printEx', function () {
    return view('accounting.reports.printEx');
});
Route::get('printEx', function () {
    return view('guidance.reports.printEx');
});
Route::get('/records/reports/printEx', function () {
    return view('records.reports.printEx');
});


Route::get('printEx', [FeedbackController::class, 'show'])->name('administrators.show');

Route::get('records/reports/printEx', [FeedbackController::class, 'show1'])->name('administrators.show1');
Route::get('admin/reports/printEx', [FeedbackController::class, 'show2'])->name('administrators.show2');
Route::get('accounting/reports/printEx', [FeedbackController::class, 'show3'])->name('administrators.show3');
Route::get('guidance/reports/printEx', [FeedbackController::class, 'show4'])->name('administrators.show4');
Route::get('clinic/reports/printEx', [FeedbackController::class, 'show5'])->name('administrators.show5');

    Route::get('users/{user}/archive', [App\Http\Controllers\UserController::class, 'archive'])->name('users.archive');
    Route::get('super-admin/archive', [App\Http\Controllers\UserController::class, 'showArchivedUsers']);

    // Super Admin Route

    Route::get('/super-admin/administrator', [AdministratorController::class, 'index']);

    Route::get('/super-admin/archive', function () {
        return view('super-admin.archive');
    });



    Route::get('/administrators', [AdministratorController::class, 'index'])->name('administrators.index');
    Route::post('/administrators', [AdministratorController::class, 'store'])->name('administrators.store');
    Route::resource('administrators', AdministratorController::class);
    // Display list of administrators
    Route::get('administrators', [AdministratorController::class, 'index'])->name('administrators.index');
    // Store new administrator
    Route::post('administrators', [AdministratorController::class, 'store'])->name('administrators.store');
    // Delete an administrator
    Route::delete('administrators/{id}', [AdministratorController::class, 'destroy'])->name('administrators.destroy');
    // Update an administrator
    Route::put('administrators/{id}', [AdministratorController::class, 'update'])->name('administrators.update');


// Route for handling the login submission
Route::post('/', [AuthController::class, 'login'])->name('login');

Route::post('/profile/picture/upload', [ProfileController::class, 'uploadProfilePicture'])->name('profile.picture.upload');

// profile simple crud func
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edits'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Archive user
    Route::get('/user/{id}/archive', [App\Http\Controllers\UserController::class, 'archive'])->name('users.archive');

    // Show archived users
    Route::get('/super-admin/archive', [App\Http\Controllers\UserController::class, 'showArchivedUsers'])->name('users.archived');

    // Restore user
    Route::get('/users/{user}/restore', [App\Http\Controllers\UserController::class, 'restore'])->name('users.restore');

    // Delete permanently
    Route::get('/user/{id}/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => ['role:Principal']], function() {

    Route::get('/TransactionMonitoring/dashboard', function () {
        return view('TransactionMonitoring.dashboard');
    })->name('TransactionMonitoring.dashboard')->middleware('auth');

    Route::get('/visitorss', [VisitorController::class, 'indexes']);
    
    Route::get('/TransactionMonitoring/reports/transactReport', function () {
        return view('TransactionMonitoring.reports.transactReport');
    })->name('TransactionMonitoring.reports.transactReport');

    Route::get('/TransactionMonitoring/reports/feedbackReport', function () {
        return view('TransactionMonitoring.reports.feedbackReport');
    })->name('TransactionMonitoringn.reports.feedbackReport')->middleware('auth');
    
    Route::get('/TransactionMonitoring/view', function () {
        return view('TransactionMonitoring.view');
    })->middleware('auth');
});


//  Spatie roles and permission
Route::group(['middleware' => ['role:Super-admin']], function() {

    Route::get('/backup', function () {
        return view('backup');
    });
    
    Route::get('database/backup', [BackupController::class, 'index'])->name('database.backup');
    Route::get('database/download', [BackupController::class, 'download'])->name('database.download');
    
    Route::post('/database/upload', [BackupController::class, 'upload'])->name('database.upload');

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);

    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionRole']);

    Route::resource('users', App\Http\Controllers\UserController::class);

    Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

    Route::get('/super-admin/dashboard', function () {
        return view('super-admin.dashboard');
    })->name('super-admin.dashboard')->middleware('auth');

    Route::get('/visitors', [VisitorController::class, 'index']);
    
    Route::get('/super-admin/reports/transactReport', function () {
        return view('super-admin.reports.transactReport');
    })->name('super-admin.reports.transactReport');

    Route::get('/super-admin/reports/feedbackReport', function () {
        return view('super-admin.reports.feedbackReport');
    })->name('super-admin.reports.feedbackReport')->middleware('auth');
    
    Route::get('/super-admin/profile/{id}', [ProfileController::class, 'showSuperAdminProfile'])->name('profile.super-admin');
    
    Route::get('/super-admin/profile', function () {
        $users = User::get();
        $roles = Role::get();
        return view('/super-admin.profile', [
            'users' => $users,
            'roles' => $roles
        ]);
    })->middleware('auth');

    // Account Settings for super-admin
    Route::get('/profile/edit', function () {
        return view('profile.edit');
    });
    Route::get('/super-admin/view', function () {
        return view('super-admin.view');
    })->middleware('auth');
});

//  Spatie roles and permission
Route::group(['middleware' => ['role:Guard']], function() {

// Admin guard Route
Route::get('/admin-guard/dashboard', function () {
    return view('admin-guard.dashboard');
})->name('admin-guard.dashboard');

Route::get('/admin-guard/dashboard/{id}', [ProfileController::class, 'showAdminGuardProfile'])->name('dashboard.admin');

Route::get('/admin-guard/dashboard', function () {
    $users = User::get();
    $roles = Role::get();
    return view('/admin-guard.dashboard', [
        'users' => $users,
        'roles' => $roles
    ]);
})->name('admin-guard.dashboard')->middleware('auth');

Route::get('/admin-guard/dashboard/{id}', [ProfileController::class, 'showOfficeProfile'])->name('admin-guard.dashboard.show');

Route::get('/admin-guard/lobbyMonitor', [CustomAuthController::class,'lobbyMonitor']);

Route::get('/feedback', [CustomAuthController::class,'feedback'])->middleware('auth')->name('feedback.feedback');

});


//  Spatie roles and permission
Route::group(['middleware' => ['role:Clinic']], function() {

    Route::get('/clinic/TransactionHistory', function () {
        return view('clinic.TransactionHistory');
    });
    Route::get('/clinic/TransactionHistory', [VisitorController::class, 'showClinicVisitors']);

    // Clinic Route
    Route::get('/clinic/dashboard', function () {
        return view('clinic.dashboard');
    })->name('clinic.dashboard');
    
    Route::get('/clinic/dashboard/{id}', [ProfileController::class, 'showPrincipalProfile'])->name('clinic.dashboard');

    Route::get('/clinic/dashboard', function () {
        $users = User::get();
        $roles = Role::get();
        return view('/clinic.dashboard', [
            'users' => $users,
            'roles' => $roles
        ]);
    })->name('clinic.dashboard')->middleware('auth');

    Route::get('/clinic/dashboard/{id}', [ProfileController::class, 'showOfficeProfile'])->name('principal.dashboard.show');

    
    // monitor for clinic
    Route::get('/clinic/monitor', function () {
        return view('/clinic.monitor');
    })->middleware('auth');

    Route::get('/visitorClinic', [VisitorController::class, 'index4']);
    
    Route::get('/clinic/reports/transactReport', function () {
        return view('clinic.reports.transactReport');
    })->name('clinic.reports.transactReport');

    Route::get('/clinic/reports/feedbackReport', function () {
        return view('clinic.reports.feedbackReport');
    })->name('clinic.reports.feedbackReport')->middleware('auth');
    
    });

// Department Head Routes
Route::group(['middleware' => ['role:Guidance']], function() {

    Route::get('/guidance/TransactionHistory', function () {
        return view('guidance.TransactionHistory');
    });
    Route::get('/guidance/TransactionHistory', [VisitorController::class, 'showGuidanceVisitors']);

    Route::get('/guidance/dashboard', function () {
        return view('guidance.dashboard');
    })->name('guidance.dashboard');

    Route::get('/guidance/dashboard/{id}', [ProfileController::class, 'showHeadProfile'])->name('guidance.dashboard');

    Route::get('/guidance/dashboard', function () {
        $users = User::all();
        $roles = Role::all();
        return view('guidance.dashboard', [
            'users' => $users,
            'roles' => $roles,
        ]);
    })->name('guidance.dashboard')->middleware('auth');

    Route::get('/guidance/dashboard/{id}', [ProfileController::class, 'showOfficeProfile'])->name('guidance.dashboard.show');

    // monitor for admin
    Route::get('/guidance/monitor', function () {
        return view('/guidance.monitor');
    })->middleware('auth');

    Route::get('/visitorGui', [VisitorController::class, 'index5']);
    
    Route::get('/guidance/reports/transactReport', function () {
        return view('guidance.reports.transactReport');
    })->name('guidance.reports.transactReport');

    Route::get('/guidance/reports/feedbackReport', function () {
        return view('guidance.reports.feedbackReport');
    })->name('guidance.reports.feedbackReport')->middleware('auth');
});  

// Admin Routes
Route::group(['middleware' => ['role:Admin']], function() {

    Route::get('/admin/TransactionHistory', function () {
        return view('admin.TransactionHistory');
    });
    Route::get('/admin/TransactionHistory', [VisitorController::class, 'showAdminVisitors']);

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/dashboard/{id}', [ProfileController::class, 'showAdminProfile'])->name('admin.dashboard');

    Route::get('/admin/dashboard', function () {
        $users = User::all();
        $roles = Role::all();
        return view('admin.dashboard', [
            'users' => $users,
            'roles' => $roles,
        ]);
    })->name('admin.dashboard')->middleware('auth');

    Route::get('/admin/dashboard/{id}', [ProfileController::class, 'showOfficeProfile'])->name('admin.dashboard.show');

    // monitor for admin
    Route::get('/admin/monitor', function () {
        return view('/admin.monitor');
    })->middleware('auth');

    Route::get('/visitor2', [VisitorController::class, 'index2']);
    
    Route::get('/admin/reports/transactReport', function () {
        return view('admin.reports.transactReport');
    })->name('admin.reports.transactReport');

    Route::get('/admin/reports/feedbackReport', function () {
        return view('admin.reports.feedbackReport');
    })->name('admin.reports.feedbackReport')->middleware('auth');

});

// Accounting Routes
Route::group(['middleware' => ['role:Accounting']], function() {

    Route::get('/accounting/TransactionHistory', function () {
        return view('accounting.TransactionHistory');
    });
    Route::get('/accounting/TransactionHistory', [VisitorController::class, 'showAccountingVisitors']);

    Route::get('/accounting/dashboard', function () {
        return view('accounting.dashboard');
    })->name('accounting.dashboard');

    Route::get('/accounting/dashboard/{id}', [ProfileController::class, 'showAccountingProfile'])->name('accounting.dashboard');

    Route::get('/accounting/dashboard', function () {
        $users = User::all();
        $roles = Role::all();
        return view('accounting.dashboard', [
            'users' => $users,
            'roles' => $roles,
        ]);
    })->name('accounting.dashboard')->middleware('auth');

    // monitor for admin
    Route::get('/accounting/monitor', function () {
        return view('/accounting.monitor');
    })->middleware('auth');

    Route::get('/accounting/dashboard/{id}', [ProfileController::class, 'showOfficeProfile'])->name('accounting.dashboard.show');

    Route::get('/visitorAcc', [VisitorController::class, 'index3']);
    
    Route::get('/accounting/reports/transactReport', function () {
        return view('accounting.reports.transactReport');
    })->name('accounting.reports.transactReport');

    Route::get('/accounting/reports/feedbackReport', function () {
        return view('accounting.reports.feedbackReport');
    })->name('accounting.reports.feedbackReport')->middleware('auth');


});

// Records Routes
Route::group(['middleware' => ['role:Records']], function() {

    Route::get('/records/TransactionHistory', function () {
        return view('records.TransactionHistory');
    });
    Route::get('/records/TransactionHistory', [VisitorController::class, 'showRecordsVisitors']);

    Route::get('/records/dashboard', function () {
        return view('records.dashboard');
    })->name('records.dashboard');

    Route::get('/records/dashboard/{id}', [ProfileController::class, 'showRecordProfile'])->name('records.dashboard');

    Route::get('/records/dashboard', function () {
        $users = User::all();
        $roles = Role::all();
        return view('records.dashboard', [
            'users' => $users,
            'roles' => $roles,
        ]);
    })->name('records.dashboard')->middleware('auth');

    // monitor for admin
    Route::get('/records/monitor', function () {
        return view('/records.monitor');
    });

    Route::get('/records/dashboard/{id}', [ProfileController::class, 'showRecordProfile'])->name('records.dashboard.show');

    Route::get('/visitorRec', [VisitorController::class, 'index6']);
    
    Route::get('/records/reports/transactReport', function () {
        return view('records.reports.transactReport');
    })->name('records.reports.transactReport');

    Route::get('/records/reports/feedbackReport', function () {
        return view('records.reports.feedbackReport');
    })->name('records.reports.feedbackReport')->middleware('auth');
});

//OfficesDahboar Routes

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [OfficeDashboardController::class, 'index']);
    Route::get('/dashboard/monthly', [OfficeDashboardController::class, 'getMonthlyVisitors']);
});
