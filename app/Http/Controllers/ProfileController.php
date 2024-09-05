<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Helpers\StatusHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ProfileUpdateInformationRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
          $users=User::all();
            return view('profile.edit', [
            'user' => $request->user(),
            'users'=> $users,
        ]);
    }
    /**
     * @update name and email 
     */
    public function updateinformation(ProfileUpdateInformationRequest $request)
    {
    Log::info('Validated Data:', $request->validated());
        
        $validatedData = $request->validated();
        $user = $request->user();        
      
        // به‌روزرسانی اطلاعات کاربر
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save(); // ذخیره تغییرات در دیتابیس

        // ثبت اطلاعات در لاگ برای بررسی
        Log::info('Update request:1111111111111', $validatedData);
        //session()->flash('success', ' با موفقیت تغییر کرد');

        // هدایت به صفحه محصولات با پیغام موفقیت
        return Redirect::route('products-index')->with('status', 'profile-updated');

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        Log::info('Update request:222222222222222', $request->all());

        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();
        // session()->flash('success', ' با موفقیت تغییر کرد');


        $validatedData = $request->validated();
        $user = $request->user();
        
        // Log the original data
        $userOriginal = clone $user;
        $originalAttributes = $userOriginal->getAttributes();
        Log::info('Before update:', $originalAttributes);
        
        // Log the validated data
        Log::info('Validated data:', $validatedData);
        
        // Log the attributes being updated
        $attributesToUpdate = array_diff_key($validatedData, $originalAttributes);
        Log::info('Attributes to update:', $attributesToUpdate);
        
        // Update the user
        $user->fill($validatedData);
        $user->save();
        
        // Log the final state after saving
        $userUpdated = $user->fresh();
        Log::info('After update:', $userUpdated->getAttributes());
        
        // Log any differences between the original and updated data
        $differences = array_diff_assoc($userOriginal->getAttributes(), $userUpdated->getAttributes());
        Log::info('Differences:', $differences);
        

    // Reset email verification status if email changed
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

   // session()->flash('success', ' با موفقیت تغییر کرد');
   // StatusHelper::setStatusMessage('Profile updated successfully');
//    Log::info('Status message set: ' . StatusHelper::getStatusMessage());

        return Redirect::route('products-index')->with('status', 'profile-updated');
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
