<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;

class HomeController extends Controller
{
    public function __construct(){
       $this->middleware('auth:metft'); 
    }
    public function index(){
        /* email-password or authorization token */
        return "index";
    }
}
