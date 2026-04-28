<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register( Request $request){
       $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        // Process the registration logic here, such as saving the user to the database
            $user = User::create($data);
        // For demonstration purposes, we'll just return a success message
            if($user){
                return redirect()->route('login')->with('success', 'User registered successfully');
            }else{
                return back()->with('error', 'Registration failed. Please try again.');
            }

        // return response()->json(['message' => 'User registered successfully', 'data' => $data]);
    }

        public function login(Request $request ){
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                // $request->session()->regenerate();

                return redirect()->route('dashboard')->with('success', 'Login successful');

            }else{
                return back()->with('error', 'Login failed. Please check your credentials and try again.');
            }
        }

        public function deshboradPage(){
            // if(Auth::check()){
                return view('dashboard');
            // }else{
            //     return redirect()->route('login')->with('error', 'Please login to access the dashboard');
            // }
        }


        public function addedPage(){
    
                return view('added');
        }

        
        public function accountSetupView(){
            return view('accountSetupView');
        }

                
        public function receiveView(){
            return view('receiveView');
        }

        public function Logout(){
            Auth::logout();
            return redirect()->route('login')->with('success', 'You have been logged out');
        }

        
}
