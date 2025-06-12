<?php

namespace Velto\Axion\Controllers;


use Velto\Axion\Models\User;
use Velto\Axion\App\Auth;
use Velto\Axion\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        return view('axion::dashboard');
    }
    public function profile()
    {

        $profile = Auth::user();

        return view('axion::profile',['profile' => $profile]);

    }
    public function settings()
    {
        $profile = Auth::user();

        return view('axion::settings',[
            'profile' => $profile,
        ]);
    }
    public function updateProfile()
    {

        $request = request()->all();
        $picture = request()->file('picture');
        $hasPicture = !empty($picture['name']);
        $profile = [

            'name'  => $request['name'],
            'bio'   => $request['bio'],
        ];

        if ($hasPicture) {
            $profile['picture'] = storeImage($picture)->dir('profile_picture')->save();
        }

        User::where('user_id',Auth::user()->user_id)->update($profile);

        return to_route('settings');
    }
    public function deleteProfilePicture()
    {

        $profile = User::where('user_id', Auth::user()->user_id)->first();
    
        if ($profile && $profile->picture) {
            $imagePath = real_path($profile->picture);
    
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        User::where('user_id', Auth::user()->user_id)->update([
            'picture' => null
        ]);
    
        return to_route('settings');
    }
    public function updatePassword()
    {
        $data = request()->post();

        $errors = validate($data, [
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if (!empty($errors)) {
            flash()->error($errors);
            return redirect('/settings');
        }

        if (!password_verify($data['current_password'], Auth::user()->password)) {
            flash()->error(['current_password' => ['Current password is incorrect.']]);
            return redirect('/settings');
        }

        $user = User::where('user_id',Auth::user()->user_id);

        $user->update([
            'password' => bcrypt($data['password']),
        ]);

        flash()->success('Password updated successfully.');
        return to_route('settings');

    }
    
}