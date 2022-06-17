<?php

namespace App\Console\Commands\Import;

use App\Models\Counteragent;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCounteragent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:counteragent';

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
        $oldDB = DB::connection('old')->table('counteragents')->get();
        $role = Role::findOrFail(1);
        $users = $role->users;

        foreach ($oldDB as $oldCounteragent) {
            $counteragent = Counteragent::updateOrCreate(
                ['id' => $oldCounteragent->id],
                [
                    'name' => $oldCounteragent->name_1c,
                    'id_1c' => $oldCounteragent->id_1c,
                    'bin' => $oldCounteragent->bin,
                    'created_at' => $oldCounteragent->created_at,
                    'enabled' => $oldCounteragent->status,
                    'price_type_id' => $oldCounteragent->priceStatus,
                    'payment_type_id' => $oldCounteragent->paymentType ?? 1,
                ]
            );

//            $counteragent->counteragentUsers()->delete();
//            $cu = [];
//            foreach ( $users as $user) {
//                $item['user_id'] = $user->id;
//                $cu[] = $item;
//            }
//            $counteragent->counteragentUsers()->createMany($cu);


        }

        return 0;
    }
}
