<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth; // or use Illuminate\Support\Facades\Auth;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Mail; // or use Illuminate\Support\Facades\Mail;

/**
 * Import Models here
 */
use App\Models\User;
use App\Models\UserLevel;
use App\Models\Authentication;
use App\Models\Library;
use App\Models\Section;
use App\Models\ResetPasswordCode;

class UserController extends Controller
{
    public function sendOTP(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $data = $request->all();
        $rules = [
            'tupt_id_number' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'fullname' => 'required|max:255', // or regex:/^[a-zA-Z ]+$/
            'password' => 'required|alphaNum|min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|alphaNum|min:8',
        ];

        if($request->user_level == 3){
            $rules['section'] = 'required';
        }else{
            $rules['section'] = '';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            $to = [$request->email];
            $cc = ['isharesystemnotification@gmail.com'];
            $otpCode = rand(100000, 999999);
            $data = [
                'otpCode' => $otpCode,
                'subject' => "OTP Code",
            ];

            $email_recipients = [
                'to' => $to,
                'cc' => $cc,
            ];

            try {
                Mail::send('mail.otp_notification', $data, function($message) use ($email_recipients, $data) {
                    $message
                    ->to($email_recipients['to'])
                    ->cc($email_recipients['cc'])
                    ->subject($data['subject']);
                });

                // Check for failures
                if (Mail::failures()) {
                    return response()->json(['result' => 0]);
                }

                $userId = Authentication::insertGetId([
                    'otp_code' => $otpCode,
                    'expired' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                
                return response()->json(['result' => 1]);
            } 
            catch (Exception $e) {
                return response()->json(['result' => 0]);
            }
        }
    }

    public function verifyOTP(Request $request){
        $otpCode = $request->otp_code;
        // $data = DB::select( DB::raw("SELECT * FROM authentications WHERE otp_code = :optCode AND expired!=1 AND NOW() <= DATE_ADD(created_at, INTERVAL 1 MINUTE"), array(
        $data = DB::select( DB::raw("SELECT * FROM authentications WHERE otp_code = :optCode AND expired!=1"), array(
            'optCode' => $otpCode,
        ));
        return response()->json(['data' => $data]);
    }

    public function registerUser(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $rules = [
            'tupt_id_number' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'fullname' => 'required|max:255', // or regex:/^[a-zA-Z ]+$/
            'password' => 'required|alphaNum|min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|alphaNum|min:8',
        ];

        if($request->user_level == 3){
            $rules['section'] = 'required';
        }else{
            $rules['section'] = '';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                $userId = User::insertGetId([
                    'tupt_id_number' => $request->tupt_id_number,
                    'email' => $request->email,
                    'fullname' => $request->fullname,
                    'section_id' => $request->section,
                    'password' => Hash::make($request->password),
                    'user_level_id' => $request->user_level,
                    'created_at' => date('Y-m-d H:i:s'),
                    'is_deleted' => 0
                ]);

                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e]);
            }
        }
    }
    
    public function signIn(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'tupt_id_number' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validator->passes()) {
            if (Auth::attempt($data)) {

                if(Auth::user()->status == 0){
                    Auth::logout();
                    return response()->json(['inactive' => 0, 'error_message' => 'Your account is currently deactivated. Kindly contact the Administrator']);
                }
                else {
                    $request->session()->put('session_user_id', Auth::user()->id);
                    $request->session()->put('session_tupt_id_number', Auth::user()->tupt_id_number);
                    $request->session()->put('session_fullname', Auth::user()->fullname);
                    $request->session()->put('session_email', Auth::user()->email);
                    $request->session()->put('session_user_level_id', Auth::user()->user_level_id);
                    return response()->json(['hasError' => 0]);
                }
            } else {
                return response()->json(['hasError' => 1,  'error_message' => 'We do not recognize your username and/or password. Please try again.']);
            }
        } else {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }
    }

    public function getUsers(Request $request){
        date_default_timezone_set('Asia/Manila');
        $search = $request->search;

        if($search == ''){
            $datas = [];
        }
        else{
            $datas = User::orderby('fullname','asc')->select('id','fullname')
                        ->where('fullname', 'like', '%' . $search . '%')
                        ->where('status', 1)
                        ->where('user_level_id', 3) // 3-student
                        ->get();
        }

        $response = [
            "results" => []
        ];
            
        foreach($datas as $data){
            $response['results'][] = array(
                "id" => $data->id,
                "text" => $data->fullname,
            );
        }

        echo json_encode($response);
    }

    public function getUsersExceptFacultyForGroup(Request $request){
        date_default_timezone_set('Asia/Manila');
        $search = $request->search;

        if($search == ''){
            $datas = [];
        }
        else{
            $datas = User::orderby('fullname','asc')->select('id','fullname')
                        ->where('fullname', 'like', '%' . $search . '%')
                        ->where('status', 1)
                        ->where('user_level_id', 3) // 3-student
                        ->where('id','!=', session('session_user_id'))
                        ->get();
        }

        $response = [
            "results" => []
        ];
            
        foreach($datas as $data){
            $response['results'][] = array(
                "id" => $data->id,
                "text" => $data->fullname,
            );
        }

        echo json_encode($response);
    }

    public function logout(Request $request){
        $request->session()->forget('session_user_id');
        $request->session()->forget('session_tupt_id_number');
        $request->session()->forget('session_fullname');
        $request->session()->forget('session_email');
        $request->session()->forget('session_user_level_id');
        return response()->json(['result' => 1]);
    }

    public function checkSession(Request $request){
        if($request->session()->exists('session_user_id')){
            $session = [];
            $session['session_user_id'] = $request->session()->get('session_user_id');
            $session['session_tupt_id_number'] = $request->session()->get('session_tupt_id_number');
            $session['session_fullname'] = $request->session()->get('session_fullname');
            $session['session_email'] = $request->session()->get('session_email');
            $session['session_user_level_id'] = $request->session()->get('session_user_level_id');

            // Or $session = $request->session()->all();
            return response()->json(['session' => $session]);
        }
        else{
            return response()->json(['session' => 'No data in the session']);
        }
    }

    public function getDataForDashboard(){
        date_default_timezone_set('Asia/Manila');
        session_start();
        $totalUsers = User::where('status', 1)->where('is_deleted', 0)->get();
        $totalUploaded = Library::where('is_deleted', 0)->get();
            
        return response()->json([
            'totalUsers' => count($totalUsers),
            'totalUploaded' => count($totalUploaded),
        ]);
    }

    public function viewUsers(Request $request){
        $userDetails = User::with('user_levels')->where('is_deleted', 0)
        ->where('is_authenticated', 1)
        ->when($request->dateRangeFrom, function ($query) use ($request) {
            return $query ->where('created_at', '>=', $request->dateRangeFrom);
        })
        ->when($request->dateRangeTo, function ($query) use ($request) {
            return $query ->where('created_at', '<=', $request->dateRangeTo);
        })
        ->get();
        
        return DataTables::of($userDetails)
            ->addColumn('status', function($userDetail){
                $result = "";
                if($userDetail->status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('is_authenticated', function($userDetail){
                $result = "";
                if($userDetail->is_authenticated == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Authorized</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Not Authorized</span></center>';
                }
                return $result;
            })
            ->addColumn('action', function($userDetail){
                if($userDetail->status == 1){
                    $result =   '<center>';
                    $result .=            '<button type="button" class="btn btn-primary btn-xs text-center actionEditUser mr-1" user-id="' . $userDetail->id . '" data-bs-toggle="modal" data-bs-target="#modalAddUser" title="Edit User Details">';
                    $result .=                '<i class="fa fa-xl fa-edit"></i> ';
                    $result .=            '</button>';

                    if($userDetail->user_level_id != 1){
                        $result .=            '<button type="button" class="btn btn-danger btn-xs text-center actionEditUserStatus mr-1" user-id="' . $userDetail->id . '" user-status="' . $userDetail->status . '" data-bs-toggle="modal" data-bs-target="#modalEditUserStatus" title="Deactivate User">';
                        $result .=                '<i class="fa-solid fa-xl fa-ban"></i>';
                        $result .=            '</button>';
                    }

                    $result .=        '</center>';
                }
                else{
                    $result =   '<center>
                                <button type="button" class="btn btn-primary btn-xs text-center actionEditUser mr-1" user-id="' . $userDetail->id . '" data-bs-toggle="modal" data-bs-target="#modalAddUser" title="Edit User Details">
                                    <i class="fa fa-xl fa-edit"></i> 
                                </button>
                                <button type="button" class="btn btn-warning btn-xs text-center actionEditUserStatus mr-1" user-id="' . $userDetail->id . '" user-status="' . $userDetail->status . '" data-bs-toggle="modal" data-bs-target="#modalEditUserStatus" title="Activate User">
                                    <i class="fa-solid fa-xl fa-arrow-rotate-right"></i>
                                </button>
                            </center>';
                }
                return $result;
            })
            ->addColumn('created_at', function($row){
                $result = "";
                $result .= Carbon::parse($row->created_at)->format('M d, Y h:ia');
                return $result;
            })
        ->rawColumns(['status', 'action', 'is_authenticated', 'created_at'])
        ->make(true);
    }

    public function getUserById(Request $request){
        $userDetails = User::with('user_levels')->where('id', $request->userId)->get();
        // echo $userDetails;
        return response()->json(['userDetails' => $userDetails]);
    }

    public function editUserStatus(Request $request){        
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            if($request->status == 1){
                User::where('id', $request->user_id)
                    ->update([
                            'status' => 0,
                            'last_updated_by' => $_SESSION['session_user_id'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                $status = User::where('id', $request->user_id)->value('status');
                return response()->json(['hasError' => 0, 'status' => (int)$status]);
            }else{
                User::where('id', $request->user_id)
                    ->update([
                            'status' => 1,
                            'last_updated_by' => $_SESSION['session_user_id'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                $status = User::where('id', $request->user_id)->value('status');
                return response()->json(['hasError' => 0, 'status' => (int)$status]);
            }
                
        }
        else{
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }
    }

    public function getSections(Request $request){

        $sections = Section::where('section_name_status', 1)
            ->where('is_deleted', 0)->get();
        return response()->json(['sections' => $sections]);
    }
    
    public function getSectionsForMyGroup(Request $request){

        $sections = Section::where('section_name_status', 0)
            ->where('is_deleted', 0)->get();
        return response()->json(['sections' => $sections]);
    }

    public function sendResetPasswordCode(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $data = $request->all();
        $rules = [
            'email' => 'required|email',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            $to = [$request->email];
            $cc = ['isharesystemnotification@gmail.com'];
            $resetPasswordCode = rand(100000, 999999);
            $data = [
                'resetPasswordCode' => $resetPasswordCode,
                'subject' => "Reset Password Code",
            ];

            $email_recipients = [
                'to' => $to,
                'cc' => $cc,
            ];

            try {
                Mail::send('mail.reset_password_code_notification', $data, function($message) use ($email_recipients, $data) {
                    $message
                    ->to($email_recipients['to'])
                    ->cc($email_recipients['cc'])
                    ->subject($data['subject']);
                });

                // Check for failures
                if (Mail::failures()) {
                    return response()->json(['result' => 0]);
                }

                ResetPasswordCode::insert([
                    'reset_password_code' => $resetPasswordCode,
                    'expired' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $userDetails = User::where('email', $request->email)->first();
                
                return response()->json(['result' => 1, 'userDetails' => $userDetails]);
            } 
            catch (Exception $e) {
                return response()->json(['result' => 0]);
            }
        }
    }

    public function verifyResetPasswordCode(Request $request){
        $resetPasswordCode = $request->reset_password_code;
        // $data = DB::select( DB::raw("SELECT * FROM authentications WHERE otp_code = :optCode AND expired!=1 AND NOW() <= DATE_ADD(created_at, INTERVAL 1 MINUTE"), array(
        $data = DB::select( DB::raw("SELECT * FROM reset_password_codes WHERE reset_password_code = :resetPasswordCode AND expired!=1"), array(
            'resetPasswordCode' => $resetPasswordCode,
        ));
        return response()->json(['data' => $data]);
    }

    public function changePassword(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required|min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:8',
        ]);

        if($validator->passes()){
            User::where('email', $request->email)
                ->update([
                        'password' => Hash::make($request->password),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
            return response()->json(['hasError' => 0]);
        }
        else{
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }
    }
}
