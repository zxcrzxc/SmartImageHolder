<?php

use App\Http\Controllers\Albums;
use Illuminate\Support\Facades\Route;

/*
Нужно изменить сохранение файлов под название альбомов а не по дате сохранения,
чтобы было возможно изменять картинки в альбоме, придумать как сделать удаление. 
Реализовать аватарки альбомов, для этого необходимо задать в бд поле.

Для пользователя:
в альбоме необходимо будет задать id пользователя(лей) доступных к просмотру (типо паблик/приват)
нужно будет сделать хеадер для пользователя. нужно будет работать с куки для сохранения авторизованного пользователя
*/

Route::get('/create_album', [Albums::class, 'curse_create_album_get'])->name('albums.create');
Route::post('/create_album',[Albums::class,'curse_create_album_post']);

Route::get('/albums',[Albums::class, 'curse_index'])->name('albums_main');
Route::get('/my_albums',[Albums::class, 'my_albums'])->name('my_albums');

Route::get('/',[Albums::class, 'main_page'])->name('main_page');
Route::get('/editAlbum/{id}',[Albums::class, 'album_edit'])->name('albums.edit');
Route::put('/editAlbum/{id}',[Albums::class,'album_update'])->name('albums.update');

Route::get('/album/{id}', [Albums::class, 'album_show'])->name('album.show');

Route::delete('/album/{id}', [Albums::class,'album_destroy'])->name('albums.destroy');

Route::get('/editAlbumAddImages/{id}',[Albums::class, 'addImage'])->name('albums.addImages');
Route::post('/editAlbumAddImages/{id}',[Albums::class, 'addImagePost'])->name('albums.addImages');
Route::post('/deleteImage/{name}',[Albums::class, 'deleteImagePost'])->name('albums.deleteImage');
Route::post('/deleteUserPhotoPost/{name}',[Albums::class, 'deleteUserPhotoPost'])->name('albums.deleteUserPhotoPost');

Route::get('/registration',[Albums::class, 'registrationPage'])->name('registrationPage');
Route::post('/registrationPost',[Albums::class, 'registrationPagePost'])->name('registrationPagePost');

Route::get('/login',[Albums::class, 'loginPage'])->name('loginPage');
Route::get('/loginProblem',[Albums::class, 'loginPageProblem'])->name('loginPageProblem');
Route::post('/login',[Albums::class, 'loginPagePost'])->name('loginPagePost');
Route::get('/logout',[Albums::class, 'logoutPagePost'])->name('logoutPagePost');

Route::get('/myAccount',[Albums::class, 'myaccount'])->name('myaccount');
Route::get('/changeMyAcc',[Albums::class, 'changeMyAcc'])->name('changeMyAcc');
Route::put('/changeMyAcc',[Albums::class, 'changeMyAccPost'])->name('changeMyAccPost');

Route::get('/changeMyAccPwd',[Albums::class, 'changeMyAccPwd'])->name('changeMyAccPwd');
Route::put('/changeMyAccPwdPost',[Albums::class, 'changeMyAccPwdPost'])->name('changeMyAccPwdPost');

Route::get('/searchWithTags',[Albums::class, 'searchWithTags'])->name('searchWithTags');


Route::get('/user_id{id}', [Albums::class, 'profileViewer'])->name('profileViewer');
Route::get('/albums_user_id{id}', [Albums::class, 'users_albums_viewer'])->name('users_albums_viewer');
//Route::get('/', function () {
// return view('myView');
//});
