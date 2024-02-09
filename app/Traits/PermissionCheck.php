<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
trait PermissionCheck
{
    public function hasPermission($permission)
    {
        $user = Auth::user();
        $role = $user->roles->first();
        //$role = Role::where('name',$role_id)->first();
        if ($role->hasPermissionTo($permission)) {
            return true; // User's role has the permission
        }
        return false; // User's role doesn't have the required permission
    }

}

    ?>
