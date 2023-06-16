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
use App\Models\Group;
use App\Models\GroupLeader;
use App\Models\GroupLeaderTitle;
use App\Models\GroupLeaderMember;
use App\Models\User;

class GroupController extends Controller
{
    public function addGroup(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        
        $data = $request->all();
        $rules = [
            'group_name' => 'required|string',
            'group_code' => 'required|string',
        ];
        if(!isset($request->group_leaders)){
            $rules['group_leader_name'] = 'required';
        }else{
            $rules['group_leader_name'] = '';
        }

        /* For Insert */
        if(!isset($request->group_id)){
            $validator = Validator::make($data, $rules);
    
            if ($validator->fails()) {
                return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
            } else {
                $isGroupCodeExist = Group::where('group_code', $request->group_code)->get();
                if(count($isGroupCodeExist) > 0){
                    return response()->json(['isGroupCodeExist'=> true, 'errorMessage'=>'The Group Code already taken!']);
                }else{
                    DB::beginTransaction();
                    try {
                        $groupId = Group::insertGetId([
                            'group_name' => $request->group_name,
                            'group_code' => $request->group_code,
                            'created_by' => session('session_user_id'),
                            'created_at' => date('Y-m-d H:i:s'),
                            'is_deleted' => 0
                        ]);
                        // return $request->group_leaders;
    
                        if(isset($request->group_leaders)){
                            for($index = 0; $index < count($request->group_leaders); $index++){
                                /**
                                 * Check if Group Leader exist to detect if they already joined
                                 * if not then insert the Group Leader to join in the Group
                                 */
                                $isGroupLeaderExist = GroupLeader::whereIn('group_leader_name', $request->group_leaders)
                                ->where('status', 1) // 0-Not exist in Group, 1-Exist in Group
                                ->where('is_deleted', 0)
                                ->get();

                                if(count($isGroupLeaderExist) > 0){
                                    return response()->json(['isGroupLeaderExist'=> true, 'errorMessage'=>'The Group Leader already exist in a Group!']);
                                }else{
                                    GroupLeader::insert([
                                        'group_id' => $groupId,
                                        'group_leader_name' => $request->group_leaders[$index],
                                        'status' => 1, // 0-Not exist in Group, 1-Exist in Group	
                                        'created_at' => date('Y-m-d H:i:s')
                                    ]);

                                    DB::commit();
                                    return response()->json(['hasError' => 0]);
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        DB::rollback();
                        return response()->json(['hasError' => 1, 'exceptionError' => $e]);
                    }
                }
            }
        }
        // else{ /* For Update */
        //     $rules = [
        //         'group_name' => 'required|string',
        //         'group_code' => 'required|string',
        //     ];
    
        //     if(!isset($request->group_leaders)){
        //         $rules['group_leader_name'] = 'required';
        //     }else{
        //         $rules['group_leader_name'] = '';
        //     }

        //     $validator = Validator::make($data, $rules);
    
        //     if ($validator->fails()) {
        //         return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        //     } else {
        //         DB::beginTransaction();
        //         try {
        //             Group::where('id', $request->group_id)->update([
        //                 'group_name' => $request->group_name,
        //                 'group_code' => $request->group_code,
        //                 'updated_at' => date('Y-m-d H:i:s'),
        //                 'last_updated_by' => $_SESSION["session_user_id"]
        //             ]);

        //             // GroupLeader::where('group_id', $request->group_id)->delete();
        //             // if(isset($request->group_leaders)){
        //             //     for($index = 0; $index < count($request->group_leaders); $index++){
        //             //         GroupLeader::insert([
        //             //             'group_id' => $request->group_id,
        //             //             'group_leader_name' => $request->group_leaders[$index],
        //             //             'status' => 1, // 0-Not exist in Group, 1-Exist in Group	
        //             //             'created_at' => date('Y-m-d H:i:s')
        //             //         ]);
        //             //     }
        //             // }

        //             DB::commit();
        //             return response()->json(['hasError' => 0]);
        //         } catch (\Exception $e) {
        //             DB::rollback();
        //             return response()->json(['hasError' => 1, 'exceptionError' => $e]);
        //         }
        //     }
        // }
    }

    public function getGroupList(Request $request){
        date_default_timezone_set('Asia/Manila');
        $getGroupList = Group::with([
                'group_creator_info','group_leader_details.group_leader_name_info'
            ])->where('status', 1)
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(['getGroupList' => $getGroupList]);
    }

    public function getOneLatestGroup(Request $request){
        date_default_timezone_set('Asia/Manila');
        $getOneLatestGroup = Group::with([
                'group_creator_info','group_leader_details.group_leader_name_info'
            ])->where('status', 1)
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->take(1)
            ->get();
        return response()->json(['getOneLatestGroup' => $getOneLatestGroup]);
    }

    public function joinGroup(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $rules = [
            'group_id' => 'required|string',
            'group_code' => 'required|string',
            'decoded_hashed_group_id' => 'required|string',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            /**
             * Check if Group Code exist in the Group
             */
            $isGroupCodeExist = Group::with([
                'group_creator_info','group_leader_details.group_leader_name_info'
            ])->where('id', $request->decoded_hashed_group_id)
            ->where('group_code', $request->group_code)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->get();

            if(count($isGroupCodeExist) > 0){
                /**
                 * Check if Group Leader exist to detect if they already joined
                 * if not then insert the Group Leader
                 */
                // $isGroupLeaderExist = GroupLeader::where('group_id', $request->decoded_hashed_group_id)
                $isGroupLeaderExist = GroupLeader::where('group_leader_name', $request->group_leader)
                ->where('status', 1) // 0-Not exist in Group, 1-Exist in Group
                ->where('is_deleted', 0)
                ->get();

                $getGroupLeaderMemberDetails = GroupLeaderMember::where('member_name', $request->group_leader)
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->get();

                if(count($isGroupLeaderExist) > 0 || count($getGroupLeaderMemberDetails) > 0){
                    return response()->json(['isGroupLeaderExist'=> true, 'errorMessage'=>'You are already in a group!']);
                }else{
                    GroupLeader::insert([
                        'group_id' => $request->decoded_hashed_group_id,
                        'group_leader_name' => $request->group_leader,
                        'status' => 1, // 0-Not exist in Group, 1-Exist in Group
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    return response()->json(['successMessage'=> 'Successfully Join!']);
                }
                
            }else{
                return response()->json(['isGroupCodeExist'=> false, 'errorMessage'=>'Incorrect group code!']);
            }
        }
    }

    public function getMyGroup(Request $request){
        date_default_timezone_set('Asia/Manila');
        // $getGroupDetails = Group::where('group_leader_name', $request->session_user_id);
        $getGroupLeaderDetails = GroupLeader::with(['group_info.group_creator_info','group_leader_name_info'])->where('group_leader_name', $request->session_user_id)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->first();
            // return $getGroupLeaderDetails;
        $getGroupLeaderMemberDetails = GroupLeaderMember::where('member_name', $request->session_user_id)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->first();
            // return $getGroupLeaderMemberDetails;

        /**
         * Check if user is Group Leader
         */
        $getMyGroup = [];
        if($getGroupLeaderDetails != null){
            $getMyGroup = GroupLeader::with(['group_info.group_creator_info','group_leader_name_info'])->where('group_id', $getGroupLeaderDetails->group_id)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->first();
            return response()->json(['getMyGroup' => $getMyGroup, 'getGroupLeaderMemberDetails' => $getGroupLeaderMemberDetails]);
        }

        /**
         * Check if user is a Member
         */
        if($getGroupLeaderMemberDetails != null){
            $getMyGroup = GroupLeader::with(['group_info.group_creator_info','group_leader_name_info'])->where('group_id', $getGroupLeaderMemberDetails->group_id)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->first();
            return response()->json(['getMyGroup' => $getMyGroup, 'getGroupLeaderMemberDetails' => $getGroupLeaderMemberDetails]);
        }

        return response()->json(['getMyGroup' => $getMyGroup, 'getGroupLeaderMemberDetails' => $getGroupLeaderMemberDetails]);
        
    }
    
    public function leaveGroup(Request $request){
        $getGroupLeaderToBeDeleted = GroupLeader::where('group_leader_name', $request->session_user_id)->first();
        // return $getGroupLeaderToBeDeleted;
        if($getGroupLeaderToBeDeleted != null){
            GroupLeaderTitle::where('group_leader_id', $getGroupLeaderToBeDeleted->id)->delete();
            GroupLeaderMember::where('group_leader_id', $getGroupLeaderToBeDeleted->id)->delete();
            GroupLeader::where('group_leader_name', $request->session_user_id)->delete();
        }

        $getGroupMemberToBeDeleted = GroupLeaderMember::where('member_name', $request->session_user_id)
                ->where('status', 1)
                ->where('is_deleted', 0)
                ->first();
        // return $getGroupMemberToBeDeleted;
        if($getGroupMemberToBeDeleted != null){
            GroupLeaderMember::where('member_name', $getGroupMemberToBeDeleted->member_name)->delete();
        }
        
        
        return response()->json(['groupLeaderDeleted' => true, 'successMessage'=>'Left group Successfully']);
    }

    public function viewTitle(Request $request){
        $groupLeaderTitleDetails = GroupLeader::with([
                'section_info',
                'group_leader_name_info', 
                'group_leader_title_details',
                'group_leader_members_details.member_name_info',
            ])
            ->where('group_leader_name',$request->session_user_id)
            ->where('group_section', '!=', null)
            ->where('group_number', '!=', null)
            ->where('is_deleted', 0)
            ->get();
        // return $groupLeaderTitleDetails;
        $userLevel = User::where('id', $request->session_user_id)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->first();
        return DataTables::of($groupLeaderTitleDetails)
            ->addColumn('action', function($row) use($userLevel){
                $result = '';
                $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">No Action</span></center>';
                return $result;
            })
            ->addColumn('group_number', function($row){
                $result = "";
                $result .= '<center><span>'.$row->group_number.'</span></center>';
                return $result;
            })
            ->addColumn('title', function($row){
                $result = "";
                for ($i=0; $i < count($row->group_leader_title_details); $i++) {
                    if($row->group_leader_title_details[$i]->approval_status == 1){
                        $result .= '<center><span>'.$row->group_leader_title_details[$i]->title.' - <span class="badge badge-pill badge-success"> Approved</span></span></center>';
                    }else{
                        $result .= '<center><span class="">'.$row->group_leader_title_details[$i]->title.'</span></center>';
                    }
                }
                return $result;
            })
            ->addColumn('group_member', function($row){
                $result = "";
                for ($i=0; $i < count($row->group_leader_members_details); $i++) { 
                    $result .= '<center><span>'.$row->group_leader_members_details[$i]->member_name_info->fullname.'</span></center>';
                }
                return $result;
            })
            ->addColumn('status', function($row){
                $result = "";
                if($row->status == 0){
                    $result .= '<center><span class="badge badge-pill text-secondary" style="background-color: #E6E6E6">Not Active</span></center>';
                }else if($row->status == 1){
                    $result .= '<center><span class="badge badge-pill badge-success">Active</span></center>';
                }
                return $result;
            })
            
        ->rawColumns(['action','group_number','title', 'group_member', 'status'])
        ->make(true);
    }

    public function addTitle(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        
        $data = $request->all();
        $rules = [
            'group_number'  => 'required|numeric',
            'title.*'         => 'required',
        ];
        if(!isset($request->section)){
            $rules['section'] = 'required';
        }else{
            $rules['section'] = '';
        }
        if(!isset($request->group_members)){
            $rules['group_members'] = 'required';
        }else{
            $rules['group_members'] = '';
        }

        /* For Insert */
        if(!isset($request->title_id)){
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    $groupLeaderDetails = GroupLeader::with('group_leader_title_details')->where('group_leader_name', session('session_user_id'))
                        ->where('status', 1)
                        ->where('is_deleted', 0)
                        ->first();
                        if(count($groupLeaderDetails->group_leader_title_details) > 0){
                            return response()->json(['isSubmittedTitles' => true, 'errorMessage' => 'You already submitted titles']);
                        }else{
                            // $implodedGroupMember = implode(", ",$request->group_members);
                            GroupLeader::where('id', $groupLeaderDetails->id)->update([
                                'group_number'  => $request->group_number,
                                'group_section' => $request->section,
                                // 'group_member'  => $implodedGroupMember,
                            ]);
                            for ($i=0; $i < count($request->title); $i++) { 
                                $title = $request->title[$i];
                                GroupLeaderTitle::insert([
                                    'group_id'              => $groupLeaderDetails->group_id,
                                    'group_leader_id'       => $groupLeaderDetails->id,
                                    'title'                 => $title,
                                    'approval_status'       => 0,
                                    'created_at'            => date('Y-m-d H:i:s'),
                                ]);
                            }

                            for ($i=0; $i < count($request->group_members); $i++) { 
                                $memberName = $request->group_members[$i];
                                GroupLeaderMember::insert([
                                    'group_id'              => $groupLeaderDetails->group_id,
                                    'group_leader_id'       => $groupLeaderDetails->id,
                                    'member_name'           => $memberName,
                                    'status'                => 1,
                                    'created_at'            => date('Y-m-d H:i:s'),
                                ]);
                            }
                            
                            DB::commit();
                            return response()->json(['hasError' => 0, 'successMessage' => 'Successfully Added!']);
                        }
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => 1, 'exceptionError' => $e]);
                }
            }
        }
    }
}
