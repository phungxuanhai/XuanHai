<?php
/**
 * Created by PhpStorm.
 * User: xuanhai
 * Date: 23/12/2018
 * Time: 19:48
 */

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HomeController extends BaseController
{
public function ShowController(){
//    return "Hello Controller $thesup ";
    return view('index');
}
}