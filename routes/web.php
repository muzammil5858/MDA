<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AttchementController;
use App\Http\Controllers\PlotHistoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QAController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClerkController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DDController;
use App\Http\Controllers\FrontDeskController;
use App\Http\Controllers\HDMController;
use App\Http\Controllers\ADCivilController;
use App\Http\Controllers\DDCivilController;
use App\Http\Controllers\EngineerController;
use Illuminate\Support\Facades\Route;

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

Route::post('/dummy-dashboard',[QAController::class, 'dashboard'])->name('thumb.login')->middleware('VerifyRequestDomain');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/captcha', [CaptchaController::class, 'generateCaptcha'])->name('captcha.generate');
Route::post('/captcha/validate', [CaptchaController::class, 'validateCaptcha'])->name('captcha.validate');
Route::post('/temp-store',[PropertyController::class,'tempStore'])->name('tempStore');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::middleware('auth')->group(function () {

    Route::get('/form', [PropertyController::class, 'create'])->name('form');
    Route::post('/submit-form', [PropertyController::class, 'store'])->name('formSubmission');

    Route::get('/form-list', [PropertyController::class, 'formList'])->name('formList');
    Route::get('/form-detail/{id}', [PropertyController::class, 'formDetail'])->name('formDetail');
    Route::get('/form-edit/{id}', [PropertyController::class, 'formEdit'])->name('formEdit');
    Route::post('/update-form/{id}', [PropertyController::class, 'update'])->name('formUpdate');
    Route::get('/form-delete/{id}', [PropertyController::class, 'formDelete'])->name('formDelete');

    // Standalone step-wise edit endpoints (optional)
    Route::put('/payment/{propertyId}', [PaymentController::class, 'update'])->name('payment.update');

    Route::post('/plot-history/{propertyId}', [PlotHistoryController::class, 'store'])->name('plotHistory.store');
    Route::put('/plot-history/{id}', [PlotHistoryController::class, 'update'])->name('plotHistory.update');
    Route::delete('/plot-history/{id}', [PlotHistoryController::class, 'destroy'])->name('plotHistory.destroy');

    Route::post('/attachment/{propertyId}', [AttchementController::class, 'update'])->name('attachment.update');
});

// QA Routes

Route::middleware('auth')->group(function (){
    Route::get('/dashboard', [QAController::class, 'dashboard'])->name('dashboard');
    Route::get('/sector-requests-count', [QAController::class, 'getSectorCounts']);
    Route::get('/Files', [QAController::class, 'qaFiles'])->name('qaFiles');
    Route::get('/entry-files', [QAController::class, 'entryFiles'])->name('entryFiles');

});
Route::get('/excel-sheet', [QAController::class, 'excel'])->name('excel');


// User Routes

Route::middleware('auth')->group(function (){
    Route::post('/transfer-property/{id}', [UsersController::class, 'store'])->name('transfer_property');
    Route::get('/transfer-file/{id}', [UsersController::class, 'transferFile'])->name('transfer_file');
    Route::get('/transfer-file-edit/{id}', [UsersController::class, 'transferFileEdit'])->name('transfer_edit');
    Route::post('/transfer-file-update/{id}', [UsersController::class, 'transferFileupdate'])->name('transfer_update');
    Route::get('/properties-list', [UsersController::class, 'propertyList'])->name('property_list');
    Route::get('/book-appointment', [UsersController::class, 'bookAppointment'])->name('bookAppointment');
    Route::get('/appointment-book-list', [UsersController::class, 'Appointmentbook'])->name('AppointmentBook');
    Route::post('/appointment-detail', [UsersController::class, 'appointmentDetail'])->name('appointmentDetail');
    Route::post('/appointment', [UsersController::class, 'appointment'])->name('appointment');
    Route::get('/booked-appointment', [UsersController::class, 'bookedAppointment'])->name('bookedAppointment');
    Route::get('/track-application', [UsersController::class, 'trackApplication'])->name('trackApplication');
    Route::get('/track-property/{id}', [UsersController::class, 'propertyTracking'])->name('propertyTracking');


});

// Record-clerks Routes

Route::middleware('auth')->group(function (){
    Route::get('/transfer-request-file', [ClerkController::class, 'transferFileList'])->name('transferRequest_list');
    Route::get('/accepted-request-file', [ClerkController::class, 'acceptedFileList'])->name('acceptedRequest_list');
    Route::get('/rejected-request-file', [ClerkController::class, 'rejectedFileList'])->name('rejectedRequest_list');
    Route::get('/transferfile-detail/{id}', [ClerkController::class, 'transferFileDetail'])->name('transferRequest_Detail');
    Route::post('/transferfile-action/{id}', [ClerkController::class, 'transferFileAction'])->name('transferRequest_Action');
    Route::get('/objection-request-list', [ClerkController::class, 'objectionFileList'])->name('objectionRequest_list');
    Route::get('/objection-request-detail/{id}', [ClerkController::class, 'objectionRequestDetail'])->name('objectionRequest_Detail');
    Route::put('/objection-request-detail/{id}', [ClerkController::class, 'updateObjection'])->name('objectionRequest_Update');
    Route::delete('/objection-request-detail/{id}', [ClerkController::class, 'deleteObjection'])->name('objectionRequest_Delete');
    Route::put('/objection-response/{id}/status', [ClerkController::class, 'updateResponseStatus'])->name('objectionResponse_UpdateStatus');
    Route::put('/objection-response/{id}/authority-status', [ClerkController::class, 'updateResponseAuthorityStatus'])->name('objectionResponse_UpdateStatus');

    // User Objection Reply Routes
    Route::post('/objection-reply/{id}', [UsersController::class, 'submitObjectionReply'])->name('submitObjectionReply');
    Route::put('/objection-reply-edit/{id}', [UsersController::class, 'editObjectionReply'])->name('editObjectionReply');
    Route::post('/hdm-objection-reply/{id}', [UsersController::class, 'submitHDMObjectionReply'])->name('submitHDMObjectionReply');
    Route::put('/hdm-objection-reply-edit/{id}', [UsersController::class, 'editHDMObjectionReply'])->name('editHDMObjectionReply');
    Route::get('/objection-file/view/{fileId}', [UsersController::class, 'viewObjectionFile'])->name('viewObjectionFile');


    /// head clerk Routes

    Route::get('/transfer-files-list', [ClerkController::class, 'transferFileAttachements'])->name('transferRequestList');
    Route::get('/transfer-files-attachements/{id}', [ClerkController::class, 'transferFileAttach'])->name('transferRequestAttach');
    Route::post('/transfer-attachements-done', [ClerkController::class, 'transferFileAttachDone'])->name('transferRequestAttachDone');
    Route::get('/attached-files-list', [ClerkController::class, 'attachedfilelist'])->name('attachedFileList');
    Route::get('/receiver-and-witness-details/{id}',[ClerkController::class,'receiverDetail'])->name('receiverDetail');
    Route::post('/receiver-and-witness-details-added/{id}',[ClerkController::class,'receiverDetailDone'])->name('receiverDetailDone');
    Route::post('/receiver-and-witness-details-update/{id}',[ClerkController::class,'receiverDetailUpdate'])->name('receiverDetailUpdate');
    Route::get('/added-detail-files',[ClerkController::class,'addedDetailFiles'])->name('addedDetailFiles');
    Route::get('/added-detail-edit/{id}',[ClerkController::class,'addedDetailEdit'])->name('addedDetailEdit');
    Route::get('/added-details/{id}',[ClerkController::class,'addedDetails'])->name('addedDetails');
    Route::delete('/delete-dummy-user/{id}/{type}',[ClerkController::class,'deleteDummyUser'])->name('deleteDummyUser');

    Route::get('/requester-statement/{id}/{type}',[ClerkController::class,'requesterStatement'])->name('requesterStatment');
    Route::get('/receiver-statement/{id}/{type}',[ClerkController::class,'receiverStatement'])->name('receiverStatment');
    Route::post('/requester-statement-store/{id}/',[ClerkController::class,'requesterStatementStore'])->name('requesterStatementStore');
    Route::post('/receiver-statement-store/{id}/',[ClerkController::class,'receiverStatementStore'])->name('receiverStatementStore');


    // qa routes
    Route::get('/files-qa', [ClerkController::class, 'fileQa'])->name('filesQA');
    Route::get('/qa-done-files', [ClerkController::class, 'Qafile'])->name('Qafiles');
    Route::post('/qa-save-file', [ClerkController::class, 'storeQA'])->name('QAstore');
    Route::post('/save-appointment', [ClerkController::class, 'saveAppointment'])->name('save.appointment');
    Route::get('/appointment-list', [ClerkController::class, 'appointmentList'])->name('list.appointment');
    Route::get('/re-appointment-list', [ClerkController::class, 'reScheduleAppoitment'])->name('rescheduleAppointment');

    // HDM routes
    Route::get('/hdm/pending-requests',[HDMController::class,'pendingRequests'])->name('hdm.pendingRequests');
    Route::get('/hdm/approved-requests',[HDMController::class,'approvedRequests'])->name('hdm.approvedRequests');
    Route::get('/hdm/view-pending-request/{id}',[HDMController::class,'viewPendingRequest'])->name('hdm.viewPendingRequest');

    // AD-Civil routes
    Route::get('/ad-civil/pending-requests',[ADCivilController::class,'pendingRequests'])->name('ad-civil.pendingRequests');
    Route::get('/ad-civil/approved-requests',[ADCivilController::class,'approvedRequests'])->name('ad-civil.approvedRequests');
    Route::get('/ad-civil/view-pending-request/{id}',[ADCivilController::class,'viewPendingRequest'])->name('ad-civil.viewPendingRequest');
    Route::post('/ad-civil/submit-pending-request/{id}',[ADCivilController::class,'submitPendingRequest'])->name('ad-civil.submitPendingRequest');

    // DD-Civil routes
    Route::get('/dd-civil/pending-requests',[DDCivilController::class,'pendingRequests'])->name('dd-civil.pendingRequests');
    Route::get('/dd-civil/approved-requests',[DDCivilController::class,'approvedRequests'])->name('dd-civil.approvedRequests');
    Route::get('/dd-civil/view-pending-request/{id}',[DDCivilController::class,'viewPendingRequest'])->name('dd-civil.viewPendingRequest');
    Route::post('/dd-civil/submit-pending-request/{id}',[DDCivilController::class,'submitPendingRequest'])->name('dd-civil.submitPendingRequest');

    // Sub Engineer routes
    Route::get('/engineer/pending-requests',[EngineerController::class,'pendingRequests'])->name('engineer.pendingRequests');
    Route::get('/engineer/approved-requests',[EngineerController::class,'approvedRequests'])->name('engineer.approvedRequests');
    Route::get('/engineer/view-pending-request/{id}',[EngineerController::class,'viewPendingRequest'])->name('engineer.viewPendingRequest');
    Route::get('/engineer/map-approval/{id}',[EngineerController::class, 'mapApproval'])->name('engineer.mapApproval');
    Route::post('/engineer/map-approval-store',[EngineerController::class, 'storeMapApproval'])->name('engineer.storeMapApproval');
    Route::get('/engineer/map-approvals-list',[EngineerController::class, 'mapApprovalsList'])->name('engineer.map-approvals-list');
    Route::get('/engineer/map-approval-edit/{id}',[EngineerController::class, 'editMapApproval'])->name('engineer.editMapApproval');
    Route::delete('/engineer/map-approval-delete/{id}',[EngineerController::class, 'deleteMapApproval'])->name('engineer.deleteMapApproval');

});

// mdhaQa Routes
Route::middleware('auth')->group(function (){
    Route::get('/property-area/{id}', [QAController::class, 'propertyArea'])->name('propertyArea');
    Route::get('/property-List', [QAController::class, 'propertyList'])->name('property.list');
    Route::get('/schedule-appointment', [ClerkController::class, 'scheduleAppointment'])->name('scheduleAppointment');
    Route::post('/schsave', [QAController::class, 'schedulestore']);

    Route::get('/delsch/{id}', [QAController::class, 'destroy'])->name('delsch.destroy');
    Route::get('/ddashboard', [QAController::class, 'ddashboard'])->name('ddashboard');
    // template attachements routs
    Route::get('/attachements', [QAController::class, 'attachements'])->name('attachement');
    Route::post('/attachements', [QAController::class, 'attachStore'])->name('attachStore');

    Route::get('/testDashboard', [QAController::class, 'testDashboard'])->name('dashboardtest');
    Route::get('/view-property-detail/{id}',[QAController::class,'history'])->name('history');




});


// DD routes
Route::middleware('auth')->group(function (){
       Route::get('/dd-transfer-verification/{id}/{type}', [QAController::class, 'DDverify'])->name('test');
       Route::post('/clerk/house-construction-action', [QAController::class, 'houseConstructionAction'])->name('house.construction.action');
    Route::post('/dd-verification/{id}', [DDController::class, 'storeVerification'])->name('DDverification');
    Route::get('/test1', [QAController::class, 'test1'])->name('test1');
    Route::get('/dd-transfer-list', [DDController::class, 'transferList'])->name('ddTransfer');
    Route::get('/final-transfered-list', [DDController::class, 'transferedProperties'])->name('transferedFile');
    Route::post('/propery-verification', [DDController::class, 'PropertyVerify'])->name('propertyVerify');
    Route::post('/oldPropertyTransfer/{id}', [DDController::class, 'PropertyTransferOld'])->name('propertyTransferOld');
    Route::get('/old-property-tranasfer/{id}', [DDController::class, 'oldpropertyTransfer'])->name('oldPropertyTransfer');
    Route::get('/property-verify', [DDController::class, 'propertyVerification'])->name('propertyVerification');
    Route::get('/old-transfer-list', [DDController::class, 'oldTransferList'])->name('oldTransferList');
    Route::get('/generate-transfer-order/{id}',[DDController::class,'generateTransferOrder'])->name('generateOrder');
    Route::post('/property-documents/store', [DDController::class, 'store'])->name('property-documents.store');
    Route::get('/completed-requests', [DDController::class, 'completedRequests'])->name('completedRequests');
    Route::get('/file-cache',[DDController::class,'cacheFile'])->name('cache');
    Route::post('/upload-transfer-order/{id}',[DDController::class,'uploadTransferOrder'])->name('uploadTransferOrder');
    Route::get('/transfer-order-statement',[DDController::class,'transferOrderStatementList'])->name('transferOrderStatement');
    Route::get('/generate-transferorder-statement/{type}',[DDController::class,'generateTransferOrderStatement'])->name('generateTransferOrderStatement');
});

// Front Desk Routes

Route::middleware('auth')->group(function (){
       Route::get('/create/user', [FrontDeskController::class, 'createuser'])->name('fd.createuser');
       Route::get('/users-list', [FrontDeskController::class, 'index'])->name('fd.index');
       Route::get('/users-edit/{id}', [FrontDeskController::class, 'edituser'])->name('fd.edituser');
      Route::view('/frontdesk-property-check', 'desk.propertycheck')->name('fd.propertycheck');
      Route::post('/frontdesk-property-verify',[FrontDeskController::class, 'propertyVerify'])->name('fd.propertyverify');
      Route::post('/fd-property-transfer/{id}', [FrontDeskController::class, 'TransferFilestore'])->name('fd.transfer_property');
    Route::get('/fd-property-transfer/{id}', [FrontDeskController::class, 'transferFile'])->name('fd.transfer_file');
    Route::get('/frontdesk-check-requests', [FrontDeskController::class, 'checkRequests'])->name('fd.checkrequest');
    Route::get('/house-construction/{id}', [FrontDeskController::class, 'houseConstructionForm'])->name('fd.houseConstructionForm');
    Route::post('/house-construction/{id}', [FrontDeskController::class, 'houseConstructionStore'])->name('fd.houseConstructionStore');
    Route::get('/frontdesk-objection-requests', [FrontDeskController::class, 'objectionRequests'])->name('fd.objectionrequest');
    Route::get('/frontdesk-check-objections', [FrontDeskController::class, 'CheckObjectionRequests'])->name('fd.checkObjectionrequest');

});

Route::get('/view-transfer-order/{id}',[ClerkController::class,'viewTransferOrder']);
Route::get('/editor', function () {
    return view('edit');
})->name('editor');

require __DIR__.'/auth.php';
