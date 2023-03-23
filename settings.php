<?php

namespace yusovmax;

class databaseSettings
{
    const HOST = 'localhost';
    const DBNAME = 'umi9956';
    const USERNAME = 'umi777';
    const PASSWORD = '13579XyZ';
    const TABLES = [
      "category" => "mycache_category",
      "check" => "mycache_check"
    ];
    
    public static function getHost()
    {
        return self::HOST;
    }
}
