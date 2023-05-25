<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('pages.profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
      
        try {
          
        $path = 'upload/images/';
        if($request->file('photo')){
            $file = $request->file('photo');
            $filename = time() . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);

            $id = Auth::user()->id;
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'photo' => $path . $filename,
            ]);

            return response()->json([
                    'type' => 'success',
                    'data' => $user,
                    'message' => 'Profile updated successfully'
            ]);
        }
            $id = Auth::user()->id;
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);

            return \response()->json([
                    'type' => 'success',
                    'data' => $user,
                    'message' => 'Profile Berhasil di ubah'
            ]);
        

        } catch (Exception $err) {
            return response()->json([
            'type' => 'error',
            'message' => $err
       ]);
        }
       
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
