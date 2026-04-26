<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    
    public function index(){
        $value = session()->all(); // Using helper function to retrieve all session data as an array
        echo '<pre>';
        print_r($value);
        echo '</pre>';

        // $name = session()->get('name');
        $name = session('name', 'Default Name'); // Using helper function to retrieve session data with default value
        echo 'Name from session: ' . $name;
        echo '<br>';
        $address = session('Address', 'Default Address'); // Using helper function to retrieve session data with default value
        echo 'Address from session: ' . $address;
        echo '<br>';

        $value = session()->except(['name', 'Address','_previous']); // Using helper function to retrieve all session data as an array except for specific keys
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        echo '<br>';
        
        $value = session()->only(['name', 'Address']); // Using helper function to retrieve only specific session data as an array
        echo '<pre>';
        print_r($value);
        echo '</pre>';

        if (session()->has('name')) { // Using helper function to check if a specific session key exists
            echo 'Name exists in session.';
        } else {
            echo 'Name does not exist in session.';
        }
       echo '<br>';
        if (session()->exists('name')) { // Using helper function to check if a specific session key exists and is not null
            echo 'Name exists in session and is not null.';
        } else {
            echo 'Name does not exist in session or is null.';
        }
        session()->flash('message', 'This is a flash message.'); // Using helper function to store flash session data

        session()->regenerate(); // Using helper function to regenerate the session ID
        // dd($value);
    }

    public function storeSession(Request $request){

        session(['name' => 'John Doe',
                'email' => 'john.doe@example.com'
                ]); // Using helper function to store session data
        
        $request->session()->put('Address', '123 Main Street'); // Using request object to store session data

            $value = session()->all(); // Using helper function to retrieve all session data as an array
            echo '<pre>';
            print_r($value);
            echo '</pre>';
        session()->invalidate(); // Using helper function to invalidate the session

        return 'Session Stored';

    }

    public function deleteSession(){

        $value = session()->all(); // Using helper function to retrieve all session data as an array
        echo '<pre>';
        print_r($value);
        echo '</pre>';
        // session()->forget('name'); // To delete specific session data
        // session()->forget('Address');
        session()->flush(); // To delete all session data

        session()->invalidate(); // Using helper function to invalidate the session

        return 'Session Deleted';
        
    }


}
