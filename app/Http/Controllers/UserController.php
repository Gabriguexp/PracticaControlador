<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
class UserController extends Controller{
    
    public function login(Request $request){
        $data = [];
        if ($request->session()->exists('token')){
            return redirect('products');
        }
        if($request->session()->exists('message') && $resources = $request->session()->exists('code') ){

            $data['message'] = $resources = $request->session()->get('message');
            $data['code'] = $resources = $request->session()->get('code');
        }
        var_dump($data);
        return view('login', $data);
    }
    
    public function checkLogin(Request $request){
        $user = "Admin";
        $pass = "8c31b65bdecdc9f18b695d7318186fd1feed690d";
        $inputUser = $request->input('user');
        $inputPass = $request->input('pass');
        if($user == $inputUser && $pass == sha1($inputPass)){
            $request->session()->put('token', '$token');
            return redirect('products');
        } else {
            $data = [];
            $data['code'] = 400;
            $data['message'] = "Ha ocurrido algún error en sus credenciales de usuario, intentelo de nuevo.";
            // $request->session()->put('code', 400);
            // $request->session()->put('message', "Ha ocurrido algún error en sus credenciales de sesión, intentelo de nuevo.");
            return back()->withInput()->with($data);
        }
    }
    
    public function logout(Request $request){
        if ($request->session()->exists('token')){
            $request->session()->forget('token');
        }
        return redirect('login');
    }
}
