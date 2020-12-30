'connections' => [

/*'testing' => [
    'driver' => 'sqlite',
    'database' => ':memory:',
],*/


'mysql' => [
    'driver'    => 'mysql',
    'host'      => env('DB_HOST', 'eu-cdbr-west-03.cleardb.net'),
    'port'      => env('DB_PORT', 3306),
    'database'  => env('DB_DATABASE', 'heroku_013d496fdfab528'),
    'username'  => env('DB_USERNAME', 'b1fc6bda7644c0'),
    'password'  => env('DB_PASSWORD', 'f79bc15b'),
    'charset'   => env('DB_CHARSET', 'utf8'),
    'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
    'prefix'    => env('DB_PREFIX', ''),
    'timezone'  => env('DB_TIMEZONE', '+00:00'),
    'strict'    => env('DB_STRICT_MODE', false),
],

]