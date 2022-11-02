<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        /* email-password or authorization token */
        Auth::login();
        return "index";
    }
}
