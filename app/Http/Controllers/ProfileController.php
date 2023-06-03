<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Image;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('pages.profile.index', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
      
        if($request->ajax()){
            DB::beginTransaction();
             try {
                $id = Auth::user()->id;
                $user = User::findOrFail($id);
                if($request->file('image')){
                    if (Storage::disk('public')->exists($user->image->image)) {
                        Storage::disk('public')->delete($user->image->image);
                    }
                    $file = $request->file('image');
                    $image = upload('user', $file, 'user');   

                    $user->image()->updateOrCreate([],['image' =>  $image]);
                }

                    $user->update($request->validated());

                    DB::commit();
                    return response()->json([
                            'type' => 'success',
                            'data' => $user->load('image'),
                            'message' => 'Profile Updated succesfully'
                    ]);
              
                } catch (Exception $err) {
                    DB::rollBack();
                    return response()->json([
                    'type' => 'error',
                    'message' => $err
            ]);
        }
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
