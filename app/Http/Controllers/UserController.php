<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class UserController extends Controller {
	public function welcome() {
		return Inertia::render('Welcome');
	}

	public function RegistrationPage() {
		return Inertia::render('RegistrationForm');
	}

	public function LoginPage() {
		return Inertia::render('LoginForm');
	}

	public function ForgotPasswordPage() {
		return Inertia::render('ForgotPasswordForm');
	}

	public function ResetPasswordPage() {
		return Inertia::render('ResetPasswordForm');
	}

	public function OTPVerificationPage() {
		return Inertia::render('OTPVerificationForm');
	}

	public function ProfilePage() {
		return Inertia::render('UserProfile');
	}

	public function UserRegistration(Request $request) {
		try {

			User::create([
				'firstName' => $request->input('firstName'),
				'lastName'  => $request->input('lastName'),
				'email'     => $request->input('email'),
				'phone'     => $request->input('phone'),
				'password'  => $request->input('password'),
			]);

			return response()->json([
				'status'  => 'success',
				'message' => 'User created successfully!',
			]);
		} catch (Exception $e) {
			return response()->json([
				'status'  => 'Failed',
				'message' => $e->getMessage(),
			]);
		}
	}

	public function UserLogin(Request $request) {
		$count = User::where([
			'email'    => $request->input('email'),
			'password' => $request->input('password'),
		])->select('id')->first();

		if ($count !== null) {
			// User Login Success -> JWT Token issue
			$token = JWTToken::CreateToken($request->input('email'), $count->id);
			return response()->json([
				'status'  => 'success',
				'message' => 'User login successfully!',
			])->cookie('token', $token, 3600 * 24);
		} else {
			return response()->json([
				'status'  => 'Failed',
				'message' => 'Unauthorized access!',
			]);
		}
	}

	function SendOtpCOde(Request $request) {
		$email = $request->input('email');
		$otp   = rand(1000, 9999);
		$count = User::where('email', '=', $email)->count();
		if ($count == 1) {
			//OTP Mail Send
			Mail::to($email)->send(new OTPMail($otp));
			// OTP Code Insert Table
			User::where('email', '=', $email)->update(['otp' => $otp]);
			return response()->json([
				'status'  => 'success',
				'message' => 'OTP sent successfully!',
			]);
		} else {
			return response()->json([
				'status'  => 'Failed',
				'message' => 'Invalid email!',
			]);
		}
	}

	function VerifyOtpCOde(Request $request) {
		$email = $request->input('email');
		$otp   = $request->input('otp');
		$count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();
		if ($count == 1) {
			// Convert the 'updated_at' string to a Unix timestamp
			$updatedAtTimestamp = intval(strtotime($request->input('updated_at')));
			$newTime            = intval(time());

			// Check if OTP is expired (5 minutes = 60 * 5 seconds)
			if ($updatedAtTimestamp < $newTime - 60 * 5) {
				// OTP Code Update Table
				User::where('email', '=', $email)->update(['otp' => '0']);

				// Password Reset Token issue
				$token = JWTToken::CreateTokenForSetPassword($email);

				return response()->json([
					'status'  => 'success',
					'message' => 'OTP verified successfully!',
				])->cookie('token', $token, 3600 * 24);
			} else {
				User::where('email', '=', $email)->update(['otp' => '0']);

				return response()->json([
					'status'  => 'Failed',
					'message' => 'Invalid OTP!',
				]);
			}
		} else {
			return response()->json([
				'status'  => 'Failed',
				'message' => 'Invalid OTP!',
			]);
		}
	}

	function ResetPassword(Request $request) {
		try {
			$email    = $request->header('email');
			$password = $request->input('password');

			User::where('email', '=', $email)->update(['password' => $password]);

			return response()->json([
				'status'  => 'success',
				'message' => 'Password reset successfully!',
			]);
		} catch (Exception $e) {
			return response()->json([
				'status'  => 'Failed',
				'message' => $e->getMessage(),
			]);
		}
	}

	function UserLogout(Request $request) {
		return redirect('/login')->cookie('token', '', -1);
	}

	function UserProfile(Request $request) {
		$email = $request->header('email');
		$user  = User::where('email', '=', $email)->first();
		return response()->json([
			'status'  => 'success',
			'message' => 'Request successful!',
			'data'    => $user,
		]);
	}

	function UpdateProfile(Request $request) {
		try {
			$email     = $request->header('email');
			$firstName = $request->input('firstName');
			$lastName  = $request->input('lastName');
			$phone     = $request->input('phone');
			$password  = $request->input('password');

			User::where('email', '=', $email)->update([
				'firstName' => $firstName,
				'lastName'  => $lastName,
				'phone'     => $phone,
				'password'  => $password,
			]);

			return response()->json([
				'status'  => 'success',
				'message' => 'Profile updated successfully!',
			]);
		} catch (Exception $e) {
			return response()->json([
				'status'  => 'Failed',
				'message' => $e->getMessage(),
			]);
		}
	}

}
