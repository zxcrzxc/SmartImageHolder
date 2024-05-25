<?php

namespace App\Http\Controllers;

ob_start();
session_start();

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTimeZone;

class Albums extends Controller
{
    public function curse_index(){
        $result = DB::select('Select * from `albums`');
        //$autors = DB::select('Select `id` from `album_users` where ');
        //dd(sizeof($result));
        $images=array();
        $autors=array();
        for ($i = 0;$i<sizeof($result);$i++){
            $images[$i] = DB::select('Select `name` from `images` where album=? Limit 1',[$result[$i]->id]);
            $autors[$i] = DB::select('Select `email` from `album_users` where id=?',[$result[$i]->creater_id]);
        }
        //dump($autors);
        //dd($images[0][0]);
        //dd(number_format( $result[0]->id));
        $count=0;
        return view('image.albumsViewer',['albums'=>$result, 'images'=>$images, 'autors'=>$autors ,'count'=>$count]);
    }
    public function curse_create_album_get(){
        return view('image.uploadAlbum');
    }
    public function curse_create_album_post(Request $req){
        $arrayWithData = $req->all();
        
        DB::insert('INSERT INTO `albums`(`name`, `hashtag`,`creater_id`) VALUES (?, ?, ?)', 
        [$arrayWithData['title'], $arrayWithData['hashtag'], $_SESSION['id']]);

        

        $last_id = DB::select('SELECT `id` FROM `albums` ORDER by `id` DESC LIMIT 1');
        //dump($last_id[0]->id);
        return redirect()->route('album.show',['id'=>$last_id[0]->id]);
    }
    public function album_show(Request $request, string $id){
        $result = DB::select('Select * from `albums` where id=?',[$id]);
        $images = DB::select('Select `name` from `images` where album=?',[$id]);
        
        $redirect2AllAlbums=$request->all();

        return view('image.showAlbum',['album'=>$result[0],'img'=>$images,
        'redirect2AllAlbums'=>$redirect2AllAlbums['redirect2AllAlbums']]);
    }
    public function album_edit(string $id){
        $result = DB::select('Select * from `albums` where id=?',[$id]);
        $images = DB::select('Select `name` from `images` where album=?',[$id]);
        return view('image.editAlbum',['album'=>$result[0]],['img'=>$images]);
    }
    public function album_update(Request $request, string $id){
        DB::update('UPDATE `albums` SET `name`= ?,`hashtag`=? WHERE id=?',
        [$request->name,$request->hashtag,$id]);
        return redirect()->route('album.show',['id'=>$id]);
    }
    public function addImage(string $id){
        $result = DB::select('Select * from `albums` where id=?',[$id]);
        return view('image.addImages',['album'=>$result[0]]);
    }
    public function addImagePost(Request $req){
        for ($i=0;$i<sizeof($req->img);$i++){
            //Преобразование названия изображения для его дальнейшего сохранения
            //счетчик-время.png(или другие)
            $filename = $i.'-'.time().'.'.$req->img[$i]->getClientOriginalExtension();
            //dump($req->id);
            request()->img[$i]->move(public_path('images'), $filename);

            DB::insert('INSERT INTO `images`(`name`, `album`) VALUES (?, ?)', [$filename, $req->id]);
        }
        return redirect()->route('album.show',['id'=>$req->id]);
    }
    public function album_destroy(string $id){
        DB::delete('DELETE FROM `albums` WHERE id=?',[$id]);
        return redirect()->back();
    }
    public function deleteImagePost(string $name){
        DB::delete('DELETE FROM `images` WHERE name=?',[$name]);
        return redirect()->back();
    }
    public function registrationPage(){
        if (!isset($_SESSION["username"]))
            return view('image.registrationPage');
        else return redirect()->route('main_page');
    }

    public function registrationPagePost(Request $req){
        $arrayWithData = $req->all();
        $password=$arrayWithData['password'];
        $pwdhash=password_hash($password,PASSWORD_DEFAULT);
        $now = (new DateTime('now', new DateTimeZone('Europe/Moscow')) )->format('Y-m-d H:i:s');
        $existornot=DB::select('SELECT * FROM `album_users` where email=?',[$arrayWithData['eMail']]);
        if ($existornot==[]){
            DB::insert('INSERT INTO `album_users`(`email`, `fname`, `sname`, `tname`, `birth_date`, `password`, `created_at`, `updated_at`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)', 
            [   $arrayWithData['eMail'], $arrayWithData['fname'],
                $arrayWithData['sname'], $arrayWithData['tname'],
                $arrayWithData['birthdate'], $pwdhash,
                $now, $now]);
                return view('image.regsuccess',['success'=>true]);
        }
        else return view('image.regsuccess',['success'=>false]);
    }
    public function loginPage(){
        if (!isset($_SESSION["username"]))
            return view('image.loginPage');
        else return redirect()->route('main_page');
    }
    public function loginPagePost(Request $req){
        $arrayWithData = $req->all();
        $password=$arrayWithData['password'];
        $eMail=$arrayWithData['eMail'];
        
        $dataFromDB=DB::select('SELECT * FROM `album_users` where email=?',[$eMail]);
        
        if (!isset($_SESSION["username"]))
            if ($dataFromDB!=[]){
                if(password_verify($password,$dataFromDB[0]->password)){
                    $_SESSION['eMail']=$eMail;
                    $_SESSION['id']=$dataFromDB[0]->id;
                    $_SESSION['username']=$dataFromDB[0]->fname;
                    $_SESSION['password']=$password;
                    
                    return redirect()->route('main_page');
                }
                else $msg="Неправильный пароль";
            }
            else $msg="Аккаунта с такой почтой не существует";
        else $msg="Вы уже авторизованы";
        return view('image.loginPageResult',['massage'=>$msg]); 
    }

    public function logoutPagePost(){
        unset($_SESSION['eMail']);
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        return redirect()->back();
    }
    public function main_page(){
        return view('image.mainPage');
    }

    public function myaccount(){
        
        if (isset($_SESSION["username"])){
            $dataFromDB=DB::select('SELECT * FROM `album_users` where email=?',[$_SESSION['eMail']]);
            
            $time = strtotime($dataFromDB[0]->birth_date);
            $newformat = date('d.m.Y',$time);
            
            return view('image.myacc',['dataFromDB'=>$dataFromDB[0],'bdate'=>$newformat]);
        }
        else return redirect()->route('main_page');
    }
    public function changeMyAcc(){       
        if (isset($_SESSION["username"])){ 
            $dataFromDB=DB::select('SELECT * FROM `album_users` where email=?',[$_SESSION['eMail']]);
            return view('image.changeMyAcc',['dataFromDB'=>$dataFromDB[0]]);
        }
        else return redirect()->route('main_page');
    }
    public function changeMyAccPost(Request $request){
        if (isset($_SESSION["username"])){ 
            $now = (new DateTime('now', new DateTimeZone('Europe/Moscow')) )->format('Y-m-d H:i:s');

            DB::update('UPDATE `album_users` SET `fname`= ?,`sname`=?,`tname`=?,`birth_date`=?,`updated_at`=? WHERE email=?',
            [$request->fname, 
            $request->sname,
            $request->tname,
            $request->birthdate,
            $now,
            $_SESSION["eMail"]]);
            return redirect()->route('myaccount');
        }
        else return redirect()->route('main_page');
    }

    public function changeMyAccPwd(){
        if (isset($_SESSION["username"])){ 
            return view('image.changeMyAccPwd');
        }
        else return redirect()->route('main_page');
    }
    public function changeMyAccPwdPost(Request $request){
        if (isset($_SESSION["username"])){ 
            $pwdhash=password_hash($request->password,PASSWORD_DEFAULT);
            $now = (new DateTime('now', new DateTimeZone('Europe/Moscow')) )->format('Y-m-d H:i:s');

            DB::update('UPDATE `album_users` SET `password`= ?, `updated_at`=? WHERE email=?',
            [$pwdhash,
            $now,
            $_SESSION["eMail"]]);
            return redirect()->route('myaccount');
        }
        else return redirect()->route('main_page');
    }

    public function my_albums(){
        if (isset($_SESSION["username"])){ 
            $result = DB::select('Select * from `albums` where `creater_id`=?',[$_SESSION['id']]);
            //dd(sizeof($result));
            $images=array();
            for ($i = 0;$i<sizeof($result);$i++){
                $images[$i] = DB::select('Select `name` from `images` where album=? Limit 1',[$result[$i]->id]);
            }
            //dd($images[0][0]);
            //dd(number_format( $result[0]->id));
            $count=0;
            return view('image.myAccAlbumsViewer',['albums'=>$result, 'images'=>$images, 'count'=>$count]);
        }
        else return redirect()->route('main_page');
    }
}