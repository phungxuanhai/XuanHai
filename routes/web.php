<?php
use App\Post;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('about',function(){
//return 'Xin chào bạn';
//});
////Route::get('/', function () {
////    return view('welcome');
////});
//
//Route::get('about/{welcome}',function($welcome){
//    return $welcome. 'Xin chào bạn';
//});
//
//
//
//Route::get('about/{hello}/{haha}',function($hello,$haha){
//    return $hello.$haha. 'Xin chào bạn';
//});
//
//
//Route::get('what',function(){
//    return Redirect::to('about');
//});
//
//
//
//Route::get('/','HomeController@ShowController');
//
//
//Route::get('name/{thesup}','HomeController@ShowController');
//
//Route::get('/select',function (){
//    $select=DB::select('select * from posts where id=?',[1]);
//    return $select;
//});
//Route::get('delete',function (){
//    $delete=DB::select('delete from posts where id=?',[1]);
//    return $delete;
//});
//
//Route::get('readall',function (){
//    $posts= Post::all();
//    foreach ($posts as $p){
//        return $p->tile;
//    }
//});
//
//Route::get('find',function (){
//    $posts= Post::where('id',1)
//        //->where('body','like','%2')
//    ->orderBy('id','desc')
//    ->take(1)
//    ->get();
//    foreach ($posts as $p){
//        return $p->tile;
//    }
//});
//
//Route::get('insertModel',function (){
//    $p=new Post;
//    $p->id=2;
//    $p->tile='Xuan';
//    $p->body='Hai';
//    $p->save();
//});
//Route::get('goi-sub',function (){
//    return view('sub');
//});
//Route::get('nhung',function (){
//    return view('welcome');
//});




Route::get('loai',function (){
    return view('page.loai_sanpham');
});

Route::get('index',[
    'as'=>'trang-chu',
    'uses'=>'PageController@getIndex'
]);
Route::get('loai-san-pham/{type}',[
    'as'=>'loaisanpham',
    'uses'=>'PageController@getLoaiSp'
]);
Route::get('chi-tiet-san-pham/{id}',[
    'as'=>'chitietsanpham',
    'uses'=>'PageController@getChiTietSp'
]);
Route::get('lien-he',[
    'as'=>'lienhe',
    'uses'=>'PageController@getLienHe'
]);
Route::get('gioi-thieu',[
    'as'=>'gioithieu',
    'uses'=>'PageController@getGioiThieu'
]);

Route::get('add-to-cart/{id}',[
    'as'=>'themgiohang',
    'uses'=>'PageController@getAddToCart'
]);
Route::get('del-cart/{id}',[
    'as'=>'xoagiohang',
    'uses'=>'PageController@getDelItemCart'
]);
Route::get('dat-hang',[
    'as'=>'dathang',
    'uses'=>'PageController@getCheckOut'
]);
Route::post('dat-hang',[
    'as'=>'dathang',
    'uses'=>'PageController@postCheckOut'
]);
Route::get('dang-nhap',[
    'as'=>'login',
    'uses'=>'PageController@getLogin'
]);
Route::get('dang-ki',[
    'as'=>'signup',
    'uses'=>'PageController@getSignup'
]);
Route::post('dang-ki',[
    'as'=>'signup',
    'uses'=>'PageController@postSignup'
]);
Route::post('dang-nhap',[
    'as'=>'login',
    'uses'=>'PageController@postLogin'
]);
Route::get('dang-xuat',[
    'as'=>'logout',
    'uses'=>'PageController@getLogout'
]);
Route::get('search',[
    'as'=>'search',
    'uses'=>'PageController@getsearch'
]);