<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\HomeModel;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function getAllDataOfUser()
    {
        $dataUser=HomeModel::getUserData(Auth::id());
        $user=$dataUser['user'];
        $frinds=$dataUser['frinds'];
        $notFrinds=$dataUser['notfrinds'];
        $hobbiesList=$dataUser['hobbies'];
        $hobbies_of_user=explode(',',$user->hobbies);
        foreach ($hobbies_of_user as $key=>$value){
            $hobbies_of_user[$key]=$hobbiesList[$value];
        }
        $user->hobbies=$hobbies_of_user;
        $user->frinds=$frinds;
        $user->other=$notFrinds;

        return response()->json(
            array('status'=>'success','data'=>$user)
        );
    }
    public function showAllFriends()
    {
        $dataUser=HomeModel::showAllFriends(Auth::id());
        if(!empty($dataUser) && is_array($dataUser)){
            $result= array('status'=>'success','data'=>$dataUser);
        }else{
            $result= array('status'=>'error','data'=>$dataUser);
        }
        return response()->json(
            $result
        );
    }
    public function showBrithdays()
    {
        $dataUser=HomeModel::showBrithdays(Auth::id());
        $result= array('status'=>'success','data'=>$dataUser);
        return response()->json(
            $result
        );
    }
    public function showPotenialFriends()
    {
        $dataUser=HomeModel::showPotenialFriends(Auth::id());
        $result= array('status'=>'success','data'=>$dataUser);
        return response()->json(
            $result
        );
    }
    public function showUpcomingBrithdays()
    {
        $dataUser=HomeModel::showUpcomingBrithdays(Auth::id());
        $result= array('status'=>'success','data'=>$dataUser);
        return response()->json(
            $result
        );
    }
    public function addFriend(Request $request)
    {
        $requestd=$request->all();
        $res=HomeModel::addFriend(Auth::id(),$requestd);
        if($res==true){
            $result=array('status'=>'success','msg'=>'added success');
        }else{
            $result=array('status'=>'error','msg'=>$res);
        }

        return response()->json(
            $result
        );
    }
    public function deleteFriend(Request $request)
    {
        $requestd=$request->all();
        $res=HomeModel::deleteFriend(Auth::id(),$requestd);
        if($res==true){
            $result=array('status'=>'success','msg'=>'added success');
        }else{
            $result=array('status'=>'error','msg'=>$res);
        }

        return response()->json(
            $result
        );
    }
}
