<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We could not find a user with that email address.'
        ]);

        try {
            DB::beginTransaction();

            $user = User::where('email', $request->email)->first();
            
            // Generate new random password
            $newPassword = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'), 0, 10);
            
            // Update user's password
            $user->password = Hash::make($newPassword);
            $user->save();

            // Send email with new password
            $name = $user->name;
            $url = env('APP_URL');
            $details = [
                'title' => 'Reset Password',
                'body' => "
                    Password reset request for $name has been processed.
                    Your new password is: $newPassword
                    Please login with this password at $url and change it immediately.",
            ];

            Mail::to($user->email)->send(
                new TestMail('Password Reset - CounselLink', 'email.user.create', $details)
            );

            DB::commit();

            return back()->with('status', 'We have emailed you a new password!');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error resetting password: ' . $e->getMessage());
            return back()->withErrors(['email' => 'There was an error sending the password reset email.']);
        }
    }
}