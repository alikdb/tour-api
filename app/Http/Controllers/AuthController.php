<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Kullanıcı Girişi
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Giriş başarılı',
                'token' => $token
            ], 200);
        }

        return response()->json(['message' => 'Geçersiz kimlik bilgileri'], 401);
    }

    public function createOperator(Request $request)
    {

        // Superadmin Permission Check
        if (Auth::user()->role != 'superadmin') {
            return response()->json([
                'message' => 'Yetkiniz yok'
            ], 403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        // Check if user already exists
        if ($user) {
            return response()->json([
                'message' => 'Bu e-posta adresi zaten kullanımda'
            ], 409);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'operator'
        ]);

        return response()->json([
            'message' => 'Operatör başarıyla oluşturuldu',
        ], 201);
    }

    // Kullanıcı Çıkışı
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Çıkış başarılı'], 200);
    }
}
