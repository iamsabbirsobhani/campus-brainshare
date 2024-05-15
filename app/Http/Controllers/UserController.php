<?php

namespace App\Http\Controllers;

use Cloudinary\Transformation\Resize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\Role;

use Cloudinary\Cloudinary;


class UserController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return view('userprofile', [
                "username" => Auth::user()->name, "courses" => $user->courses, "role" => Auth::user()->role->account_type, "bio" => Auth::user()->bio, "available" => $user->available,
                "profilephotourl" => $user->profilephotourl
            ]);
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
        $gender = $_POST['gender'];
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
            $user->bio = "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit temporibus ad officiis accusamus facere recusandae? Temporibus doloribus earum, exercitationem voluptatem deserunt placeat minus veniam ea. Aut voluptatibus corporis ea! Quam nobis distinctio totam voluptatibus reiciendis magnam mollitia voluptates, maiores odio neque fuga. Vero est deserunt, dicta adipisci eos quos voluptate magnam, dolor pariatur, quaerat cum ratione nobis modi nemo facere distinctio explicabo eum error! Aspernatur in dignissimos laudantium praesentium quisquam quibusdam accusantium! Ea laudantium eius delectus sequi provident tempore natus laborum totam ipsa adipisci ad omnis, vitae itaque illum eum perspiciatis iste architecto neque incidunt explicabo, sint voluptas ipsum?";
            if ($gender == "male") {
                $user->profilephotourl = "https://res.cloudinary.com/dxfwriq5h/image/upload/v1715766442/6_tkf6jy.jpg";
            } else {
                $user->profilephotourl = "https://res.cloudinary.com/dxfwriq5h/image/upload/v1715766434/1_dqebro.jpg";
            }
            $user->available = false;
            $user->password = Hash::make($password);
            $user->role_id = $role->id;
            $user->save();

            // return view("/userprofile", ["username" => $username, "email" => $email, "role" => $account_type, "bio" => $user->bio]);

            Auth::login($user);

            // Get the authenticated user after creating the account
            $user = Auth::user();

            // Return the user profile view with the user's information
            return view('userprofile', ["username" => $user->name, "courses" => $user->courses, "role" => $user->role->account_type, "bio" => $user->bio, "profilephotourl" => $user->profilephotourl, "available" => $user->available]);
        } else {
            echo "User already exists";
        }
    }


    public function editprofile(Request $request)
    {
        $bio = $_POST['bio'];
        $available = $_POST['available'];
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

        if (isset($available)) {

            // $user->available = $request->has('available') ? $request->available : 0;
            $user = User::find(Auth::user()->id);
            $user->available = ($user->available == 1) ? 1 : ($request->filled('available') ? $request->available : 0);
        }


        $user->save();

        // echo $request->profile_pic;

        $cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('CN_CLOUD_NAME'),
                    'api_key'    => env("CN_CLOUD_API_KEY"),
                    'api_secret' => env("CN_CLOUD_API_SECRET"),
                ],
            ]
        );
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $imagePath = $image->getRealPath();
            $name = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->getRealPath();

            $result = $cloudinary->uploadApi()->upload($imagePath, [
                'public_id' => $name,
                'folder' => 'profile_pics'
            ]);

            $url = $result['url'];

            User::where('id', Auth::user()->id)->update(['profilephotourl' => $url]);
        }

        if (!isset($er_msg)) {
            $new_user = User::find(Auth::user()->id);

            return view('/userprofile', ["username" => $user->name, "courses" => $new_user->courses, "bio" => $user->bio, "role" => $user->role->account_type, "available" => $user->available, "profilephotourl" => $new_user->profilephotourl]);
        } else {
            return view("/editprofile", ["username" => $user->name, "role" => $user->role->account_type, "er_msg" => $er_msg, "profilephotourl" => $user->profilephotourl]);
        }
    }


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
            return view('userprofile', ["username" => $user->name, "bio" => $user->bio, "courses" => $user->courses, "role" => $user->role->account_type, "er_msg" => "", "profilephotourl" => $user->profilephotourl, "available" => $user->available]);
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

    // check if a user is an expert in a course like this:
    // if ($user->courses()->where('course_id', $courseId)->exists()) {
    //     // The user is an expert in the course
    // }
    // get all expert users in a course like this:


    public function getallexpertsoncourses(Request $request)
    {
        $course = Course::where('name', 'LIKE', '%' . $request->coursename . '%')->first();
        if ($course) {
            $experts = $course->users;
            return view('expertsoncourse', ["experts" => $experts, "course" => $course->name, "er_msg" => ""]);
        } else {
            // Handle the case where no course was found
            // For example, you can return a view with an error message
            return view('expertsoncourse', ["experts" => [], "course" => "", "er_msg" => "Course not found."]);
        }
    }

    // get all courses a user is an expert in like this:
    // $courses = $user->courses;


    // get a single user profile from user table link is /profile/{id} by given url id
    public function profile($id)
    {
        $user = User::find($id);
        if ($user) {
            return view('profile', [
                "username" => $user->name,
                "courses" => $user->courses,
                "role" => $user->role->account_type,
                "bio" => $user->bio,
                "available" => $user->available,
                "profilephotourl" => $user->profilephotourl
            ]);
        } else {
            return back()->withErrors([
                'error' => 'User not found.',
            ]);
        }
    }
}
