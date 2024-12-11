<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\OTPMail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\UserRoleManagement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\RateLimiter;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }
    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Display the registration view.
     *
     * @return \Illuminate\Http\Response
     */
    /******  3becc2c8-0fbd-4669-b91f-f017952ce75b  *******/
    public function register()
    {
        return view('auth.register');
    }

    public function register_store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email_or_phone' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{10,15}$/', $value)) {
                        $fail("The {$attribute} must be a valid email or phone number.");
                    }

                    // Check uniqueness across email and phone columns
                    $emailExists = User::where('email', $value)->exists();
                    $phoneExists = User::where('phone', $value)->exists();

                    if ($emailExists || $phoneExists) {
                        $fail("The {$attribute} is already taken.");
                    }
                },
            ],

            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'same:password'],
        ], [
            'email_or_phone.required' => 'Either email or phone is required.',
        ]);

        // Create a new user instance
        $role_id = UserRoleManagement::where('role_name', 'User')->first()->id;
        $user = new User();
        $user->name = $request->name;

        // Determine if input is email or phone
        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $user->email = $request->email_or_phone;
        } else {
            $user->phone = $request->email_or_phone;
        }
        $user->role_id = $role_id;

        $user->password = Hash::make($request->password);

        // Generate OTP code and set expiry time
        $otp_code = random_int(100000, 999999);
        $currentTime = Carbon::now();
        $nepalitime = $currentTime->addHours(5)->addMinutes(45);
        $user->otp_code = $otp_code;
        $user->otp_code_expires_at = $nepalitime->addMinutes(2);
        $user->otp_code_send_at = $nepalitime;


        $user->save();

        // Send OTP via email or SMS
        if (!empty($user->email)) {
            Mail::to($user->email)->send(new OTPMail($otp_code, $user->name));
        } else {
            $sid = 'AC8565260e8d93857d460fed75146ae02c';
            $token = 'd6f7ff90bb46d865eda6359aca75898c';
            $from = '+19549515486';
            $client = new Client($sid, $token);
            $phoneNumber = !preg_match('/^\+977/', $user->phone) ? '+977' . ltrim($user->phone, '0') : $user->phone;

            $client->messages->create(
                $phoneNumber,
                [
                    'from' => $from,
                    'body' => "Your OTP code is: $otp_code",
                ]
            );
        }
        session()->put('email', $user->email);

        return redirect()->route('otp')
            ->with('success', 'Registration successful. OTP sent successfully.');
    }


    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Displays the OTP verification page.
     *
     * The OTP verification page allows the user to enter the OTP code
     * sent to their email or phone number. It displays the expiry time of
     * the OTP code and allows the user to enter the OTP code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /******  29344bf8-1391-4974-8175-956b23d243d9  *******/
    public function otp_page(Request $request)
    {
        $email = $request->session()->get('email');

        $id = User::where('email', $email)->pluck('id')->first();
        $otpExpire = User::where('id', $id)->pluck('otp_code_expires_at')->first();
        $formattedOtpExpire = \Carbon\Carbon::parse($otpExpire)->format('Y-m-d H:i:s');


        return view('auth.normal-otp-verify', compact('formattedOtpExpire', 'id'));
    }


    public function otp_verify(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $user = User::where('id', $user->id)
            ->where('otp_code', $request->otp_code)
            ->first();

        if ($user) {
            $curentTime = Carbon::now();
            $nepalitime = $curentTime->addHours(5)->addMinutes(45);
            if ($user->otp_code_expires_at < $nepalitime) {
                return redirect()->back()->with('error', 'OTP code has expired');
            }
            $user->otp_code = null;
            $user->otp_code_verified_at = now();
            $user->otp_is_verified = 1;
            $user->save();
            Auth::login($user);
            return redirect()->route('index')->with('success', 'OTP code verified successfully and login successfully'); // Redirect to the login page
        } else {
            return redirect()->back()->with('error', 'Invalid OTP code');
        }
    }

    public function resend_otp_page(Request $request)
    {
        $currentTime = Carbon::now();
        $nepalitime = $currentTime->addHours(5)->addMinutes(45);
        $user = User::where('id', $request->user_id)->first();
        if ($user->otp_code_expires_at > $nepalitime) {
            return redirect()->back()->with('error', 'OTP code  has been sent successfully, Please wait for 2 minutes');
        }

        $otp_code = random_int(100000, 999999);
        $user->otp_code = $otp_code;
        $currentTime = Carbon::now();
        $nepalitime = $currentTime->addHours(5)->addMinutes(45);
        $user->otp_code_expires_at = $nepalitime->addMinutes(2);
        $user->otp_code_send_at = $nepalitime;
        Mail::to($user->email)->send(new OTPMail($otp_code, $user->name));
        $user->save();
        session()->put('email', $user->email);

        return redirect()->route('otp', ['user' => $user->id])->with('success', 'OTP code sent successfully');
    }




    public function login_store(Request $request)
    {
        // Define the rate limiter key based on the user's IP address
        $key = 'login-attempts:' . $request->ip();


        // Define maximum attempts and decay time (e.g., 4 attempts per 5 minutes)
        $maxAttempts = 4;
        $decaySeconds = 300; // 5 minutes

        // Check if the user has exceeded the login attempt limit
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            return redirect()->back()->withErrors([
                'error' => "Too many attempts. Please try again after {$minutes} minute(s)."
            ])->withInput();
        }

        // Validate input with custom error messages
        $validated = $request->validate([
            'login_field' => ['required'],
            'password' => ['required'],
        ], [
            'login_field.required' => 'The email or phone field is required.',
            'password.required' => 'The password field is required.',
        ]);

        // Determine if the login_field is an email or phone
        $loginType = filter_var($validated['login_field'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        try {
            // Attempt to log in the user
            if (Auth::attempt([$loginType => $validated['login_field'], 'password' => $validated['password']])) {

                $user = Auth::user();
                dd($user);

                // Check if OTP is verified
                if ($user->otp_is_verified) {
                    // Clear the rate limiter on successful login
                    RateLimiter::clear($key);

                    // Redirect to the dashboard
                    return redirect()->route('dashboard')->with('success', 'Login successful');
                } else {
                    // If OTP is not verified, log out the user and redirect to OTP page
                    Auth::logout();
                    return redirect()->route('otp', ['user' => $user->id])
                        ->with('info', 'Please verify the OTP to complete your login.');
                }
            } else {
                // Increment the rate limiter on failed login attempt
                RateLimiter::hit($key, $decaySeconds);

                return redirect()->back()->withErrors([
                    'login_field' => 'Invalid email/phone or password.',
                ])->withInput();
            }
        } catch (\Exception $e) {
            // Handle unexpected exceptions
            return redirect()->back()->withErrors([
                'error' => 'An unexpected error occurred. Please try again later.',
            ])->withInput();
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout successfully');
    }

    private function sendOtpToPhone($phone, $otp_code)
    {

        $sid = 'VA1f7ba1b6972703339187b29702f80658';
        $token = 'f187698ee55755622dc6bf81b7364a67';
        $from = '9819113548';

        $client = new Client($sid, $token);

        $client->messages->create(
            $phone, // The phone number where you want to send the OTP
            [
                'from' => $from,
                'body' => "Your OTP code is: $otp_code"
            ]
        );
        return true;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {

        try {
            $googleUser = Socialite::driver('google')->user();
            // Check if user already exists in the database
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            if ($existingUser) {

                Auth::login($existingUser);

                return redirect()->route('index')->with('success', 'Login successfully');
            } else {

                $role_id = UserRoleManagement::where('role_name', 'User')->first()->id;

                // If the user doesn't exist, create a new user
                $newUser = User::create([
                    'role_id' => $role_id,
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->avatar,
                    'email_verified_at' => now(),

                ]);

                // Generate OTP
                $otp = random_int(100000, 999999);
                $currentTime = Carbon::now();
                $nepaliTime = $currentTime->addHours(5)->addMinutes(45);

                $newUser->otp_code = $otp;
                $newUser->otp_code_expires_at = $nepaliTime->addMinutes(2);
                $newUser->otp_code_send_at = $nepaliTime;
                $newUser->save();

                // Send OTP via email
                Mail::to($newUser->email)->send(new OTPMail($otp, $newUser->name));

                // Redirect to OTP page
                session()->put('email', $newUser->email);
                return redirect()->route('otp')
                    ->with('success', 'OTP sent to your email.');
            }

        } catch (\Exception $e) {
            // Handle exception
            return redirect()->route('login')->with('error', 'Failed to login with Google.');
        }
    }

    public function changePassword()
    {
        return view('backend.auth.empolyee-change-password');
    }

    public function changePasswordPost(Request $request)
    {

        $key = 'change-password-attempts:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 4)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with(['error' => 'Too many attempts. Please try again after ' . ceil($seconds / 60) . ' minutes.']);
        }
        try {
            $request->validate([
                'current_password' => 'required|min:8',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|min:8|same:new_password',
            ]);
            if (!Hash::check($request->current_password, auth()->guard('employee')->user()->password)) {
                RateLimiter::hit($key, 300); // Set the lockout period to 300 seconds (5 minutes)
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            RateLimiter::hit($key, 300);
            auth()->guard('employee')->user()->update(['password' => Hash::make($request->new_password)]);
            RateLimiter::clear($key);
            Auth::guard('employee')->logout();
            $request->session()->invalidate();
            $request->session()->flush();

            return redirect()->route('employee-login')->with('success', 'Password changed successfully. Please login again.');
        } catch (ValidationException $e) {
            RateLimiter::hit($key, 300);
            throw $e;
        } catch (\Exception $e) {
            RateLimiter::hit($key, 300);
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    // public function logout(Request $request)
    // {
    //     $user = Auth::guard('employee')->user();
    //     if ($user) {
    //         LoginActivities::where('user_id', $user->id)
    //             ->where('user_type', 'employee')
    //             ->whereNull('logout_time')
    //             ->latest()
    //             ->first()
    //             ->update([
    //                 'logout_time' => now()
    //             ]);
    //     }
    //     Auth::guard('employee')->logout();
    //     $request->session()->invalidate();
    //     $request->session()->flush();
    //     return redirect()->route('employee-login')->with('success', 'You have successfully logged out.');
    // }

    public function showVerificationPage()
    {
        return view('backend.auth.email-verification');
    }


    // public function email_verify(Request $request)
    // {
    //     // Validate the email
    //     $request->validate([
    //         'email' => 'required|email|exists:empolyee_users,email',
    //     ]);

    //     // Find the user by email
    //     $user = EmpolyeeUsers::where('email', $request->email)->first();

    //     if ($user) {
    //         // Generate a six-digit OTP code
    //         $otp_code = rand(100000, 999999);

    //         // Save OTP code and set expiration time (e.g., 10 minutes from now)
    //         $user->otp_code = $otp_code;
    //         $user->otp_expires_at = Carbon::now()->addMinutes(10); // OTP expires in 10 minutes
    //         $user->otp_is_verified = 0; // Set as unverified initially
    //         $user->save();

    //         // Prepare email data
    //         $email = $request->email;
    //         $subject = "OTP Verification";
    //         $message = "Your OTP code is: " . $otp_code . ". This code will expire in 10 minutes.";

    //         // Send email with OTP code
    //         Mail::send([], [], function ($message) use ($email, $subject, $otp_code) {
    //             $message->to($email)
    //                 ->subject($subject)
    //                 ->setBody("Your OTP code is: " . $otp_code . ". It will expire in 10 minutes.", 'text/html');
    //         });

    //         return redirect()->route('employee.otp.verification')->with('success', 'OTP has been sent to your email. Please check and verify.');
    //     }
    //     return redirect()->back()->withErrors(['email' => 'There was an issue verifying the email.']);
    // }


    public function email_verify(Request $request)
    {
        // Validate the email
        $request->validate([
            'email' => 'required|email|exists:empolyee_users,email',
        ]);

        // Find the user by email
        $user = EmpolyeeUsers::where('email', $request->email)->first();

        if ($user) {
            // Generate a six-digit OTP code
            $otp_code = rand(100000, 999999);

            // Save OTP code and set expiration time (e.g., 10 minutes from now)
            $user->otp_code = $otp_code;
            $user->otp_expires_at = now()->addMinutes(10); // OTP expires in 10 minutes
            $user->otp_is_verified = 0; // Set as unverified initially
            $user->save();

            // Prepare email data
            $email = $request->email;
            $subject = "OTP Verification";

            // Send email with OTP code
            Mail::send([], [], function (Message $message) use ($email, $subject, $otp_code) {
                $message->to($email)
                    ->subject($subject)
                    ->html("Your OTP code is: " . $otp_code . ". It will expire in 10 minutes.");
            });

            $request->session()->put('email', $email);

            return redirect()->route('employee.otp.verification')->with('success', 'OTP has been sent to your email. Please check and verify the OTP code.');
        }

        return redirect()->back()->withErrors(['email' => 'There was an issue verifying the email.']);
    }


    public function showOtpVerificationPage()
    {
        return view('backend.auth.otp-verification');
    }
    public function resendOtp(Request $request)
    {


        // Get the user's email from the session or request
        $email = $request->session()->get('email'); // Assuming email is stored in session


        if (!$email) {
            return redirect()->route('employee-login')->withErrors(['email' => 'Email not found in session.']);
        }

        // Find the user by email
        $user = EmpolyeeUsers::where('email', $email)->first();

        if ($user) {
            // Generate a new six-digit OTP code
            $otp_code = rand(100000, 999999);

            // Update OTP code and expiration time (e.g., 10 minutes from now)
            $user->otp_code = $otp_code;
            $user->otp_expires_at = Carbon::now()->addMinutes(10); // OTP expires in 10 minutes
            $user->otp_is_verified = 0; // Set as unverified initially
            $user->save();

            // Send OTP via email
            Mail::send([], [], function (Message $message) use ($email, $otp_code) {
                $message->to($email)
                    ->subject("Resend OTP Verification")
                    ->html("Your new OTP code is: " . $otp_code . ". It will expire in 10 minutes.");
            });

            return redirect()->route('employee.otp.verification')->with('success', 'OTP has been resent to your email. Please check and verify the OTP code.');
        }

        return redirect()->route('employee-login')->withErrors(['email' => 'User not found.']);
    }
    // public function otp_verify(Request $request)
    // {

    //     // Validate the OTP code
    //     $request->validate([
    //         'otp_code' => 'required|numeric|digits:6',
    //     ]);

    //     // Find the user by email
    //     $user = EmpolyeeUsers::where('email', $request->session()->get('email'))->first();

    //     if ($user) {
    //         // Verify the OTP code
    //         if ($user->otp_code == $request->otp_code) {
    //             $user->otp_is_verified = 1; // Set as verified
    //             $user->save();

    //             return redirect()->route('employee.change-credentials')->with('success', 'OTP verified successfully. You can change your password.');
    //         } else {
    //             return redirect()->route('employee.otp.verification')->withErrors(['otp_code' => 'Invalid OTP code.']);
    //         }
    //     }
    // }

    public function showChangeCredentialsPage()
    {

        return view('backend.auth.new-password');
    }
    public function changeCredentials(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:empolyee_users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ]);

        $user = EmpolyeeUsers::where('email', $request->email)->select('id')->first();

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->flush();
        return redirect()->route('employee-login')->with('success', 'Password changed successfully. Please login again as employee.');
    }

}
