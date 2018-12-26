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
            return array('user'=>$user,'frinds'=>$frinds,'hobbies'=>$hobbies);
    }




    public static function getTasksList($data){
        $params=array();
        $params[]=1000;
        $params[]=0;
        try {
            $res=DB::select("SELECT 
              id,
              task_name,
              status,
              isDeleted,
              id,
              DATE_FORMAT(added_date, '%d/%m/%Y %H:%i:%s') as added_date
 
            FROM tasks where isDeleted=0 order by id desc LIMIT ? OFFSET ?",$params);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return $res;
    }
    public static function getSummary($data){
        $summary=DB::select('SELECT 
            SUM(IF(status=1 ,1,0)) as completed,
            SUM(IF(status=0 ,1,0)) as uncompleted,
            count(1) as total
              FROM tasks WHERE isDeleted=0');
        return $summary;
    }
    public static function addNewTask($data){
        $task_name_count=DB::select('select * from tasks where task_name = ? ',array($data['task_name']));
        if(empty($task_name_count)){
            try {
                $res=DB::table('tasks')->insert(array('task_name'=>$data['task_name']));
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        }else{
            $res='is_exist';
        }
        return $res;
    }
    public static function editTask($data){
        try {
            /*$res=DB::table('tasks')->where('id','=',$data['id'])->update(array(
                'task_name'=>$data['task_name'],
               /* 'status'=>$data['status'],
                'update_date'=>date('Y-m-d h:i:s'),*/
            $res=DB::table('tasks')->where('id','=',$data['id'])->update(array(
                'update_date'=>date('Y-m-d h:i:s'),
                'status'=>$data['status'],
                'task_name'=>$data['task_name'],
            ));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return $res;
    }
    public static function deleteTask($data){
        try {
            $res=DB::table('tasks')->where('id','=',$data['id'])->update(array('isDeleted'=>1));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return $res;
    }

}