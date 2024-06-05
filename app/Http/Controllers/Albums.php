<?php

namespace App\Http\Controllers;

ob_start();
session_start();

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DateTimeZone;
use Illuminate\Support\Facades\File; 


class Albums extends Controller
{

    public function array_of_tags_to_string($get_tags_from_db){
        $tags=array();
        for($i=0;$i<sizeof($get_tags_from_db);$i++)
            $tags[$i]=$get_tags_from_db[$i]->hashtag;
        $hashtag_string=implode(', ',$tags);
        return $hashtag_string;
    }
    public function string_of_tags_to_array_from_request($request, $tag_for_search){
        $tags=$request->all();
        $tags=$tags[$tag_for_search];
        $tags=str_replace(' ','',$tags);
        $tags_array=array();
        $tags_array=explode(",",$tags);
        return $tags_array;
    }

    public function curse_index(){
        $result = DB::select('Select * from `albums` where `private`=1 order by `id` desc');
        
        $images=array();
        $autors=array();
        $hashtags=array();

        for ($i = 0;$i<sizeof($result);$i++){
            $images[$i] = DB::select('Select `name` from `images` where album=? Limit 1',[$result[$i]->id]);
            $autors[$i] = DB::select('Select * from `album_users` where id=?',[$result[$i]->creater_id]);
            $hashtags[$i] = DB::select('Select `hashtag` from `hashtags` where album_id=?',[$result[$i]->id]);
        }
        
        $hashtag_strings_arrag=array();
        for($i=0;$i<sizeof($hashtags);$i++)
            $hashtag_strings_arrag[$i]=Albums::array_of_tags_to_string($hashtags[$i]);
    
        $count=0;
        return view('shablon.albumsViewer',
        ['albums'=>$result, 'images'=>$images, 
        'autors'=>$autors ,'count'=>$count,
        'hashtags'=>$hashtag_strings_arrag,
        'searched_tags'=>"",
        'search_end'=>"",'search_start'=>"",
        'isThatSearch4AllAlbums'=>false]);
    }
    public function curse_create_album_get(){
        return view('shablon.createAlbum');
    }
    public function curse_create_album_post(Request $req){
        if (isset($_SESSION["username"])){
            $arrayWithData = $req->all();
            if ($req->private==null)    $private=false;
            else $private=true;
            $now = (new DateTime('now', new DateTimeZone('Europe/Moscow')) )->format('Y-m-d H:i:s');
            DB::insert('INSERT INTO `albums`(`name`, `hashtag`,`creater_id`,`created_at`,`updated_at`,`private`) 
            VALUES (?, ?, ?, ?, ?, ?)', 
            [$arrayWithData['name'], $arrayWithData['desc'], $_SESSION['id'],
            $now,$now,$private]);
            
            $last_id = DB::select('SELECT `id` FROM `albums` ORDER by `id` DESC LIMIT 1');
            $last_id=$last_id[0]->id;

            $array_of_tags=Albums::string_of_tags_to_array_from_request($req,'hashtag');
            for ($i=0;$i<sizeof($array_of_tags);$i++)    {            
                $array_of_tags[$i]=mb_strtolower($array_of_tags[$i]);
                DB::insert('INSERT INTO `hashtags`(`album_id`,`hashtag`) VALUES (?, ?)',
                [$last_id, $array_of_tags[$i]]);
            }
            if(!$req->img==null){
                for ($i=0;$i<sizeof($req->img);$i++){
                    $filename = time().'-'.$i.'.'.$req->img[$i]->getClientOriginalExtension();
                    //dump($req->id);
                    request()->img[$i]->move(public_path('images'), $filename);
                    
                    DB::insert('INSERT INTO `images`(`name`, `album`) VALUES (?, ?)', [$filename, $last_id]);
                }
            }
            return redirect()->route('my_albums');
        }
        else return redirect()->route('main_page');
    }
    public function album_show(Request $request, string $id){
        $result = DB::select('Select * from `albums` where id=?',[$id]);
        $images = DB::select('Select `name` from `images` where album=?',[$id]);
        $hashtags_select = DB::select('Select `hashtag` from `hashtags` where album_id=?',[$id]);
        $hashtags_string = Albums::array_of_tags_to_string($hashtags_select);

        if ($hashtags_string=="") $hashtags_string="none";

        $redirect2AllAlbums=$request->all();
        $autorSelect = DB::select('Select * from `album_users` where id=?',[$result[0]->creater_id]);

        $autor = $autorSelect[0]->sname." ".$autorSelect[0]->fname;

        //dump($hashtags_string);
        return view('shablon.showAlbum',['album'=>$result[0],'img'=>$images,
        'redirect2AllAlbums'=>$redirect2AllAlbums['redirect2AllAlbums'], 'hashtags'=>$hashtags_string, 
        'autor'=>$autor]);
    }
    public function album_edit(string $id){
        if (isset($_SESSION["username"])){
            $result = DB::select('Select * from `albums` where id=?',[$id]);
            $images = DB::select('Select `name` from `images` where album=?',[$id]);
            $get_tags_from_db=DB::select('SELECT `hashtag` from `hashtags` where `album_id`=?',[$id]);
            
            $hashtag_string=Albums::array_of_tags_to_string($get_tags_from_db);
            return view('shablon.editAlbum',['album'=>$result[0],'img'=>$images,'hashtag_string'=>$hashtag_string]);
        }
        else return redirect()->route('main_page');
    }
    public function album_update(Request $request, string $id){
        $now = (new DateTime('now', new DateTimeZone('Europe/Moscow')) )->format('Y-m-d H:i:s');
        if ($request->private==null)    $private=false;
        else $private=true;
        DB::update('UPDATE `albums` SET `name`= ?,`hashtag`=?,`updated_at`=?,`private`=? WHERE id=?',
        [$request->name,$request->decr,$now,$private,$id]);

        $tags_array=Albums::string_of_tags_to_array_from_request($request,'hashtag');
        dump($tags_array);
        DB::delete('DELETE FROM `hashtags` WHERE album_id=?',[$id]);
        for($i=0;$i<sizeof($tags_array);$i++){
            $tags_array[$i]=mb_strtolower($tags_array[$i]);
            DB::insert('INSERT INTO `hashtags`(`album_id`,`hashtag`) VALUES (?, ?)', 
            [$id, $tags_array[$i]]);
        }
        if(!$request->img==null){
            for ($i=0;$i<sizeof($request->img);$i++){
                $filename = time().'-'.$i.'.'.$request->img[$i]->getClientOriginalExtension();
                //dump($req->id);
                request()->img[$i]->move(public_path('images'), $filename);
                
                DB::insert('INSERT INTO `images`(`name`, `album`) VALUES (?, ?)', [$filename, $request->id]);
            }
        }
        return redirect()->route('albums.edit', ['id'=>$id]);
    }
    public function addImage(string $id){
        if (isset($_SESSION["username"])){
            $result = DB::select('Select * from `albums` where id=?',[$id]);
            return view('image.addImages',['album'=>$result[0]]);
        }
        else return redirect()->route('main_page');
    }
    public function addImagePost(Request $req){
        for ($i=0;$i<sizeof($req->img);$i++){
            //Преобразование названия изображения для его дальнейшего сохранения
            //счетчик-время.png(или другие)
            $filename = time().'-'.$i.'.'.$req->img[$i]->getClientOriginalExtension();
            //dump($req->id);
            request()->img[$i]->move(public_path('images'), $filename);

            $now = (new DateTime('now', new DateTimeZone('Europe/Moscow')) )->format('Y-m-d H:i:s');
            
            DB::insert('INSERT INTO `images`(`name`, `album`) VALUES (?, ?)', [$filename, $req->id]);
        }
        DB::update('UPDATE `albums` SET `updated_at`=? WHERE id=?',
            [$now,$req->id]);
        return redirect()->route('album.show',['id'=>$req->id,'redirect2AllAlbums'=>false]);
    }
    public function album_destroy(string $id){
        //dump($_SESSION["username"]);

        if (isset($_SESSION["username"])){
            $image_name_array=array();
            $image_name_select=DB::select('SELECT `name` FROM `images` WHERE album=?',[$id]);
            for($i=0;$i<sizeof($image_name_select);$i++){
                $image_name_array[$i]='\images\\'.$image_name_select[$i]->name;
                File::delete(public_path($image_name_array[$i]));
                //unlink($image_name_array[$i]);
            }

            DB::delete('DELETE FROM `albums` WHERE id=?',[$id]);
            DB::delete('DELETE FROM `images` WHERE album=?',[$id]);
            DB::delete('DELETE FROM `hashtags` WHERE album_id=?',[$id]);
            return redirect()->route('my_albums');
        }
        else return redirect()->route('main_page');
    }
    public function deleteImagePost(string $name){
        DB::delete('DELETE FROM `images` WHERE name=?',[$name]);
        File::delete(public_path('\images\\'.$name));
        return redirect()->back();
    }
    public function deleteUserPhotoPost(string $name){
        DB::delete('DELETE FROM `profile_images` WHERE name=?',[$name]);
        File::delete(public_path('\images\profile_images\\'.$name));
        return redirect()->back();
    }
    public function registrationPage(){
        if (!isset($_SESSION["username"]))
            return view('shablon.createmyacc');
        else return redirect()->route('main_page');
    }

    public function registrationPagePost(Request $req){
        $arrayWithData = $req->all();
        $password=$arrayWithData['password'];
        $pwdhash=password_hash($password,PASSWORD_DEFAULT);
        $now = (new DateTime('now', new DateTimeZone('Europe/Moscow')) )->format('Y-m-d H:i:s');
        $existornot=DB::select('SELECT * FROM `album_users` where email=?',[$arrayWithData['eMail']]);
        
        if ($existornot==[]){
            DB::insert('INSERT INTO `album_users`(`email`, `fname`, `sname`, `tname`, `birth_date`, `password`, `created_at`, `updated_at`,`info`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', 
            [   
                $arrayWithData['eMail'], $arrayWithData['fname'],
                $arrayWithData['sname'], $arrayWithData['tname'],
                $arrayWithData['birth_date'], $pwdhash,
                $now, $now, $arrayWithData['info']]);

                $last_id = DB::select('SELECT `id` FROM `album_users` ORDER by `id` DESC LIMIT 1');

                if(!$req->img==null){
                    for ($i=0;$i<sizeof($req->img);$i++){
                        $filename = time().'-'.$i.'-id_'. $last_id[0]->id.'.'.$req->img[$i]->getClientOriginalExtension();
                        //dump($req->id);
                        request()->img[$i]->move(public_path('images\profile_images'), $filename);
                        
                        DB::insert('INSERT INTO `profile_images`(`name`, `user`) VALUES (?, ?)', [$filename, $last_id[0]->id]);
                    }
                }
                return redirect()->route("loginPage");
        }
        else return view('shablon.createmyacc',['msg'=>'Почта занята']);
    }
    public function loginPage(){
        if (!isset($_SESSION["username"]))
            return view('shablon.login',['massage'=>'']);
        else return redirect()->route('main_page'); 
    }
    public function loginPageProblem(Request $req){
        $rrq=$req->all();
        if (!isset($_SESSION["username"]))
            return view('shablon.login',['massage'=>$rrq["massage"]]);
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
                    $_SESSION['username']=$dataFromDB[0]->sname." ".$dataFromDB[0]->fname;
                    $_SESSION['password']=$password;
                    
                    return redirect()->route('myaccount');
                }
                else $msg="Неправильный пароль";
            }
            else $msg="Аккаунта с такой почтой не существует";
        else $msg="Вы уже авторизованы";
        return redirect()->route('loginPageProblem', ['massage'=>$msg]);
    }

    public function logoutPagePost(){
        unset($_SESSION['eMail']);
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        return redirect()->back();
    }
    public function main_page(){
        return view('shablon.main');
    }

    public function myaccount(){
        
        if (isset($_SESSION["username"])){
            $dataFromDB=DB::select('SELECT * FROM `album_users` where email=?',[$_SESSION['eMail']]);
            
            $time = strtotime($dataFromDB[0]->birth_date);
            $newformat = date('d.m.Y',$time);

            $dataFromDBaboutProfileImage=DB::select('SELECT `name` FROM `profile_images` where user=?',[$_SESSION['id']]);
            $dataFromDBaboutAllMyAlbums=DB::select('SELECT * FROM `albums` where creater_id=?',[$_SESSION['id']]);

            $countOfImages=array();
            $idOfArrays=array();
            $arrayOfImages=array();

            $countOfArrayOfImg=0;
            $dateOfAlbums=array();
            for ($i=0; $i<sizeof($dataFromDBaboutAllMyAlbums);$i++){
                $countOfImages[$i]=0;
                $images=DB::select('SELECT * FROM `images` where album=?',[$dataFromDBaboutAllMyAlbums[$i]->id]);
                //dump($dataFromDBaboutAllMyAlbums[$i]->name);
                $dateOfAlbums[$i]=$dataFromDBaboutAllMyAlbums[$i]->updated_at;
                $idOfArrays[$i]=$dataFromDBaboutAllMyAlbums[$i]->id;
                for ($j=0; $j<sizeof($images);$j++){
                    $arrayOfImages[$countOfArrayOfImg++]=$images[$j]->name;
                    $countOfImages[$i]++;
                }

            }
            $newArrayOfImages=array();
            shuffle($arrayOfImages);
            //dump($arrayOfImages);
            if(sizeof($arrayOfImages)>6){
                for($i=0; $i<6;$i++)
                    $newArrayOfImages[$i]=$arrayOfImages[$i];
                unset($arrayOfImages);
                $arrayOfImages=$newArrayOfImages;
            }
            elseif(sizeof($arrayOfImages)==0) 
                $arrayOfImages[0]="noimage.jpg";

            if ($dataFromDBaboutProfileImage!=[]) 
                $profileIMG=$dataFromDBaboutProfileImage[0]->name;
            else $profileIMG="noimage.jpg";
            $profileIMGs=array();
            if ($dataFromDBaboutProfileImage!=[]) {
                for($i=0;$i<sizeof($dataFromDBaboutProfileImage);$i++){
                    $profileIMGs[$i]=$dataFromDBaboutProfileImage[$i]->name;
                }
            }
            else    $profileIMGs[0]="noImageHd.png";

            $count4dateAndNumberOfImages=0;
            return view('shablon.myacc',['dataFromDB'=>$dataFromDB[0],
            'bdate'=>$newformat,'profile_image'=>$profileIMG,
            'arrayOfImages'=>$arrayOfImages,'dateOfAlbums'=>$dateOfAlbums ,
            'countOfImages'=>$countOfImages,'count'=>$count4dateAndNumberOfImages,
            'idOfArrays'=>$idOfArrays,
            'profileIMGs'=>$profileIMGs ]);
        }
        else return redirect()->route('main_page');
    }
    public function changeMyAcc(){       
        if (isset($_SESSION["username"])){ 
            $dataFromDB=DB::select('SELECT * FROM `album_users` where email=?',[$_SESSION['eMail']]);
            $dataAboutImagesOfUser=DB::select('SELECT * FROM `profile_images` where user=?',[$_SESSION['id']]);
            return view('shablon.changeMyAcc',
            ['dataFromDB'=>$dataFromDB[0],'photos'=>$dataAboutImagesOfUser]);
        }
        else return redirect()->route('main_page');
    }
    public function changeMyAccPost(Request $req){
        if (isset($_SESSION["username"])){ 
            $now = (new DateTime('now', new DateTimeZone('Europe/Moscow')) )->format('Y-m-d H:i:s');

            DB::update('UPDATE `album_users` SET `fname`= ?,`sname`=?,`tname`=?,`birth_date`=?,`updated_at`=?, `info`=? WHERE email=?',
            [   
                $req->fname, 
                $req->sname,
                $req->tname,
                $req->birth_date,
                $now, $req->info,
                $_SESSION["eMail"]]);

                if(!$req->img==null){

                    $select=DB::select('SELECT * FROM `profile_images` where `user`=?',[$_SESSION["id"]]);
                    //dump($select==[]);
                    //DB::delete('DELETE FROM `profile_images` WHERE user=?',[$_SESSION["id"]]);
                    //if ($select!=[])
                        //File::delete(public_path('\images\profile_images\\'.$select[0]->name));



                    if(!$req->img==null){
                        for ($i=0;$i<sizeof($req->img);$i++){
                            $filename = time().'-'.$i.'-id_'. $_SESSION["id"].'.'.$req->img[$i]->getClientOriginalExtension();
                            //dump($req->id);
                            request()->img[$i]->move(public_path('images\profile_images'), $filename);
                            
                            DB::insert('INSERT INTO `profile_images`(`name`, `user`) VALUES (?, ?)', [$filename, $_SESSION["id"]]);
                        }
                    }
                }


            return redirect()->route('myaccount');
        }
        else return redirect()->route('main_page');
    }
    /*
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
    }*/

    public function my_albums(){
        if (isset($_SESSION["username"])){ 
            $result = DB::select('Select * from `albums` where `creater_id`=? order by `id` desc',[$_SESSION['id']]);
            //dd(sizeof($result));
            $images=array();
            $hashtags=array();
            for ($i = 0;$i<sizeof($result);$i++){
                $images[$i] = DB::select('Select `name` from `images` where album=? Limit 1',[$result[$i]->id]);
                $hashtags[$i] = DB::select('Select `hashtag` from `hashtags` where album_id=?',[$result[$i]->id]);
            }
            $hashtag_strings_arrag=array();
            for($i=0;$i<sizeof($hashtags);$i++)
                $hashtag_strings_arrag[$i]=Albums::array_of_tags_to_string($hashtags[$i]);
        
            //dd($images[0][0]);
            //dd(number_format( $result[0]->id));
            $count=0;
            return view('shablon.albumsViewer',
            ['albums'=>$result, 'images'=>$images, 
            'count'=>$count,
            'hashtags'=>$hashtag_strings_arrag,
            'searched_tags'=>"",
            'search_end'=>"",'search_start'=>"",
            'isThatSearch4AllAlbums'=>true]);
        }
        else return redirect()->route('main_page');
    }

    public function searchWithTags(Request $req){

        $array_of_tags=array();
        $rrq=$req->all();
        
        $array_of_tags=(Albums::string_of_tags_to_array_from_request($req,'search_hashtags'));
        
        
        
        if (!$rrq["isThatSearch4AllAlbums"]){
            if(sizeof($array_of_tags)==1 && $array_of_tags[0]=="" && $rrq["search_start"]==""&& $rrq["search_end"]==""){
                return redirect()->route("albums_main");
            }
            elseif (sizeof($array_of_tags)==1 && $array_of_tags[0]=="" && $rrq["search_start"]!=""&& $rrq["search_end"]!="")
                $result=DB::select('SELECT * from `albums` WHERE `updated_at`>? and `updated_at`<? order by `id` desc',
                [$rrq["search_start"],$rrq["search_end"]]);
            elseif(sizeof($array_of_tags)==1 && $array_of_tags[0]=="" && $rrq["search_start"]==""){
                $result=DB::select('SELECT * from `albums` WHERE `updated_at`<? order by `id` desc',
                [$rrq["search_end"]]);
            }
            elseif(sizeof($array_of_tags)==1 && $array_of_tags[0]=="" && $rrq["search_end"]==""){
                $result=DB::select('SELECT * from `albums` WHERE `updated_at`>? order by `id` desc',
                [$rrq["search_start"]]);
            }
            else{
                $select_array=array();
                for($i=0;$i<sizeof($array_of_tags);$i++)
                    $select_array[$i]=DB::select('SELECT * FROM `hashtags` WHERE `hashtag`=?',[$array_of_tags[$i]]);
                
                $array_of_id=array();
                $array_count_of_tags=array();

                for($j=0;$j<sizeof($select_array[0]);$j++){
                    $array_of_id[$j]=$select_array[0][$j]->album_id;
                    $array_count_of_tags[$j]=1;
                }

                for($i=0;$i<sizeof($array_of_id);$i++)
                    for($j=0;$j<sizeof($select_array);$j++)
                        for($g=0;$g<sizeof($select_array[$j]);$g++)
                            if($array_of_id[$i]==$select_array[$j][$g]->album_id)
                                $array_count_of_tags[$i]++;

                $use_alb=array();
                $count_of_albums=0;
                for($i=0;$i<sizeof($array_of_id);$i++)
                    if ($array_count_of_tags[$i]==sizeof($array_of_tags)+1)
                        $use_alb[$count_of_albums++]=$array_of_id[$i];
                $resultative_search_array=array();
                if ($rrq["search_start"]!="" && $rrq["search_end"]!="")
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        $resultative_search_array[$i]=DB::select('SELECT * from `albums` WHERE `id`=? and `updated_at`>? and `updated_at`<? and `private`=1 order by `id` desc',
                        [$use_alb[$i],$rrq["search_start"],$rrq["search_end"]]);
                elseif($rrq["search_start"]=="" && $rrq["search_end"]!="")
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        $resultative_search_array[$i]=DB::select('SELECT * from `albums` WHERE `id`=? and `updated_at`<? and `private`=1 order by `id` desc',
                        [$use_alb[$i],$rrq["search_end"]]);
                elseif($rrq["search_end"]=="" && $rrq["search_start"]!="")
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        $resultative_search_array[$i]=DB::select('SELECT * from `albums` WHERE `id`=? and `updated_at`>? and `private`=1 order by `id` desc',
                        [$use_alb[$i],$rrq["search_start"],]);
                else
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        $resultative_search_array[$i]=DB::select('SELECT * from `albums` WHERE `id`=? and `private`=1',
                        [$use_alb[$i]]);
                $result=array();
                $orderbydesc=0;
                for($i=0;$i<sizeof($resultative_search_array);$i++)
                    if ($resultative_search_array[$i]!=[])
                        $orderbydesc++;
                if(sizeof($resultative_search_array)==1 && $resultative_search_array[0]==[])
                    $result[0]=$resultative_search_array[0];
                else
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        if($resultative_search_array[$i]!=[])
                            $result[--$orderbydesc]=$resultative_search_array[$i][0];
            }
        }
        else{
            if(sizeof($array_of_tags)==1 && $array_of_tags[0]=="" && $rrq["search_start"]==""&& $rrq["search_end"]=="")
                return redirect()->route("my_albums");
            
            elseif (sizeof($array_of_tags)==1 && $array_of_tags[0]=="" && $rrq["search_start"]!=""&& $rrq["search_end"]!="")
                $result=DB::select('SELECT * from `albums` WHERE `updated_at`>? and `updated_at`<? and `creater_id`=?',
                [$rrq["search_start"],$rrq["search_end"],$_SESSION["id"]]);
            elseif(sizeof($array_of_tags)==1 && $array_of_tags[0]=="" && $rrq["search_start"]=="")
                $result=DB::select('SELECT * from `albums` WHERE `updated_at`<? and `creater_id`=?',
                [$rrq["search_end"],$_SESSION["id"]]);
            
            elseif(sizeof($array_of_tags)==1 && $array_of_tags[0]=="" && $rrq["search_end"]=="")
                $result=DB::select('SELECT * from `albums` WHERE `updated_at`>? and `creater_id`=?',
                [$rrq["search_start"],$_SESSION["id"]]);
            
            else{
                $select_array=array();
                for($i=0;$i<sizeof($array_of_tags);$i++)
                    $select_array[$i]=DB::select('SELECT * FROM `hashtags` WHERE `hashtag`=?',[$array_of_tags[$i]]);
            
                $array_of_id=array();
                $array_count_of_tags=array();

                for($j=0;$j<sizeof($select_array[0]);$j++){
                    $array_of_id[$j]=$select_array[0][$j]->album_id;
                    $array_count_of_tags[$j]=1;
                }

                for($i=0;$i<sizeof($array_of_id);$i++)
                    for($j=0;$j<sizeof($select_array);$j++)
                        for($g=0;$g<sizeof($select_array[$j]);$g++)
                            if($array_of_id[$i]==$select_array[$j][$g]->album_id)
                                $array_count_of_tags[$i]++;

                $use_alb=array();
                $count_of_albums=0;
                for($i=0;$i<sizeof($array_of_id);$i++)
                    if ($array_count_of_tags[$i]==sizeof($array_of_tags)+1)
                        $use_alb[$count_of_albums++]=$array_of_id[$i];
                $resultative_search_array=array();
                if ($rrq["search_start"]!="" && $rrq["search_end"]!="")
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        $resultative_search_array[$i]=DB::select('SELECT * from `albums` WHERE `id`=? and `updated_at`>? and `updated_at`<? and `creater_id`=?',
                        [$use_alb[$i],$rrq["search_start"],$rrq["search_end"],$_SESSION["id"]]);
                elseif($rrq["search_start"]=="" && $rrq["search_end"]!="")
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        $resultative_search_array[$i]=DB::select('SELECT * from `albums` WHERE `id`=? and `updated_at`<? and `creater_id`=?',
                        [$use_alb[$i],$rrq["search_end"],$_SESSION["id"]]);
                elseif($rrq["search_end"]=="" && $rrq["search_start"]!="")
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        $resultative_search_array[$i]=DB::select('SELECT * from `albums` WHERE `id`=? and `updated_at`>? and `creater_id`=?',
                        [$use_alb[$i],$rrq["search_start"],$_SESSION["id"]]);
                else
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        $resultative_search_array[$i]=DB::select('SELECT * from `albums` WHERE `id`=? and `creater_id`=?',
                        [$use_alb[$i],$_SESSION["id"]]);
                $result=array();
                $orderbydesc=0;
                for($i=0;$i<sizeof($resultative_search_array);$i++)
                    if ($resultative_search_array[$i]!=[])
                        $orderbydesc++;
                if(sizeof($resultative_search_array)==1 && $resultative_search_array[0]==[])
                    $result[0]=$resultative_search_array[0];
                else
                    for ($i=0;$i<sizeof($use_alb);$i++)
                        if($resultative_search_array[$i]!=[])
                            $result[--$orderbydesc]=$resultative_search_array[$i][0];
            }
        }
        $images=array();
        $autors=array();
        $hashtags=array();
        
        if ($result!=[])
            for ($i = 0;$i<sizeof($result);$i++){
                $images[$i] = DB::select('Select `name` from `images` where album=? Limit 1',[$result[$i]->id]);
                $autors[$i] = DB::select('Select * from `album_users` where id=?',[$result[$i]->creater_id]);
                $hashtags[$i] = DB::select('Select `hashtag` from `hashtags` where album_id=?',[$result[$i]->id]);
            }
        else $result=[];
        $hashtag_strings_arrag=array();
        for($i=0;$i<sizeof($hashtags);$i++)
            $hashtag_strings_arrag[$i]=Albums::array_of_tags_to_string($hashtags[$i]);

        $tags=$req->all();
        $tags=$tags["search_hashtags"];
        $count=0;
        //dump($resultative_search_array);
        return view('shablon.albumsViewer',
        ['albums'=>$result, 'images'=>$images,
        'autors'=>$autors ,'count'=>$count,
        'hashtags'=>$hashtag_strings_arrag,'searched_tags'=>$tags,
        'search_end'=>$rrq["search_end"],'search_start'=>$rrq["search_start"],
        'isThatSearch4AllAlbums'=>$rrq["isThatSearch4AllAlbums"]]);
    }
    
    public function profileViewer(Request $request, string $id){

        $dataFromDB=DB::select('SELECT * FROM `album_users` where id=?',[$id]);
        
        if ($_SESSION["username"]==$dataFromDB[0]->nickname)
            return redirect()->route('myaccount');
        else{
            $time = strtotime($dataFromDB[0]->birth_date);
            $newformat = date('d.m.Y',$time);
        
            return view('image.profileViewer',['dataFromDB'=>$dataFromDB[0],'bdate'=>$newformat]);
        }
    }
    public function users_albums_viewer(string $id){
        $result = DB::select('Select * from `albums` where `creater_id`=? order by `id` desc',[$id]);
        //dd(sizeof($result));
        $images=array();
        $hashtags=array();
        for ($i = 0;$i<sizeof($result);$i++){
            $images[$i] = DB::select('Select `name` from `images` where album=? Limit 1',[$result[$i]->id]);
            $hashtags[$i] = DB::select('Select `hashtag` from `hashtags` where album_id=?',[$result[$i]->id]);
        }
        $hashtag_strings_arrag=array();
        for($i=0;$i<sizeof($hashtags);$i++)
            $hashtag_strings_arrag[$i]=Albums::array_of_tags_to_string($hashtags[$i]);
    
        //dd($images[0][0]);
        //dd(number_format( $result[0]->id));
        $count=0;
        return view('image.profileAlbumViewer',
        ['albums'=>$result, 'images'=>$images, 
        'count'=>$count,'hashtags'=>$hashtag_strings_arrag]);

    }

}