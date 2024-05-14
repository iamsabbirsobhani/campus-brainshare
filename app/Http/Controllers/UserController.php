<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{

    public function create()
    {
        $username = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $account_type = $_POST['account_type'];
        $user = User::where('email', $username)->first();
        if (!$user) {
            $user = new User();
            $user->name = $username;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            $user->assignRole($account_type);
            echo "User created successfully";
            echo "Vaue", $user->id, "";
            // return view("/dashboard", ["username" => $username, "password" => $password]);
        }
    }
    public function login()
    {
        // Retrieve the login data from the form
        $username = $_POST['email'];
        $password = $_POST['password'];

        // Use the login data for further processing
        // ...

        $user = User::where('email', $username)->first();

        // Redirect or display a response
        if ($user) {
            echo 'User', $user->email, '';
        } else {
            echo 'No User found';
        }

        // ...
        // return view("/dashboard", ["username" => $username, "password" => $password]);
    }
}
