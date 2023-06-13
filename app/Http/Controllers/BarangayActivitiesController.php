<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth; // or use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Storage;

/**
 * Import Models here
 */
use App\Models\User;
use App\Models\BarangayActivities;

class BarangayActivitiesController extends Controller
{
    public function viewBarangayActivities(){
        $barangayActivitiesDetails = BarangayActivities::where('is_deleted', 0)->orderBy('id', 'desc')->get();
        
        return DataTables::of($barangayActivitiesDetails)
            ->addColumn('status', function($row){
                $result = "";
                if($row->status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                }
                else{
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Inactive</span></center>';
                }
                return $result;
            })
            ->addColumn('date', function($row){
                $result = "";

                $date = Carbon::parse($row->date)->locale('en');
                $result .= $date->translatedFormat('F Y g:i A');
                return $result;
            })
            ->addColumn('action', function($row){
                if($row->status == 1){
                    $result =   '<center>
                                <button ty  pe="button" class="btn btn-primary btn-xs text-center actionEditBarangayActivities mr-1" barangay-activities-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#modalAddBarangayActivities" title="Edit Details">
                                    <i class="fa fa-xl fa-edit"></i> 
                                </button>
                                <button type="button" class="btn btn-danger btn-xs text-center actionEditBarangayActivitiesStatus mr-1" barangay-activities-id="' . $row->id . '" barangay-activities-status="' . $row->status . '" data-bs-toggle="modal" data-bs-target="#modalEditBarangayActivitiesStatus" title="Deactivate">
                                    <i class="fa-solid fa-xl fa-ban"></i>
                                </button>
                            </center>';
                }else{
                    $result =   '<center>
                                <button type="button" class="btn btn-primary btn-xs text-center actionEditBarangayActivities mr-1" barangay-activities-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#modalAddBarangayActivities" title="Edit Details">
                                    <i class="fa fa-xl fa-edit"></i> 
                                </button>
                                <button type="button" class="btn btn-warning btn-xs text-center actionEditBarangayActivitiesStatus mr-1" barangay-activities-id="' . $row->id . '" barangay-activities-status="' . $row->status . '" data-bs-toggle="modal" data-bs-target="#modalEditBarangayActivitiesStatus" title="Activate">
                                    <i class="fa-solid fa-xl fa-arrow-rotate-right"></i>
                                </button>
                            </center>';
                }
                return $result;
            })
            ->addColumn('image', function($row){
                $result = "";
                
                if($row->image != null){
                    $url = asset("/storage/activities_attachments/$row->image");
                    $result .= '<a href="'.$url.'" target="_blank" data-toggle="lightbox" data-caption="This describes the image">';
                    $result .=    '<center><img width="80" height="80" class="img-fluid rounded" src="'.$url.'"></center>';
                    $result .=  '</a>';
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">No image</span></center>';
                }
                return $result;
            })
        ->rawColumns(['status', 'date', 'action', 'image'])
        ->make(true);
    }

    public function addBarangayActivities(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        
        $data = $request->all();
        /* For Insert */
        if(!isset($request->barangay_activities_id)){
            $validator = Validator::make($data, [
                'title' => 'required|string',
                'details' => 'required|string',
                'date' => 'required|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    /**
                     * For uploading image
                     */
                    $name = null;
                    if(isset($request->image)){
                        $file = $request->file('image');
                        $name = $file->getClientOriginalName();
                        Storage::putFileAs('public/activities_attachments', $request->image, $name);
                    }
                    
                    BarangayActivities::insert([
                        'title' => $request->title,
                        'details' => $request->details,
                        'date' => $request->date,
                        'image' => $name,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $_SESSION["session_user_id"],
                        'is_deleted' => 0
                    ]);

                    DB::commit();
                    return response()->json(['hasError' => 0]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => 1, 'exceptionError' => $e]);
                }
            }
        }else{ /* For Update */
            $validator = Validator::make($data, [
                'title' => 'required|string',
                'details' => 'required|string',
                'date' => 'required|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    $name = null;
                    if(isset($request->image)){
                        $file = $request->file('image');
                        $name = $file->getClientOriginalName();
                        Storage::putFileAs('public/activities_attachments', $request->image, $name);

                        BarangayActivities::where('id', $request->barangay_activities_id)->update([
                            'title' => $request->title,
                            'details' => $request->details,
                            'date' => $request->date,
                            'image' => $name,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'last_updated_by' => $_SESSION["session_user_id"]
                        ]);
                    }else{
                        BarangayActivities::where('id', $request->barangay_activities_id)->update([
                            'title' => $request->title,
                            'details' => $request->details,
                            'date' => $request->date,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'last_updated_by' => $_SESSION["session_user_id"]
                        ]);
                    }

                    
    
                    DB::commit();
                    return response()->json(['hasError' => 0]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => 1, 'exceptionError' => $e]);
                }
            }
        }
    }

    public function getBarangayActivitiesById(Request $request){
        $barangayActivitiesDetails = BarangayActivities::where('id', $request->barangayActivitiesId)->get();
        return response()->json(['barangayActivitiesDetails' => $barangayActivitiesDetails]);
    }

    public function editBarangayActivitiesStatus(Request $request){        
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        $validator = Validator::make($data, [
            'barangay_activities_id' => 'required',
            'status' => 'required',
        ]);

        if($validator->passes()){
            if($request->status == 1){
                BarangayActivities::where('id', $request->barangay_activities_id)
                    ->update([
                            'status' => 0,
                            'last_updated_by' => $_SESSION['session_user_id'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                $status = BarangayActivities::where('id', $request->barangay_activities_id)->value('status');
                return response()->json(['hasError' => 0, 'status' => (int)$status]);
            }else{
                BarangayActivities::where('id', $request->barangay_activities_id)
                    ->update([
                            'status' => 1,
                            'last_updated_by' => $_SESSION['session_user_id'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                $status = BarangayActivities::where('id', $request->barangay_activities_id)->value('status');
                return response()->json(['hasError' => 0, 'status' => (int)$status]);
            }
                
        }
        else{
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }
    }

    public function getTotalBarangayActivities(Request $request){
        $totalBarangayActivitiesDetails = BarangayActivities::where('status', 1)->orderBy('id', 'desc')->get();
        return response()->json(['totalBarangayActivitiesDetails' => $totalBarangayActivitiesDetails]);
    }
}
