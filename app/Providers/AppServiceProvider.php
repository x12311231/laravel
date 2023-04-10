<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function (QueryExecuted $query) {

            $pieceSql = explode('?', $query->sql);
            $sql = $pieceSql[0];
            foreach ($query->bindings as $k => $v) {
                if (is_string($v)) {
                    $v = '"' . $v . '"';
                }
                $sql .= $v . $pieceSql[$k + 1];
            }
            Log::debug("[sql]" . $sql);
//            Log::debug("[sql]" . json_encode($query->bindings));
        });
    }
}
