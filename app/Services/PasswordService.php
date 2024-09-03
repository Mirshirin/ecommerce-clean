<?php 
namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordService
{
    public function changePassword(User $user, string $oldPassword, string $newPassword): bool
    {
        if (!Hash::check($oldPassword, $user->password)) {
            return false;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return true;
    }
}
