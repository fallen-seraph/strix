<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
class pagesController extends Controller
{
    public function index(){
        return view('pages.welcome');
    }
    public function pricing(){
        return view('pages.pricing');
    }
    public function tour(){
        return view('pages.tour');
    }
    public function support(){
        return view('pages.support');
    }
    public function aboutus(){
        return view('pages.about');
    }
}
