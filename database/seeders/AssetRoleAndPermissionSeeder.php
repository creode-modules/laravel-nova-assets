<?php

namespace Database\Seeders;

use Creode\PermissionsSeeder\PermissionsSeeder;

class AssetRoleAndPermissionSeeder extends PermissionsSeeder {
    /**
     * {@inheritdoc}
     */
    protected function getPermissionGroup(): string {
        return 'Asset';
    }
}
