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
    public static function showAllFriends($id){
        try {
            $allFrinds=DB::select("SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday1,
              user_hobbies.hobbies
 
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            ");
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }


        return $allFrinds;
    }
    public static function showUpcomingBrithdays($id){
        try {
            $allFrinds=DB::select("SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday1,
              user_hobbies.hobbies
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            WHERE  DAY(brithday)>=DAY(NOW()) AND MONTH (brithday)>=MONTH(NOW())
            ");
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }


        return $allFrinds;
    }
    public static function showPotenialFriends($id){
        try {
            $user=DB::select("SELECT 
              id,
              brithday,
              user_hobbies.hobbies
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            where id=?",array($id));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }


        $user=$user[0];


/*
        $minusFive = date('m-d', mktime(0, 0, 0, date('m',strtotime($user->brithday)), date('d',strtotime($user->brithday)) - 5));
        $plusFive = date('m-d', mktime(0, 0, 0, date('m',strtotime($user->brithday)), date('d',strtotime($user->brithday)) + 5));*/
        $year=DATE('Y');
        $hobbbiesArr=explode(',',$user->hobbies);
        $whereStr='';
        $start=false;
        $params=array();
        foreach ($hobbbiesArr as $d){

            $whereStr.= $start==false?'AND (user_hobbies.hobbies LIKE ?':' OR user_hobbies.hobbies LIKE ?';
            $params[]="%$d%";
            $start=true;

        }
        if($start==true){
            $whereStr.=')';
        }

        try {
            $allFrinds=DB::select("SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday1,
              user_hobbies.hobbies
 
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            WHERE DATE(DATE_FORMAT(brithday,'$year-%m-%d')) BETWEEN DATE(DATE_FORMAT(DATE_ADD(DATE(NOW()), INTERVAL -5 DAY),'%Y-%m-%d')) AND DATE(DATE_FORMAT(DATE_ADD(DATE(NOW()), INTERVAL +5 DAY),'%Y-%m-%d')) $whereStr  
            ",$params);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }


        return $allFrinds;
    }
    public static function showBrithdays($id){
        $friendListStr="";
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
        $friendListStr.=$user->friends_list; //level1********************************************

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
        foreach ($frinds as $f){
            if(!empty($f->friends_list)){
                $friendListStr.=','.$f->friends_list;//level2************************************************


                $frindsList1=explode(',',$f->friends_list);
                $whereStr1=rtrim(str_repeat('?,',count($frindsList1)),',');
                $frinds1=DB::select("SELECT 
                      id,
                      `name`,
                      username,
                      email,
                      friends_list,
                      DATE_FORMAT(brithday, '%d/%m/%Y') as brithday,
                      user_hobbies.hobbies
         
                    FROM users 
                    INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
                    where id in ($whereStr1) ",$frindsList1);
                foreach ($frinds1 as $f1){
                    if(!empty($f1->friends_list)) {
                        $friendListStr .= ',' . $f1->friends_list;//level3****************************************************

                    }
                 }

            }


        }
        $frindsListfinal=explode(',',$friendListStr);
        $frindsListfinal=array_unique($frindsListfinal);
        $frindsListfinalArr=array();
        foreach ($frindsListfinal as $ff){
            $frindsListfinalArr[]=$ff;
        }

        unset($frindsListfinal);
        $year=DATE('Y');
        //after i get all frind ids after 2 level
        $whereStr=rtrim(str_repeat('?,',count($frindsListfinalArr)),',');
        $sql="SELECT 
              id,
              `name`,
              username,
              email,
              friends_list,
              DATE_FORMAT(brithday, '%d/%m/%Y') as brithday1,
              user_hobbies.hobbies
            FROM users 
            INNER JOIN user_hobbies ON (user_hobbies.user_id=id)
            where id in ($whereStr) AND DATE(DATE_FORMAT(brithday,'$year-%m-%d')) BETWEEN DATE(DATE_FORMAT(DATE(NOW()),'%Y-%m-%d')) AND DATE(DATE_FORMAT(DATE_ADD(DATE(NOW()), INTERVAL 14 DAY),'%Y-%m-%d'))   ORDER BY DATE_FORMAT(brithday, '%m') ASC";
        $frindsFinal=DB::select($sql,$frindsListfinalArr);

        return $frindsFinal;
    }


}