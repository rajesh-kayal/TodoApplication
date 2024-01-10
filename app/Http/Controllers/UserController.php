<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function signup(Request $req){
        
        $data= DB::table('users')->insert([
            'name'      =>$req->input('name'),
            'email'     =>$req->input('email'),
            'phone'     =>$req->input('phone'),
            'pass1'     =>password_hash($req->input('pass1'),PASSWORD_DEFAULT)
        ]);
        if($data ==1){
            return response()->json(['message'=>'success']);
        }else{
            return response()->json(['message' => 'error']);
        }
    }

    public function login(Request $req)
    {
        $user = DB::table('users')->where('email', $req->input('email'))->get();
        if (empty($user[0]))
            return response()->json(['message' => 'user doesnot exists !']);
        else {
            $db_old_hashed_pass = $user[0]->pass1;
            $check = password_verify($req->input('pass1'), $db_old_hashed_pass);
            if ($check) {
                $req->session()->put('USER', $user[0]->name);
                $req->session()->put("USER-ID", $user[0]->user_id);
                $req->session()->put('login_time', date('d-m-y h:i:sA'));
                $req->session()->put('IP', $_SERVER['REMOTE_ADDR']);
                return response()->json(['message' => 'success']);
            } else
                return response()->json(['message' => 'Wrong Cridentials !!']);
        }
    }
    public function logout(Request $req){
        $req->session()->flush();
        return response()->json(['message'=>'success']);
    }
}