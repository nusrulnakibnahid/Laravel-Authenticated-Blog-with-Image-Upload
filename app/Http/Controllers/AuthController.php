<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function dashboard(){
        $user_id = Auth::user()->id;
        $categoriesCount = Category::count();
        $postsCount = Post::where('user_id', $user_id)->count();
        return view('admin.dashboard', compact('categoriesCount', 'postsCount'));
    }

    public function registertationPage()
    {
        return view('auth.register');
    }

    public function register(Request $request){

        // dd($request->all());
        $request->validate( [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        Auth::attempt($request->only('email', 'password'));

        return redirect()->route('login');
    }


    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate( [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($request->only('email', 'password'))){
            return back()->with('status', 'Invalid login details');
        }

        return redirect()->route('dashboard');
    }


     public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
