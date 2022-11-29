<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\LockController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventAttendanceController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\PenaziranController;

use App\Http\Middleware\AuthLock;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return redirect('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'Login'])->name('user-login');

Route::get('/buipa/login', [LoginController::class, 'adminLogin'])->name('adminLogin');
Route::post('/login/admin', [LoginController::class, 'LoginAdmin'])->name('admin-login'); 

Route::get('/sign-up', [RegisterController::class, 'Registration'])->name('sign-up');
Route::post('/register', [RegisterController::class, 'Register'])->name('register');
Route::get('/buipa/register',[RegisterController::class, 'registerAdmin'])->name('register-admin');

Route::get('/verify-email/{user_id}', [VerifyEmailController::class, 'verifyEmail'])->name('verify.email');
Route::get('/verify-email-form/{token}', [VerifyEmailController::class, 'VerifyForm'])->name('verify.email.form');


Route::post('/signout', [LogoutController::class, 'signOut'])->name('signout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgetPassword'])->name('forgot.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::get('/events/attendance/{event_id}/{token}', [EventAttendanceController::class, 'attendance'])->name('events.attendance');
Route::post('/events/attendance/check-in', [EventAttendanceController::class, 'checkInWithoutLogin'])->name('events.attendance.post');



Route::middleware(['auth','auth.lock'])->group(function () {

    Route::get('/user-profile', [UserController::class, 'profile'])->name('profile'); 
    Route::get('/account-pending', function () { return view('user.account-pending');})->name('account-pending');
    Route::get('/download/{folder}/{path}', [DocumentController::class, 'downloadFile'])->name('file.download.get');
    Route::get('/deleteFileUpload/{id}',[DocumentController::class, 'deleteDocumentById'])->name('file.download.delete');

        Route::get('/home', [UserController::class, 'index'])->name('home'); 
        Route::get('/account-setting', [UserController::class, 'profile'])->name('account-setting');
        Route::get('/admin-setting/{id}', [AdminController::class, 'viewAdmin'])->middleware('can:isAdmin')->name('admin.view.admin.update');
        Route::get('/lock-screen', [LockController::class, 'locked'])->withoutMiddleware('auth.lock')->name('login.locked');
        Route::post('login/locked', [LockController::class, 'unlock'])->withoutMiddleware('auth.lock')->name('login.unlock');
        Route::post('/update-profile/{id}', [UserController::class, 'updateProfile'])->name('update.profile'); 
        Route::get('/get-region', [UserController::class, 'getRegion']);
        
        Route::get('/general-document', [DocumentController::class, 'index'])->name('general.document');
        Route::get('/list-document/{type}/{refer}/{id}', [DocumentController::class, 'listDocument'])->name('list.document');
        Route::get('/list-document-download/{type}/{refer}/{id}', [DocumentController::class, 'listDocumentDownload'])->name('list.document.download');
       
        Route::get('/events', [EventController::class, 'index'])->name('get.list.events');

        Route::prefix('/reports')->middleware('can:isUserAndAdmin')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('get.list.reports'); 
            Route::post('/', [ReportController::class, 'uploadFile'])->name('report.file.post'); 
            Route::get('/review-report/{id}', [ReportController::class, 'reviewReport'])->name('event.review.report');
            Route::get('/list-participants-attendance/{event_id}', [ReportController::class, 'listAttendance'])->name('event.report.attendance.list');
            Route::get('/list-participants-mark/{event_id}', [ReportController::class, 'listAttendeesMark'])->name('event.report.mark.list');
            Route::get('/view-marks-details/{attendee_id}', [ReportController::class, 'viewPenaziranDetails'])->name('event.report.mark.view');




        });
        
        


        Route::middleware('can:isAdmin')->group(function(){
            Route::post('general-uploads', [DocumentController::class, 'uploadFile'])->name('upload.post.file.general'); 
            Route::get('/create-events', [EventController::class, 'create'])->name('create.events');
            Route::post('/create-events', [EventController::class, 'createEvent'])->name('create.events.post'); 

            Route::prefix('/events')->group(function () { 
                Route::post('/change-penazir/{id}', [EventController::class, 'changePenazir'])->name('events.penazir.change');
                Route::get('/ongoing-events', [EventController::class, 'ongoingEvent'])->name('events.ongoing'); 
                Route::get('/closed-events', [EventController::class, 'closedEvent'])->name('events.closed'); 
                Route::post('/event-summary',[EventController::class, 'finishedEvent'])->name('events.finished'); 
                /***************QR LINK */
                Route::get('/attendance-links/{event_id}', [EventController::class, 'attendanceLink'])->name('events.attendance.link'); 
                Route::get('/create-attendance/{event_id}',[EventController::class, 'createAttendance'])->name('events.ongoing.attendance.create');
                Route::get('/print-qrcode-attendance/{event_id}',[EventController::class, 'printQRCodeAttendance'])->name('events.print.qrcode.attendance');
                Route::get('/list-attendance-links/{event_id}', [EventController::class, 'listAttendanceLink'])->name('events.list.attendance.link'); 
                Route::get('/attendance-link/{qr_id}',[EventController::class, 'viewAttendanceLink'])->name('events.attendance.link.view');
                Route::get('/attendance-participants/{event_id}/{date}',[EventController::class, 'viewAttendanceParticipants'])->name('events.attendance.participants.view');
                Route::get('/list-attendance-participants/{event_id}/{date}',[EventController::class, 'listAttendanceParticipants'])->name('events.attendance.participants.list');
                Route::get('/attendance-all-participants/{event_id}',[EventController::class, 'viewAttendanceAllParticipants'])->name('events.attendance.all.participants.view');
                Route::get('/list-attendance-all-participants/{event_id}',[EventController::class, 'listAttendanceAllParticipants'])->name('events.attendance.all.participants.list');
                /******************** */

                Route::get('/list-all-participants/{event_id}', [EventController::class, 'listAllParticipants'])->name('events.all.participants.list');

                Route::get('/update-events/{id}', [EventController::class, 'updateEvent'])->name('update.events'); 
                Route::get('/view-events/{id}', [EventController::class, 'viewEvent'])->name('view.events'); 
                Route::get('/list-ongoing-events', [EventController::class, 'listOngoingEvent'])->name('events.list.ongoing'); 
                Route::get('/list-closed-events', [EventController::class, 'listClosedEvent'])->name('event.list.closed');
                Route::get('/list-finished-events', [EventController::class, 'listFinishedEvent'])->name('event.list.finished');

                Route::get('/list-draft-events', [EventController::class, 'draftEvent'])->name('event.list.draft'); 
                Route::get('/list-pending-events', [EventController::class, 'pendingEvent'])->name('event.list.pending'); 
                Route::get('/list-approve-events', [EventController::class, 'approveEvent'])->name('event.list.approve'); 
                Route::get('/list-reject-events', [EventController::class, 'rejectEvent'])->name('event.list.reject'); 
                Route::get('/list-penazir-progress/{event_id}', [EventController::class, 'listPenazirProgress'])->name('event.list.penazir.progress'); 
                Route::get('/create-report/{id}', [EventController::class, 'createReport'])->name('event.create.report'); 
                Route::get('/reports', [EventController::class, 'reportEvent'])->name('event.report'); 
                Route::get('/pending-events', [EventController::class, 'pendingEvent'])->name('pending.events');
                Route::get('/event-action/{action}/{id}',[EventController::class, 'eventAction'])->name('events.method.action');
                Route::get('/delete-event/{id}',[EventController::class, 'deleteEvent'])->name('events.method.delete');
                Route::get('/registrations',[EventController::class, 'registrations'])->name('events.registrations');
                Route::get('/attendees-approval/{action}',[EventController::class, 'approvalAttendees'])->name('events.register.attendees.approval');
                Route::get('/register-action/{action}/{id}',[EventController::class, 'registerAction'])->name('events.registrations.action');

            });        
          
        });

        Route::middleware('can:isNotAdmin')->group(function(){
            Route::get('/events/my-events', [EventController::class, 'myEvents'])->name('event.my.events');
            Route::get('/event/register/{event_id}/{id}', [EventController::class, 'registerEvent'])->name('register.events');
        });

        Route::middleware('can:isUser')->group(function () {
            Route::get('/company', [CompanyController::class, 'index'])->name('company.details.get');
            Route::post('/company', [CompanyController::class, 'create'])->name('company.details.post');
            Route::post('/company-uploads', [CompanyController::class, 'uploadFile'])->name('upload.post.file.company'); 
            Route::post('/company/create-product', [CompanyController::class, 'createProduct'])->name('company.product.create');
            Route::get('/company/list-product/{company_id}', [CompanyController::class, 'listProducts'])->name('company.product.list');
            Route::get('/company/delete-product/{id}', [CompanyController::class, 'deleteProducts'])->name('company.product.delete');


        });

        Route::prefix('/penazirans')->middleware('can:isNotUser')->group(function () {
            Route::get('/', [PenaziranController::class, 'index'])->name('penaziran.index');
            Route::get('list-participants/{event_id}', [PenaziranController::class, 'penaziranProcess'])->name('penaziran.event.index');
            Route::get('/create-penaziran/{id}', [PenaziranController::class, 'create'])->name('penaziran.event.create');
            Route::post('/penaziran-mark', [PenaziranController::class, 'createAttendessMark'])->name('event.penaziran.mark.post');
            Route::get('/list-event', [PenaziranController::class, 'listEventAnugerah'])->name('event.list.anugerah');
            Route::get('/list-attendees-event/{event_id}', [PenaziranController::class, 'listPenaziranProcess'])->name('event.penaziran.attendees.list');
            Route::get('/penaziran-details/{id}', [PenaziranController::class, 'viewPenaziranDetails'])->name('event.penaziran.details.view');

        }); 

        Route::prefix('/mye-usahawan')->group(function () {     
            Route::middleware('can:isAdmin')->group(function () {
                Route::get('/pending-user', [AdminController::class, 'pendingUser'])->name('eusahawan.user.pending'); 
                Route::get('/list-pending-user', [AdminController::class, 'listPendingUser'])->name('myeusahawan.user-pending'); 
                Route::get('/admin-action/{action}/{id}', [AdminController::class, 'AdminActionUser'])->name('myeusahawan.admin-action'); 
                Route::get('/admin-action/institute/{action}/{id}', [AdminController::class, 'AdminActionInstitute'])->name('myeusahawan.admin-action.Institute'); 

                Route::get('/students', [AdminController::class, 'activeUsers'])->name('eusahawan.active.student');
                Route::get('/entrepreneurs', [AdminController::class, 'activeUsers'])->name('eusahawan.active.entrepreneur');
                Route::get('/instructors', [AdminController::class, 'activeUsers'])->name('eusahawan.active.instructor'); 
                Route::get('/secretariats', [AdminController::class, 'activeUsers'])->name('eusahawan.active.secretariat'); 
                Route::get('/teachers', [AdminController::class, 'activeUsers'])->name('eusahawan.active.teacher');
                
                Route::get('/student/{id}', [UserController::class, 'userDetail'])->name('eusahawan.active.student.detail');
                Route::get('/entrepreneur/{id}', [UserController::class, 'userDetail'])->name('eusahawan.active.entrepreneur.detail');
                Route::get('/instructor/{id}', [UserController::class, 'userDetail'])->name('eusahawan.active.instructor.detail'); 
                Route::get('/secretariat/{id}', [UserController::class, 'userDetail'])->name('eusahawan.active.secretariat.detail'); 
                Route::get('/teacher/{id}', [UserController::class, 'userDetail'])->name('eusahawan.active.teacher.detail'); 

                Route::post('/assign-supervision/{id}', [AdminController::class, 'assignSupervision'])->name('eusahawan.assign.supervision'); 

                Route::get('/list-active-user/{category}', [AdminController::class, 'listUsers'])->name('myeusahawan.user.list-users');
                Route::get('/user/{id}', [UserController::class, 'userDetail'])->name('view.user.detail'); 

                
                Route::get('/pending-institution', [AdminController::class, 'pendingInstitution'])->name('myeusahawan.institution.pending'); 
                Route::get('/list-pending-institution', [AdminController::class, 'listPendingInstitution'])->name('myeusahawan.institution.pending.list'); 
                Route::get('/list-active-institution', [AdminController::class, 'listActiveInstitution'])->name('myeusahawan.institution.active.list'); 
                Route::get('/list-penaziran-report/{auditor_id}', [PenaziranController::class, 'listPenaziranByPenazir'])->name('myeusahawan.penaziran.report.list'); 
                Route::get('/penaziran-details/{id}', [PenaziranController::class, 'viewPenaziranDetails'])->name('myeusahawan.epenaziran.details.view');


            });

            Route::middleware('can:isTutor')->group(function () {
                Route::get('/register-institution', [InstitutionController::class, 'registerInstitution'])->name('myeusahawan.institution.register-institution');
                Route::post('/register-institution', [InstitutionController::class, 'createInstitution'])->name('myeusahawan.institution.post.register-institution');
                Route::get('/my-institution', [InstitutionController::class, 'myInstitution'])->name('myeusahawan.institution.my-institution');
                Route::get('/institution/{id}', [InstitutionController::class, 'viewInstitution'])->name('myeusahawan.institution.view-institution');
                Route::get('/update-institution/{id}', [InstitutionController::class, 'updateInstitution'])->name('myeusahawan.institution.update-institution');
                Route::post('/update-institution/{id}', [InstitutionController::class, 'updateInstitution'])->name('myeusahawan.institution.update-post-institution');
                Route::get('/list-student-teacher/{id}', [InstitutionController::class, 'listStudentTeacher'])->name('myeusahawan.institution.students.list'); 
                
                #*********Supervisor***********#
                Route::get('/supervisor-user/{category}', [InstitutionController::class, 'viewSupervisor'])->name('myeusahawan.institution.supervisor.view'); 
                Route::get('/list-supervisor-user/{category}', [InstitutionController::class, 'listSupervisor'])->name('myeusahawan.institution.supervisor.list'); 
                Route::get('/supervision-student/{id}', [UserController::class, 'userDetail'])->name('eusahawan.supervisor.student.detail');
                Route::get('/supervision-entrepreneur/{id}', [UserController::class, 'userDetail'])->name('eusahawan.supervisor.entrepreneur.detail');


            }); 

            Route::middleware('can:isNotUser')->group(function () {
                Route::get('/institution/{id}', [InstitutionController::class, 'viewInstitution'])->name('myeusahawan.institution.view-institution');
                Route::get('/select-institution/{id}', [UserController::class, 'updateInstitutionIstutor'])->name('myeusahawan.institution.select-institution');
                Route::post('/select-institution/{id}', [UserController::class, 'updateInstitutionIstutor'])->name('myeusahawan.institution.select-post-institution');
                Route::get('/list-ditazir-report/{user_id}', [PenaziranController::class, 'listPenaziranByDitazir'])->name('myeusahawan.ditazir.report.list'); 
    
            }); 

            Route::get('/institutions', [InstitutionController::class, 'index']);
            Route::get('/pending-institution', function () { return view('eusahawan.institution.pending'); });
        }); 

        Route::prefix('/admin-tools')->middleware('can:isAdmin')->group(function () {   
            Route::get('/system-settings', [AdminController::class, 'systemSettings'])->name('admin.settings.system'); 
            Route::post('/system-settings', [AdminController::class, 'createSystemSettings'])->name('admin.settings.system.post'); 
            Route::get('/list-system-settings/{category}', [AdminController::class, 'listSystemSettings'])->name('admin.settings.system.list'); 
            Route::get('/delete-system-settings/{category}/{id}', [AdminController::class, 'deleteSystemSettings'])->name('admin.settings.system.delete'); 

            Route::get('/create-admin', [AdminController::class, 'createAdminView'])->name('admin.create.admin.new');
            Route::post('/create-admin', [AdminController::class, 'createAdmin'])->name('admin.create.admin.post'); 
            Route::get('/list-admin', [AdminController::class, 'listAdmin'])->name('admin.list.admin'); 
            Route::get('/get-list-admin', [AdminController::class, 'getlistAdmin'])->name('admin.get.list.admin'); 
            Route::get('/admin/{id}', [AdminController::class, 'viewAdmin'])->name('admin.view.admin.view'); 
            Route::post('/update-admin', [AdminController::class, 'updateAdmin'])->name('admin.update.admin'); 

            Route::get('/finance-settings', [AdminController::class, 'financeSettings'])->name('admin.finance.system.view'); 
            Route::get('/list-finance-settings/{category}', [AdminController::class, 'listFinanceSettings'])->name('admin.finance.system.list'); 
            Route::post('/finance-settings', [AdminController::class, 'createFinanceSettings'])->name('admin.finance.setting.post'); 

        });

       

});




