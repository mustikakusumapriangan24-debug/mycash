<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if (!$user->role) {
                continue;
            }

            $role = Role::where('name', $user->role)
                ->where('guard_name', 'web')
                ->first();

            if ($role) {
                $user->syncRoles([$role]);
            }
        }
    }
}