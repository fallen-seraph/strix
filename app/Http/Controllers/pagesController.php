<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
class pagesController extends Controller
{
    public function index(){
        return view('index');
    }
    public function pricing(){
        return view('pricing');
    }
    public function support(){
        return view('index');
    }
    public function aboutus(){
        return view('about');
    }
}
