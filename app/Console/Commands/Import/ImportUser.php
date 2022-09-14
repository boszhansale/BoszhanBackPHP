<?php

namespace App\Console\Commands\Import;

use App\Models\DriverSalesrep;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldUsers = DB::connection('old')->table('users')->get();

        foreach ($oldUsers as $oldUser) {
            $user = User::updateOrCreate(
                ['id' => $oldUser->id],
                [
                    'login' => $oldUser->email,
                    'name' => $oldUser->full_name,
                    'password' => \Hash::make(123456),
                    'id_1c' => $oldUser->id_1c,
                    'created_at' => $oldUser->created_at,
                    'device_token' => $oldUser->device_token,
                    'winning_access' => $oldUser->winning_access,
                    'payout_access' => $oldUser->payout_access,
                ]
            );
            $user->userRoles()->firstOrCreate(
                ['role_id' => $oldUser->role],
                ['role_id' => $oldUser->role]
            );
        }

        $realinships = DB::connection('old')->table('driver_store_representatives')->get();

        foreach ($realinships as $realinship) {
            DriverSalesrep::updateOrCreate(
                ['id' => $realinship->id],
                [
                    'id' => $realinship->id,
                    'driver_id' => $realinship->driver_id,
                    'salesrep_id' => $realinship->store_representative_id,
                ]
            );
        }

        return 0;
    }
}
