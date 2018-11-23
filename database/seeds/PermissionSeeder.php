<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Permission::create([
            'title' => 'admin.sudo',
            'alias' => 'Super Admin',
            'active' => 1,
        ]);
        \App\Permission::create([
            'title' => 'admin.filemanager',
            'alias' => 'Pristup filemanageru',
            'active' => 1,
        ]);
        \App\Permission::create([
            'title' => 'admin.panel',
            'alias' => 'Pristup Admin panelu',
            'active' => 1,
        ]);
    }
}
