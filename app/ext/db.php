<?php
/**
 * [Description DB]
 */
class DB {
    /**
     * @return PDO|null
     */
    public static function getPdo()
    {
        $user = 'winnert1_schule';
        $pass = 'FEA9PNz3p+tu+8!?MPrP';
        $dbName = 'winnert1_modul295';
        $dbHost = 'modul295.winnert1.dbs.hostpoint.internal';

        try {
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return null;
        }
    }
}
?>
