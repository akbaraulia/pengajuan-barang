<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(60);
        $hashedToken = hash('sha256', $token);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $hashedToken,
            'created_at' => now(),
        ]);

        $resetLink = env('FE_URL') . '/reset-password?token=' . $token . '&email=' . urlencode($request->email);

        Mail::send('emails.password_reset', ['resetLink' => $resetLink, 'token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset Link');
        });

        Log::info('Password reset link generated and email sent', [
            'email' => $request->email,
            'resetLink' => $resetLink,
        ]);

        return response()->json(['message' => 'Password reset link sent.']);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            Log::error('Password reset entry not found for email', ['email' => $request->email]);
            return response()->json(['message' => 'Invalid token.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        event(new PasswordReset($user));

        Log::info('Password reset successful', ['email' => $request->email]);

        return response()->json(['message' => 'Password reset successful.']);
    }
}

