<?php

namespace Creode\LaravelNovaAssets\Policies;

use App\Models\User;
use Creode\LaravelAssets\Models\Asset as AssetModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $user->hasPermissionTo('viewAnyAsset');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, AssetModel $asset): bool
    {
        return $user->hasPermissionTo('viewAsset');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return $user->hasPermissionTo('createAsset');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, AssetModel $asset): bool
    {
        return $user->hasPermissionTo('updateAsset');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, AssetModel $asset): bool
    {
        return $user->hasPermissionTo('deleteAsset');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Authenticatable $user, AssetModel $asset): bool
    {
        return $user->hasPermissionTo('updateAsset');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AssetModel $asset): bool
    {
        return $user->hasPermissionTo('destroyAsset');
    }
}
