<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\OTPMail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\UserRoleManagement;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
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
                        $fail("The {$attribute} must be a valid email.");
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
            'email_or_phone.required' => 'Email Field is required.',
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
        // dd($currentTime);
        // $nepalitime = $currentTime->addHours(5)->addMinutes(45);
        $user->otp_code = $otp_code;
        $user->otp_code_expires_at = $currentTime->addMinutes(2);
        $user->otp_code_send_at = $currentTime;


        $user->save();

        // Send OTP via email or SMS
        if (!empty($user->email)) {
            Mail::to($user->email)->send(new OTPMail($otp_code, $user->name));
        } else {
            // $sid = 'AC8565260e8d93857d460fed75146ae02c';
            // $token = 'd6f7ff90bb46d865eda6359aca75898c';
            // $from = '+19549515486';
            // $client = new Client($sid, $token);
            // $phoneNumber = !preg_match('/^\+977/', $user->phone) ? '+977' . ltrim($user->phone, '0') : $user->phone;

            // $client->messages->create(
            //     $phoneNumber,
            //     [
            //         'from' => $from,
            //         'body' => "Your OTP code is: $otp_code",
            //     ]
            // );
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
            // $nepalitime = $curentTime->addHours(5)->addMinutes(45);
            if ($user->otp_code_expires_at < $curentTime) {
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

        $user = User::where('id', $request->user_id)->first();
        if ($user->otp_code_expires_at > $currentTime) {
            return redirect()->back()->with('error', 'OTP code  has been sent successfully, Please wait for');
        }

        $otp_code = random_int(100000, 999999);
        $user->otp_code = $otp_code;
        $currentTime = Carbon::now();
        // $nepalitime = $currentTime->addHours(5)->addMinutes(45);
        $user->otp_code_expires_at = $currentTime->addMinutes(2);
        $user->otp_code_send_at = $nepalitime;
        Mail::to($user->email)->send(new OTPMail($otp_code, $user->name));
        $user->save();
        session()->put('email', $user->email);

        return redirect()->route('otp', ['user' => $user->id])->with('success', 'OTP code sent successfully');
    }

    // public function login_store(Request $request)
    // {
    //     // Define the rate limiter key based on the user's IP address
    //     $key = 'login-attempts:' . $request->ip();


    //     // Define maximum attempts and decay time (e.g., 4 attempts per 5 minutes)
    //     $maxAttempts = 5;
    //     $decaySeconds = 120; // 2 minutes

    //     // Check if the user has exceeded the login attempt limit
    //     if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
    //         $seconds = RateLimiter::availableIn($key);
    //         $minutes = ceil($seconds / 60);
    //         return redirect()->back()->withErrors([
    //             'error' => "Too many attempts. Please try again after {$minutes} minute(s)."
    //         ])->withInput();
    //     }

    //     // Validate input with custom error messages
    //     $validated = $request->validate([
    //         'login_field' => ['required'],
    //         'password' => ['required'],
    //     ], [
    //         'login_field.required' => 'The email  field is required.',
    //         'password.required' => 'The password field is required.',
    //     ]);

    //     // Determine if the login_field is an email or phone
    //     $loginType = filter_var($validated['login_field'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

    //     try {
    //         // Attempt to log in the user
    //         if (Auth::attempt([$loginType => $validated['login_field'], 'password' => $validated['password']])) {

    //             $user = Auth::user();
    //             // Check if OTP is verified
    //             if ($user->otp_is_verified) {
    //                 // Clear the rate limiter on successful login
    //                 RateLimiter::clear($key);

    //                 // Redirect to the dashboard

    //                 $user_role_name = UserRoleManagement::where('id', $user->role_id)->first()->role_name;
    //                 switch ($user_role_name) {
    //                     case 'Super Admin':
    //                         return redirect()->route('super.admin.dashboard')->with('success', $user->name . ', ' . 'Login successfully');
    //                         break;

    //                     case 'Admin':
    //                         return redirect()->route('admin.dashboard')->with('success', $user->name . ', ' . 'Login successfully');
    //                         break;

    //                     case 'User':
    //                         return redirect()->route('index')->with('success', $user->name . ', ' . 'Login successfully');
    //                         break;

    //                     default:
    //                         return redirect()->route('index')->with('success', $user->name . ', ' . 'Login successfully');
    //                         break;
    //                 }


    //                 if ($user->role_id == 1) {

    //                 }
    //                 return redirect()->route('index')->with('success', $user->name . ', ' . 'Login successfully');
    //             } else {
    //                 // If OTP is not verified, log out the user and redirect to OTP page
    //                 Auth::logout();
    //                 return redirect()->route('otp', ['user' => $user->id])
    //                     ->with('info', 'Please verify the OTP to complete your login.');
    //             }
    //         } else {
    //             // Increment the rate limiter on failed login attempt
    //             RateLimiter::hit($key, $decaySeconds);
    //             return redirect()->back()->withErrors([
    //                 'error' => "The provided credentials are incorrect.",
    //             ])->withInput();
    //         }
    //     } catch (\Exception $e) {
    //         // Handle unexpected exceptions
    //         return redirect()->back()->withErrors([
    //             'error' => 'An unexpected error occurred. Please try again later.',
    //         ])->withInput();
    //     }
    // }




    // public function login_store(Request $request)
    // {
    //     $key = 'login-attempts:' . $request->ip() . ':' . $request->login_field;
    //     $maxAttempts = 5;
    //     $decaySeconds = 120;

    //     if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
    //         $seconds = RateLimiter::availableIn($key);
    //         $minutes = ceil($seconds / 60);
    //         return redirect()->back()->withErrors([
    //             'error' => "Too many attempts. Please try again after {$minutes} minute(s)."
    //         ])->withInput();
    //     }

    //     $validated = $request->validate([
    //         'login_field' => ['required', 'string', 'max:255'],
    //         'password' => ['required'],
    //     ], [
    //         'login_field.required' => 'The email or phone field is required.',
    //         'password.required' => 'The password field is required.',
    //     ]);

    //     $loginType = $this->determineLoginType($validated['login_field']);

    //     try {
    //         if (Auth::attempt([$loginType => $validated['login_field'], 'password' => $validated['password']])) {
    //             $user = Auth::user();

    //             if ($user->otp_is_verified) {
    //                 RateLimiter::clear($key);
    //                 $userRole = cache()->remember("role_name_{$user->role_id}", now()->addMinutes(30), function () use ($user) {
    //                     return UserRoleManagement::where('id', $user->role_id)->value('role_name');
    //                 });

    //                 switch ($userRole) {
    //                     case 'Super Admin':
    //                         return redirect()->route('super.admin.dashboard')->with('success', "{$user->name}, Login successfully");
    //                     case 'Admin':
    //                         return redirect()->route('admin.dashboard')->with('success', "{$user->name}, Login successfully");
    //                     case 'User':
    //                         return redirect()->route('index')->with('success', "{$user->name}, Login successfully");
    //                     default:
    //                         Log::warning("Unexpected role ID: {$user->role_id}");
    //                         return redirect()->route('index')->with('success', "{$user->name}, Login successfully");
    //                 }
    //             } else {
    //                 Auth::logout();
    //                 return redirect()->route('otp', ['user' => encrypt($user->id)])
    //                     ->with('info', 'Please verify the OTP to complete your login.');
    //             }
    //         } else {
    //             RateLimiter::hit($key, $decaySeconds);
    //             return redirect()->back()->withErrors([
    //                 'error' => 'The provided credentials are incorrect.',
    //             ])->withInput();
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Login error: ' . $e->getMessage());
    //         return redirect()->back()->withErrors([
    //             'error' => 'An unexpected error occurred. Please try again later.',
    //         ])->withInput();
    //     }
    // }


    public function login_store(Request $request)
    {
        $redirect_url = session()->get('redirectUrl');
        $key = 'login-attempts:' . $request->ip() . ':' . $request->login_field;
        $maxAttempts = 5;
        $decaySeconds = 120;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            return redirect()->back()->withErrors([
                'error' => "Too many attempts. Please try again after {$minutes} minute(s)."
            ])->withInput();
        }

        $validated = $request->validate([
            'login_field' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ], [
            'login_field.required' => 'The email or phone field is required.',
            'password.required' => 'The password field is required.',
        ]);

        $loginType = $this->determineLoginType($validated['login_field']);

        $user = User::where($loginType, $validated['login_field'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            RateLimiter::hit($key, $decaySeconds);
            return redirect()->back()->withErrors(['error' => 'Invalid credentials.'])->withInput();
        }

        try {
            if (Auth::attempt([$loginType => $validated['login_field'], 'password' => $validated['password']])) {
                $user = Auth::user();

                if (!$user->otp_is_verified) {
                    Auth::logout();
                    return redirect()->route('otp', ['user' => encrypt($user->id)])
                        ->with('info', 'Please verify the OTP to complete your login.');
                }

                RateLimiter::clear($key);

                $userRole = cache()->remember("role_name_{$user->role_id}", now()->addMinutes(30), function () use ($user) {
                    return UserRoleManagement::where('id', $user->role_id)->value('role_name');
                });

                session()->forget('redirectUrl');

                return match ($userRole) {
                    'Super Admin' => redirect()->route('super.admin.dashboard')->with('success', "{$user->name}, Login successfully"),
                    'Admin' => redirect()->route('admin.dashboard')->with('success', "{$user->name}, Login successfully"),
                    'User' => $redirect_url ? redirect($redirect_url)->with('success', "{$user->name}, Login successfully") : redirect()->route('index')->with('success', "{$user->name}, Login successfully"),
                    default => throw new \Exception("Unexpected role: {$userRole}")
                };
            }
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return redirect()->back()->withErrors([
                'error' => 'An unexpected error occurred. Please try again later.',
            ])->withInput();
        }
    }

    private function determineLoginType($loginField)
    {
        return filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();
        return redirect()->route('index')->with('success', 'Logout Successfully');
    }

    // private function sendOtpToPhone($phone, $otp_code)
    // {

    //     $sid = 'VA1f7ba1b6972703339187b29702f80658';
    //     $token = 'f187698ee55755622dc6bf81b7364a67';
    //     $from = '9819113548';

    //     $client = new Client($sid, $token);

    //     $client->messages->create(
    //         $phone, // The phone number where you want to send the OTP
    //         [
    //             'from' => $from,
    //             'body' => "Your OTP code is: $otp_code"
    //         ]
    //     );
    //     return true;
    // }

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

                // If the user exists, log them in
                $redirect_url = session()->get('redirectUrl');
                session()->forget('redirectUrl');

                Auth::login($existingUser);
                if ($redirect_url) {
                    return redirect($redirect_url)->with('success', 'Login successfully');
                }

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
                // $nepaliTime = $currentTime->addHours(5)->addMinutes(45);

                $newUser->otp_code = $otp;
                $newUser->otp_code_expires_at = $currentTime->addMinutes(2);
                $newUser->otp_code_send_at = $currentTime;
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
        return view('auth.change-password');
    }
    // Validate input
    // $request->validate([
    //     'current_password' => 'required|min:8',
    //     'new_password' => [
    //         'required',
    //         'min:8',
    //         'different:current_password',
    //         'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
    //     ],
    //     'password_confirmation' => 'required|min:8|same:new_password',
    // ], [
    //     'new_password.regex' => 'The password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character (e.g., @$!%*?&).'
    // ]);

    public function changePasswordPost(Request $request)
    {

        $key = 'change-password-attempts:' . $request->ip();

        // Check rate limiting
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with(['error' => 'Too many attempts. Please try again after ' . ceil($seconds / 60) . ' minutes.']);
        }

        try {
            // Validate request inputs
            $request->validate([
                'current_password' => 'required|min:8',
                'new_password' => [
                    'required',
                    'min:8',
                    'different:current_password',
                ],
                'password_confirmation' => 'required|min:8|same:new_password',
            ]);

            // Check if the current password entered by the user matches the stored password
            if (!Hash::check($request->current_password, Auth::user()->password)) {
                RateLimiter::hit($key, 120); // Lockout after failure for 2 minutes
                dd(Hash::check($request->current_password, Auth::user()->password));
                return back()->with(['error' => 'Current password is incorrect.'])->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }

            // Save the new password and clear the rate limiter
            Auth::user()->update(['password' => Hash::make($request->new_password)]);
            RateLimiter::clear($key);

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->flush();

            // Redirect to the login page

            return redirect()->route('login')->with('success', 'Password changed successfully. Please login again.');
        } catch (ValidationException $e) {
            RateLimiter::hit($key, 120); // Rate limiter on validation failure
            throw $e;
        } catch (\Exception $e) {
            RateLimiter::hit($key, 120); // Rate limiter on unexpected failure
            // Log the error for debugging in production
            Log::error('Password change error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again later.']);
        }
    }





    public function showVerificationPage()
    {
        return view('auth.normal-forgot-password');
    }


    public function forgot_password(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('forgot-password')->with('error', 'User not found');
        }

        $user->otp_code = random_int(100000, 999999);
        $currentTime = Carbon::now();
        $user->otp_is_verified = 0;
        $user->otp_code_expires_at = $currentTime->addMinutes(2);
        $user->otp_code_send_at = $currentTime;
        Mail::to($user->email)->send(new OTPMail($user->otp_code, $user->name));

        $user->save();
        $formattedOtpExpire = Carbon::parse($user->otp_code_expires_at)->format('Y-m-d H:i:s');
        session()->put('formattedOtpExpire', $formattedOtpExpire);
        session()->put('email', $user->email);
        return redirect()->route('otp.verification')->with('success', 'OTP code sent successfully');
    }

    public function showOtpVerificationPage()
    {
        $formattedOtpExpire = session()->get('formattedOtpExpire');

        if (!$formattedOtpExpire) {
            return redirect()->route('forgot-password')->with('error', 'Email not found');
        }

        return view('auth.otp-verification-forgot', compact('formattedOtpExpire'));
    }

    public function verify_otp_forgot(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', session()->get('email'))->first();

        if ($user) {
            if ($user->otp_code == $request->otp_code) {
                $user->otp_is_verified = 1;
                $user->save();
                return redirect()->route('reset-password')->with('success', 'OTP verified successfully. You can change your password.');
            } else {
                return redirect()->route('otp.verification')->withErrors(['otp_code' => 'Invalid OTP code.']);
            }
        }
    }

    public function showChangeCredentialsPage()
    {
        return view('auth.reset-password');
    }

    public function changeCredentials(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:new_password',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        Session::forget('email');



        return redirect()->route('login')->with('success', 'Password changed successfully. Please login again as employee.');
    }

    /**
     * Resends the OTP code to the user when the user clicks on the resend OTP button while forgot password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function resend_otp_forgot(Request $request)
    {
        $user = User::where('email', session()->get('email'))->first();

        if (!$user) {
            return redirect()->route('forgot-password')->with('error', 'User not found');
        }
        if ($user->otp_code_expires_at > Carbon::now()) {
            return redirect()->route('otp.verification')->with('error', 'OTP code is still valid. Please wait.');
        }

        $currentTime = Carbon::now();
        $user->otp_code = random_int(100000, 999999);
        $user->otp_is_verified = 0;
        $user->otp_code_expires_at = $currentTime->addMinutes(2);
        $user->otp_code_send_at = $currentTime;
        Mail::to($user->email)->send(new OTPMail($user->otp_code, $user->name));
        $user->save();
        $formattedOtpExpire = Carbon::parse($user->otp_code_expires_at)->format('Y-m-d H:i:s');
        session()->put('formattedOtpExpire', $formattedOtpExpire);
        return redirect()->route('otp.verification')->with('success', 'OTP code sent successfully');
    }
}
