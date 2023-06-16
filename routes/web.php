<?php

use Illuminate\Support\Facades\Route;

/**
 * Import Controllers
 */
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LibraryController;

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('checkIfSessionNotExist');

/**
 * USER MANAGEMENT CONTROLLER
 * Note: always use snake case naming convention to route & route name and camel case to the method for best practice
 */
Route::middleware('checkIfSessionExist')->group(function(){
    Route::get('/', function () {
        return view('login');
    })->name('login');
    
    Route::get('/register', function () {
        return view('register');
    })->name('register');
});
Route::post('/send_otp', [UserController::class, 'sendOTP'])->name('send_otp');
Route::post('/verify_otp', [UserController::class, 'verifyOTP'])->name('verify_otp');
Route::post('/register_user', [UserController::class, 'registerUser'])->name('register_user');
Route::get('/sign_in', [UserController::class, 'signIn'])->name('sign_in');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/check_session', [UserController::class, 'checkSession'])->name('check_session');
Route::get('/get_sections', [UserController::class, 'getSections'])->name('get_sections');
Route::get('/get_users', [UserController::class, 'getUsers'])->name('get_users');
Route::get('/get_users_except_faculty_for_group', [UserController::class, 'getUsersExceptFacultyForGroup'])->name('get_users_except_faculty_for_group');
Route::get('/get_data_for_dashboard', [UserController::class, 'getDataForDashboard'])->name('get_data_for_dashboard');

/**
 * GROUP MANAGEMENT CONTROLLER
 * Note: always use snake case naming convention to route & route name and camel case to the method for best practice
 */
Route::middleware('checkIfSessionNotExist')->group(function(){
    Route::get('/group', function () {
        return view('group');
    })->name('group');

    Route::get('/my_group', function () {
        return view('my_group');
    })->name('my_group');

    Route::get('/my_group2', function () {
        return view('my_group2');
    })->name('my_group2');

    Route::post('/add_group', [GroupController::class, 'addGroup'])->name('add_group');
    Route::get('/get_group_list', [GroupController::class, 'getGroupList'])->name('get_group_list');
    Route::get('/get_one_latest_group', [GroupController::class, 'getOneLatestGroup'])->name('get_one_latest_group');
    Route::post('/join_group', [GroupController::class, 'joinGroup'])->name('join_group');
    Route::get('/get_my_group', [GroupController::class, 'getMyGroup'])->name('get_my_group');
    Route::post('/leave_group', [GroupController::class, 'leaveGroup'])->name('leave_group');
    Route::get('/view_title', [GroupController::class, 'viewTitle'])->name('view_library');
    Route::post('/add_title', [GroupController::class, 'addTitle'])->name('add_title');
});

/**
 * LIBRARY MANAGEMENT CONTROLLER
 * Note: always use snake case naming convention to route & route name and camel case to the method for best practice
 */
Route::middleware('checkIfSessionNotExist')->group(function(){
    Route::get('/library', function () {
        return view('library');
    })->name('library');

    Route::post('/add_library', [LibraryController::class, 'addLibrary'])->name('add_library');
    Route::get('/view_library', [LibraryController::class, 'viewLibrary'])->name('view_library');
    Route::get('/download_file/{id}', [LibraryController::class, 'downloadLibraryFile'])->name('download_file');
    Route::post('/approved_status', [LibraryController::class, 'approvedStatus'])->name('approved_status');
});

/**
 * LIBRARY MANAGEMENT CONTROLLER
 * Note: always use snake case naming convention to route & route name and camel case to the method for best practice
 */
Route::middleware('checkIfSessionNotExist')->group(function(){
    Route::get('/topics', function () {
        return view('topics');
    })->name('topics');
    Route::get('/view_title_for_faculty', [LibraryController::class, 'viewTitleForFaculty'])->name('view_title_for_faculty');
    Route::post('/approved_title', [LibraryController::class, 'approvedTitle'])->name('approved_title');
    // Route::post('/add_library', [LibraryController::class, 'addLibrary'])->name('add_library');
    // Route::get('/view_library', [LibraryController::class, 'viewLibrary'])->name('view_library');
    // Route::get('/download_file/{id}', [LibraryController::class, 'downloadLibraryFile'])->name('download_file');
});
