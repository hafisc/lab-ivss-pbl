<?php
function getDb()
{
    $host = '127.0.0.1';
    $port = '5433';               
    $db   = 'lab_ivss';
    $user = 'USER';          
    $pass = 'Nada140125@';           

    $connection_string = "host=$host port=$port dbname=$db user=$user password=$pass";

    $connection = @pg_connect($connection_string);

    if (!$connection) {
        die('Database connection error: ' . pg_last_error());
    }

    return $connection;
}
