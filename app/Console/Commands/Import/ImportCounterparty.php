<?php

namespace App\Console\Commands\Import;

use App\Models\Counteragent;
use App\Models\Counterparty;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCounterparty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:counterparty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import counterparty';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldDB = DB::connection('old')->table('counterparties')->get();

        foreach ($oldDB as $oldCounterparty) {
            $counterparty = Counterparty::updateOrCreate(
                ['id' => $oldCounterparty->id],
                [
                    'name' => $oldCounterparty->name_1c,
                    'id_1c' => $oldCounterparty->id_1c,
                    'user_id' => $oldCounterparty->user_id,
                    'created_at' => $oldCounterparty->created_at,

                ]
            );



        }

        return 0;
    }
}
