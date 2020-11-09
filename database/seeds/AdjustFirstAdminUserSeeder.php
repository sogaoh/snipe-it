<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AdjustFirstAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstAdminUser = User::find(1);
        $firstAdminUser->username = 'admin';
        $firstAdminUser->permissions = json_encode(['superuser' => 1]);
        $firstAdminUser->save();
    }
}
