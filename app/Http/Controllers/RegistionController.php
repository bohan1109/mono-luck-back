<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Response;

class RegistionController extends Controller
{
    public function list(){
        //return Registion::all();
        return DB::table('MEMBERs')->select('*')->get();
        

    }
    


    public function search($phone){
        return Members::where("phone",$phone)->get();

    }

    public function find($phone){
        $member_id = DB::table("members")->where("phone",$phone)->value('member_id');
        //$members = DB::table('members')->where('phone', $member_id)->value('member_id');
        return $member_id;
        //return response()->json($a);
        
        
    }

    // public function deletetest($member_id){
    //     $locker = Members::find($member_id);
    //     $result = $locker->delete();
    //     if($result)
    //     {
    //         return ["Result"=>"success delete".$member_id];
    //     }
    //     else
    //     {
    //         return ["Result"=>"fail"];
    //     }

    // }

    // public function updatetest(Request $req){
    //     $locker = Members::find($req->member_id);
    //     $locker -> name=$req->name;
    //     $result = $locker->save();
    //     if($result)
    //     {
    //         return ["Result"=>"success"];
    //     }
    //     else
    //     {
    //         return ["Result"=>"fail"];
    //     }

    // }
    // public function abc(Request $req){
    //     return $this->find($req->phone);
    // }
    
    public function find_registrations(Request $req){
        $registions = Registions::where("member_id",$this->find($req->phone))->value('locker_id');
        return $registions;
    }


    public function add(Request $req)
    {
        $str = $req -> priority;
        $str = explode(',',$str);
        $pattern1="/^\d\d$/";
        $pattern2="/^\d\d,\d\d$/";
        $pattern3="/^\d{2}\,\d{2}\,\d{2}$/";
        $string = $req -> priority;
        
        
        $memberId=MemberController::findIdbyPhone($req->phone);
        if($memberId==NULL){
            return response("非暢遊會員,無法登記鎖櫃!",Response::HTTP_OK);
        }
        else{
            if(DB::table("REGISTRATIONs")->where("memberId",$memberId)->first()!=NULL){
                return response("您已登記過鎖櫃",Response::HTTP_OK);
                
            }
            else{
                if(preg_match($pattern1, $string) || preg_match($pattern2, $string) || preg_match($pattern3, $string)){
                    if(count($str)>0 && count($str)<=3){
                        $registrations = new Registion;
                        $registrations -> priority=$req -> priority;
                        $registrations -> memberId=$memberId;
                        $registrations->save();
                        return response("success",Response::HTTP_OK);
                        }else{
                            return "輸入錯誤";
                        }
                }else{
                    return "輸入錯誤";
                }
                
                
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
