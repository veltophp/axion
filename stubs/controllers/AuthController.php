<?php

namespace Velto\Axion\Controllers;

use Velto\Axion\Controller;
use Velto\Axion\Models\User;
use Velto\Axion\Session;
use Velto\Core\Mail;
use Velto\Core\Env;



class AuthController extends Controller
{

    public function login()
    {
        if (!Env::get('AUTH_LOGIN')) {
            abort(404);
        }        

        return view('axion::auth.login');
    }
    public function register()
    {
        if (!Env::get('AUTH_REGISTER')) {
            abort(404);
        } 

        return view('axion::auth.register');
    }
    public function verifyEmail()
    {
        $email = session()->email;

        if (!$email) {
            return redirect('/login');
        }

        $user = User::findBy('email', $email);

        if (!$user) {
            flash()->error('Account not found.');
            return redirect('/login');
        }

        if ($user->email_verified) {
            flash()->success('Your email is already verified. You can now log in.');
            return redirect('/login');
        }

        return view('axion::auth.verify-email', ['email' => $email]);
    }
    public function forgotPasswordForm()
    {
        return view('axion::auth.forgot-password');
    }
    public function submitForgotPassword()
    {
        $email = request()->post('email');
    
        if (!$email) {
            flash()->error('Please enter your email address.');
            return redirect('/forgot-password');
        }
    
        $user = User::findBy('email', $email);
    
        if (!$user) {
            flash()->error('We couldn’t find an account with that email address.');
            return redirect('/forgot-password');
        }
    
        $token = bin2hex(random_bytes(36));
    
        Session::set("reset_password_tokens.{$email}", $token);
    
        $url = route('reset.password', [
            'token' => $token,
            'email' => $email,
        ]);
        
        Mail::send(
            to: $email,
            subject: 'Reset Your Password',
            view: 'axion::reset-password',
            data: ['url' => $url, 'email' => $email]
        );
    
        flash()->success('A password reset link has been sent to your email address.');
        return redirect('/forgot-password');
    }
    public function resetPasswordForm($token, $email)
    {
        $decodedEmail = urldecode($email);

        $allTokens = Session::get('reset_password_tokens', []);
        $savedToken = $allTokens[$decodedEmail] ?? null;
        
        if (!$savedToken || $savedToken !== $token) {
            flash()->error('Invalid or expired reset link.');
            return redirect('/forgot-password');
        }

        return view('axion::auth.reset-password', [
            'token' => $token,
            'email' => $decodedEmail,
        ]);
    }
    public function resetPassword()
    {
        $input = request()->all();

        $token = $input['token'];
        $email = $input['email'];
        $password = $input['password'];
        $confirmPassword = $input['password_confirmation'];

        if (!$token || !$confirmPassword) {
            flash()->error('All fields are required.');
            return redirect("/reset-password/{$input['token']}/" . rawurlencode($input['email']));
        }
    
        if ($password !== $confirmPassword) {
            flash()->error('Password confirmation does not match.');
            return redirect("/reset-password/{$input['token']}/" . rawurlencode($input['email']));
        }
    
        $decodedEmail = urldecode($email);
        $allTokens = Session::get('reset_password_tokens', []);
        $savedToken = $allTokens[$decodedEmail] ?? null;

        if (!$savedToken || $savedToken !== $token) {
            flash()->error('Invalid or expired reset token.');
            return redirect('/forgot-password');
        }
    
        $user = User::findBy('email', $decodedEmail);
        if (!$user) {
            flash()->error('User not found.');
            return redirect('/forgot-password');
        }

        User::updateBy('email', $user->email, ['password' => bcrypt($password)]);

        Session::remove("reset_password_tokens.{$decodedEmail}");
    
        flash()->success('Your password has been reset successfully.');
        return redirect('/login');

    }
    public function submitLogin()
    {
        $input = request()->all();
    
        $errors = validate($input, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (!empty($errors)) {
            flash()->error($errors);
            return redirect('/login');
        }
    
        $user = User::findBy('email', $input['email']);
    
        if (!isset($user->password) || !hash_check($input['password'], $user->password)) {
            flash()->error('Wrong email or password!');
            return redirect('/login');
        }
    
        if (is_email_verification_enabled() && !$user->email_verified) {
            flash()->error('Please verify your email before logging in.');
            return redirect('/login');
        }

        Session::regenerate();

        Session::set('user', $user);  
        
        return redirect('/dashboard');
    }
    public function submitRegister()
    {
        $input = request()->all();
    
        $errors = validate($input, [
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
    
        if (!empty($errors)) {
            flash()->error($errors);
            return redirect('/register');
        }
    
        if (User::findBy('email', $input['email'])) {
            flash()->error('Email was already used by another account!');
            return redirect('/register');
        }
    
        User::create([
            'user_id' => uvid(8),
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'email_verified' => is_email_verification_enabled() ? false : true,
        ]);
    
        if (is_email_verification_enabled()) {
            Session::set('email', $input['email']);
            send_verification_code($input['email']);
            return redirect('/verify-email');
        }
    
        $user = User::findBy('email', $input['email']);

        Session::regenerate();
        
        Session::set('user', $user);
    
        return redirect('/dashboard');
    }
    public function resendCode()
    {
        $email = session()->email ?? null;

        if (!$email) {
            flash()->error('Your session has expired. Please log in again.');
            return redirect('/login');
        }

        Session::set("verification_attempt.{$email}", 0);

        send_verification_code($email);

        flash()->success('A new verification code has been sent to your email.');
        return redirect('/verify-email');
    }
    public function submitVerifyEmail()
    {
        $inputCode = request()->post('code');

        $email = session()->email;

        $storedCodes = session()->verification_code;

        $attempts = Session::get('verification_attempt') ?? [];
    
        $expectedCode = $storedCodes[$email] ?? null;

        $currentAttempt = $attempts[$email] ?? 0;
    
        if (!$expectedCode) {
            flash()->error('Verification code not found for this email.');
            return redirect('/verify-email');
        }
    
        if ($currentAttempt >= 3) {
            flash()->error('You have exceeded the maximum number of attempts (3). Please request a new code.');
            return redirect('/verify-email');
        }
    
        if ((string) $inputCode !== (string) $expectedCode) {
            $_SESSION['verification_attempt'][$email] = $currentAttempt + 1;
            $remainingAttempts = 2 - $currentAttempt;
    
            flash()->error("Incorrect verification code. You have {$remainingAttempts} attempt(s) left.");
            return redirect('/verify-email');
        }
    
        User::updateBy('email', $email, ['email_verified' => true]);
    
        flash()->success('Email successfully verified. Please login.');

        return redirect('/login');
    } 
    public function logout()
    {
        Session::destroy();
        return redirect('/');
    }

}