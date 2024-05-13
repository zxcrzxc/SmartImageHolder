<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Albums extends Controller
{
    public function curse_index(){
        $result = DB::select('Select * from `albums`');
        //dd(sizeof($result));
        $images=array();
        for ($i = 0;$i<sizeof($result);$i++){
            $images[$i] = DB::select('Select `name` from `images` where album=? Limit 1',[$result[$i]->id]);
        }
        //dd($images[0][0]);
        //dd(number_format( $result[0]->id));
        $count=0;
        return view('image.albumsViewer',['albums'=>$result, 'images'=>$images, 'count'=>$count]);
    }
    public function curse_create_album_get(){
        return view('image.uploadAlbum');
    }
    public function curse_create_album_post(Request $req){
        //dump($req);
        $arrayWithData = $req->all();
        //dump($arrayWithData['title']);
        //dump($arrayWithData['hashtag']);
        DB::insert('INSERT INTO `albums`(`name`, `hashtag`) VALUES (?, ?)', 
        [$arrayWithData['title'], $arrayWithData['hashtag']]);
        $last_id = DB::select('SELECT `id` FROM `albums` ORDER by `id` DESC LIMIT 1');
        //dump($last_id[0]->id);
        return redirect()->route('album.show',['id'=>$last_id[0]->id]);
    }
    public function album_show(string $id){
        $result = DB::select('Select * from `albums` where id=?',[$id]);
        $images = DB::select('Select `name` from `images` where album=?',[$id]);
        
        return view('image.showAlbum',['album'=>$result[0]],['img'=>$images]);
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
        return view('image.registrationPage');
    }
    public function loginPage(){
        return view('image.loginPage');
    }
    public function main_page(){
        return view('image.mainPage');
    }
}
