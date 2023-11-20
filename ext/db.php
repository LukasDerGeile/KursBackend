<?php
class DB{
    public static function getPdo()
    {
        $user = 'winnert1_schule';
        $pass = 'FEA9PNz3p+tu+8!?MPrP';
        $dbName = 'winnert1_modul295';
        $dbHost = 'modul295.winnert1.dbs.hostpoint.internal';
        return new PDO(sprintf('mysql:host=%s;dbname=%s', $dbHost, $dbName), $user, $pass);
    }
}