<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->generateNewUser();
    }

    /**
     * generate new user
     * @throws Exception
     */
    private function generateNewUser()
    {
        DB::beginTransaction();
        try {
//            User::factory()->count(1)->create();
            User::factory()->count(2)->create();
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            throw new Exception('Have exception when generate user');
        }
    }
}
