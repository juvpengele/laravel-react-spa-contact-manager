<?php


namespace Tests\Utils;


use Illuminate\Support\Facades\DB;

class SqlDebugger
{
    public static function debug(): void
    {
        DB::listen(function($sql) {
            dump($sql->sql);
        });
    }

    public static function stopListening() : void
    {
        dump("========================");
        DB::disableQueryLog();
    }
}
