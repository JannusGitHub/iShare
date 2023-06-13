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
use Illuminate\Support\Facades\Response;
use Mail; // or use Illuminate\Support\Facades\Mail;

/**
 * Import Models here
 */
use App\Models\Library;
use App\Models\User;
use App\Models\GroupLeader;

class LibraryController extends Controller
{
    public function addLibrary(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        
        $data = $request->all();
        $rules = [
            'title'     => 'required|string',
            'author'    => 'required|string',
        ];

        if(!isset($request->file_name)){
            $rules['file_name'] = 'required';
        }else{
            $rules['file_name'] = '';
        }
        // return $data;

        $isGroupLeader = GroupLeader::where('group_leader_name', session('session_user_id'))
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->get();
        

        /* For Insert */
        if(!isset($request->library_id)){
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
            } else {
                if(count($isGroupLeader) > 0){
                    if(isset($request->file_name)){
                        DB::beginTransaction();
                        try {
                            // get original file name
                            $original_filename = $request->file('file_name')->getClientOriginalName();
                            // get extension
                            $file_extension = $request->file('file_name')->getClientOriginalExtension();
                            // generated file to be stored in laravel storage and database
                            $ishare_generated_filename = "ishare_attachment_" . date('YmdHis') . "." . $file_extension;
                            // store in public/file_attachments
                            Storage::putFileAs('public/file_attachments', $request->file_name, $ishare_generated_filename);
    
                            Library::insert([
                                'title' => $request->title,
                                'author' => $request->author,
                                'original_file_name' => $original_filename,
                                'generated_file_name' => $ishare_generated_filename,
                                'created_by' => session('session_user_id'),
                                'created_at' => date('Y-m-d H:i:s'),
                                'is_deleted' => 0,
                            ]);
                            DB::commit();
                            return response()->json(['hasError' => 0]);
                        } catch (\Exception $e) {
                            DB::rollback();
                            return response()->json(['hasError' => 1, 'exceptionError' => $e]);
                        }
                    }
                }else{
                    return response()->json(['isGroupLeader' => false, 'errorMessage'=>'Cannot upload. You are not group leader!']);
                }
            }
        }
    }

    public function viewLibrary(Request $request){
        $cedulaBasisDetails = Library::where('is_deleted', 0)->get();
        $userLevel = User::where('id', $request->session_user_id)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->first();
        return DataTables::of($cedulaBasisDetails)
            ->addColumn('action', function($row) use($userLevel){
                $result = '';
                if($userLevel->user_level_id == 2){ // Faculty
                    if($row->status == 0){
                        $result .=  '<center>
                                        <button type="button" class="btn btn-success btn-xs text-center actionChangeStatus mr-1" library-id="' . $row->id . '" library-status="1" data-bs-toggle="modal" data-bs-target="#modalChangeStatus" title="Approved">
                                            <i class="fa-solid fa-square-check fa-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs text-center actionChangeStatus mr-1" library-id="' . $row->id . '" library-status="2" data-bs-toggle="modal" data-bs-target="#modalChangeStatus" title="Reject">
                                            <i class="fa-solid fa-ban fa-lg"></i>
                                        </button>
                                    </center>';
                    }else{
                        $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">No Action</span></center>';
                    }
                    
                }else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">No Action</span></center>';
                }
                return $result;
            })
            ->addColumn('title', function($row){
                $result = "";
                $result .= '<center><span>'.$row->title.'</span></center>';
                return $result;
            })
            ->addColumn('author', function($row){
                $result = "";
                $result .= '<center><span>'.$row->author.'</span></center>';
                return $result;
            })
            ->addColumn('file_name', function($row){
                $result = "";
                $result .= '<center>
                                <i class="fas text-primary fa-file-download"></i>
                                <a href="download_file/'. $row->id . '" title="Click to download file">'. $row->original_file_name . '</a>
                            </center>';
                
                return $result;
            })
            ->addColumn('status', function($row){
                $result = "";
                if($row->status == 0){
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Pending</span></center>';
                }else if($row->status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Approved</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill badge-danger">Rejected</span></center>';
                }
                return $result;
            })
            
        ->rawColumns(['action','title','author', 'file_name', 'status'])
        ->make(true);
    }

    public function downloadLibraryFile(Request $request, $id)
    {
        $libraryFile = Library::where('id', $id)->first();
        $file =  storage_path() . "/app/public/file_attachments/" . $libraryFile->generated_file_name;
        return Response::download($file, $libraryFile->generated_file_name);  
    }

    public function approvedStatus(Request $request){        
        date_default_timezone_set('Asia/Manila');

        $data = $request->all(); // collect all input fields
        $validator = Validator::make($data, [
            'library_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            if(isset($request->status)){
                $isUpdated = Library::where('id', $request->library_id)
                    ->update([
                            'status' => $request->status,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );

                $status = Library::where('id', $request->library_id)->value('status');
                return response()->json(['hasError' => 0, 'status' => (int)$status]);
            }
        }
        else{
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }
    }
}
