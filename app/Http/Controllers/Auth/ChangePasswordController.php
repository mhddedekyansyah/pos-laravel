<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    public function index(){
        return view('pages.change-password.index');
    }

    public function update(ChangePasswordRequest $request){
       
        $user = User::where('email', auth()->user()->email)->first();
        if(!Hash::check($request->old_password, $user->password)){
            throw ValidationException::withMessages([
                'old_password' => 'Your password does not match with our records'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return \response()->json([
            'success' => true,
            'message' => 'Your password has been updated'
        ]);

    }
}
