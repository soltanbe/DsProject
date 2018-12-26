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
        $dataUser=HomeModel::getUserData(Auth::id());
        $user=$dataUser['user'];
        $frinds=$dataUser['frinds'];
        $hobbiesList=$dataUser['hobbies'];
        $hobbies_of_user=explode(',',$user->hobbies);
        foreach ($hobbies_of_user as $key=>$value){
            $hobbies_of_user[$key]=$hobbiesList[$value];
        }
        $user->hobbies=$hobbies_of_user;
        return view('home',array('user'=>$user,'frinds'=>$frinds));
    }
}
