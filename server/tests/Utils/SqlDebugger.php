<?php


namespace Tests\Utils;


use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

class SqlDebugger
{

    protected $requestCount = 0;

    public static function __callStatic($name, $arguments)
    {
        $instance = new static;


        if(method_exists($instance, $name)) {
            return call_user_func_array([$instance, $name], $arguments);
        }

        throw new \Exception("The method you called does not exist");
    }

    protected function debug(): void
    {
        DB::listen(function($sql) {
            $format = $this->requestCount + 1 . ") " . $this->getQueryWithBindings($sql);
            dump($format);
            $this->requestCount++;
        });

    }

    protected function stopListening() : void
    {
        dump("========================");
        DB::disableQueryLog();
    }

    protected function getQueryWithBindings(QueryExecuted $queryExecuted) : string
    {
        $query = $queryExecuted->sql;

        foreach ($queryExecuted->bindings as $binding) {
            $from = '/'.preg_quote("?", '/').'/';
            $binding = $this->addQuote($binding);

            $query = preg_replace($from, $binding, $query, 1);
        }

        return $query;
    }

    protected function addQuote(string $binding) : string
    {
        if(is_numeric($binding)) {
            return $binding;
        }

        return "'" . $binding . "'";
    }


}
