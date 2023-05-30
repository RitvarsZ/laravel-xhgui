<?php
namespace Ritvarsz\LaravelXhgui\Actions;

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ExpireRuns
{
    public function handle() {
        $config = config('xhgui.database');
        $connection = $config['connection'] ?? null;
        $tableResults = $config['table_results'] ?? null;
        $expireAfterDays = $config['expire_after_days'] ?? 0;

        if ($expireAfterDays === 0 || $connection === null) {
            return;
        }

        $expireDate = Date::today()->subDays($expireAfterDays)->toDateTimeString();

        DB::connection($connection)->table($tableResults)->where('request_date', '<', $expireDate)->delete();
    }
}
