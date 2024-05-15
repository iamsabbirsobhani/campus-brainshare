<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\Role;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return view('userprofile', ["username" => Auth::user()->name, "courses" => $user->courses, "role" => Auth::user()->role->account_type, "bio" => Auth::user()->bio]);
        }

        // Authentication failed...
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function create(Request $request)
    {
        $username = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $account_type = $_POST['account_type'];
        $role = Role::where('account_type', $account_type)->first();
        if (!$role) {
            echo "Role not found";
            return;
        }
        $user = User::where('email', $username)->first();
        if (!$user) {
            $user = new User();
            $user->name = $username;
            $user->email = $email;
            $user->bio = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga ducimus assumenda eum vero quas? Reiciendis cumque officiis dolor quibusdam distinctio obcaecati voluptas, aperiam earum eveniet.";
            $user->available = false;
            $user->password = Hash::make($password);
            $user->role_id = $role->id;
            $user->save();

            // return view("/userprofile", ["username" => $username, "email" => $email, "role" => $account_type, "bio" => $user->bio]);

            Auth::login($user);

            // Get the authenticated user after creating the account
            $user = Auth::user();

            // Return the user profile view with the user's information
            return view('userprofile', ["username" => $user->name, "courses" => $user->courses, "role" => $user->role->account_type, "bio" => $user->bio]);
        } else {
            echo "User already exists";
        }
    }


    public function editprofile(Request $request)
    {
        $validatedData = $request->validate([
            'bio' => 'nullable|string',
            'expertise' => 'nullable|string|exists:courses,name',
            'available' => 'nullable|boolean',
        ]);

        $user = User::find(Auth::user()->id);

        if ($request->filled('expertise')) {
            $course = Course::where("name", $validatedData['expertise'])->first();
            if ($course && !$user->courses->contains($course->id)) {
                $user->courses()->attach($course, ['created_at' => now(), 'updated_at' => now()]);
            } else {
                $er_msg = "Course does not exist or is already added to the user's profile.";
            }
        }

        if ($request->filled('bio')) {
            $user->bio = $validatedData['bio'];
        }

        if ($request->filled('available')) {
            $user->available = $validatedData['available'];
        }

        $user->save();

        if (!isset($er_msg)) {
            $new_user = User::find(Auth::user()->id);

            return view('/userprofile', ["username" => $user->name, "courses" => $new_user->courses, "bio" => $user->bio, "role" => $user->role->account_type, "available" => $user->available]);
        } else {
            return view("/editprofile", ["username" => $user->name, "role" => $user->role->account_type, "er_msg" => $er_msg]);
        }
    }


    // public function editprofile(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'bio' => 'nullable|string',
    //         'expertise' => 'nullable|string|exists:courses,name',
    //         'available' => 'nullable|boolean',
    //     ]);
    //     $expertise = $_POST['expertise'];

    //     $user = User::find(Auth::user()->id);

    //     $course = Course::where("name", $expertise)->first();

    //     // echo "Course:", $course->name;
    //     // echo "Course:", $course->id;


    //     if ($course) {
    //         $user->courses()->attach($course);
    //     } else {
    //         // Handle the case where the course does not exist
    //     }


    //     if ($request->filled('bio')) {
    //         $user->bio = $validatedData['bio'];
    //     }

    //     if ($request->filled('available')) {
    //         $user->available = $validatedData['available'];
    //     }

    //     $user->save();

    //     return view('/userprofile', ["username" => $user->name, "bio" => $user->bio, "role" => $user->role->account_type]);
    // }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function userpro()
    {
        if (Auth::check()) {
            $user = User::where('email', Auth::user()->email)->first();
            $courses = $user->courses;
            return view('userprofile', ["username" => $user->name, "bio" => $user->bio, "courses" => $user->courses, "role" => $user->role->account_type, "er_msg" => ""]);
        } else {
            return redirect("/");
        }
    }


    public function edituserpro()
    {
        if (Auth::check()) {
            $user = User::where('email', Auth::user()->email)->first();
            return view('editprofile', ["username" => $user->name, "role" => $user->role->account_type, 'er_msg' => ""]);
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }


    public function usermessage()
    {
        if (Auth::check()) {
            $user = User::where('email', Auth::user()->email)->first();
            return view('message', ["username" => $user->name, "role" => $user->role->account_type]);
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }
}
