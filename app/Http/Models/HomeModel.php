<?php
namespace App\Http\Models;
use Illuminate\Support\Facades\DB;
use App\Exceptions;
class HomeModel{

    public static function getUserData($id){
        $user=DB::select("SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday,
              user_hobbies.hobbies
 
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            where id=?",array($id));
        $user=$user[0];
        $frindsList=explode(',',$user->friends_list);
        $whereStr=rtrim(str_repeat('?,',count($frindsList)),',');
        $frinds=DB::select("SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday,
              user_hobbies.hobbies
 
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            where id in ($whereStr) ",$frindsList);
        //get all hobbies
            $allHobbies=DB::select("SELECT 
              *
            FROM hobbies");
            $hobbies=array();
            foreach ($allHobbies as $h){
                $hobbies[$h->id]=$h->name;
            }
        $notFrindList=DB::select("SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday,
              user_hobbies.hobbies
 
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            where id not in ($whereStr) ",$frindsList);
            return array('user'=>$user,'frinds'=>$frinds,'notfrinds'=>$notFrindList,'hobbies'=>$hobbies);
    }


    public static function addFriend($userid,$data){
        try {
            $user=DB::select("SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday,
              user_hobbies.hobbies
 
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            where id=?",array($userid));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }


        $user=$user[0];
        $frindsList=explode(',',$user->friends_list);
        if(count($frindsList)>=5){
            //FIFO
            unset($frindsList[0]);
            $frindsList[0]=$data['frind_id'];
            ksort($frindsList);
        }else{
            $frindsList[]=$data['frind_id'];
        }

        $frindsList=implode(',',$frindsList);
        try {
            $res=DB::update('UPDATE users SET friends_list=? WHERE id=?',array($frindsList,$userid));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $res;


    }
    public static function deleteFriend($userid,$data){
        try {
            $user=DB::select("SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday,
              user_hobbies.hobbies
 
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            where id=?",array($userid));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }


        $user=$user[0];
        $frindsList=explode(',',$user->friends_list);
        foreach ($frindsList as $k=>$v){
            if($data['frind_id']==$v){
                unset($frindsList[$k]);
                break;
            }
        }
        $frindsList=implode(',',$frindsList);
        try {
            $res=DB::update('UPDATE users SET friends_list=? WHERE id=?',array($frindsList,$userid));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }

        return $res;


    }


}